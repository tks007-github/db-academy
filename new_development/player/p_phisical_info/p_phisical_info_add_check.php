<!-- 
    p_phisical_info_add.phpからの入力情報をチェックし、遷移先を決定する。
    問題なし→p_phisical_info_add_done.phpへリダイレクト
    問題あり→エラーメッセージを出力し、戻るボタンでp_phisical_info_add.phpへ遷移
 -->

<?php
session_start();
session_regenerate_id(true);

// SESSION変数からplayer_codeを受け取る
$player_code = $_SESSION['player_code'];

// 自作の関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);
// p_phisical_info_add.phpからPOSTで身体情報を受け取る
$date = $post['date'];
$height = $post['height'];
$weight = $post['weight'];
$body_fat = $post['body_fat'];
$muscle_mass = $post['muscle_mass'];

// DB接続
try {
    // db_academyデータベースに接続する
    $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // phisical_infoテーブルからplayer_codeを使ってdate以前で最新の情報を検索
    $sql1 = '
            SELECT height, weight, body_fat, muscle_mass
            FROM phisical_info 
            WHERE player_code = ?
            AND date = (
            SELECT MAX(date)
            FROM phisical_info
            WHERE player_code = ?
            AND date < ?
            )
            ';
    $stmt1 = $dbh->prepare($sql1);
    $data1[] = $player_code;
    $data1[] = $player_code;
    $data1[] = $date;
    $stmt1->execute($data1);
    $rec1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    // phisical_infoテーブルからplayer_codeとdateを使って情報を検索
    $sql2 = '
            SELECT * 
            FROM phisical_info 
            WHERE player_code = ? 
            AND date = ?
            ';
    $stmt2 = $dbh->prepare($sql2);
    $data2[] = $player_code;
    $data2[] = $date;
    $stmt2->execute($data2);
    $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    // db_academyデータベースから切断する
    $dbh = null;
} catch (Exception $e) {
    var_dump($e);
    exit();
}


// 入力内容の問題の有無をflgによって判定(問題なし:true、問題あり:false)
$flg = true;

// 前回の情報を適用にチェックされているかどうか(チェックあり:true、チェックなし:false)
if ($height == 'on' || $weight == 'on' || $body_fat == 'on' || $muscle_mass == 'on') {
    $last_data_used = true;
} else {
    $last_data_used = false;
}

if ($rec2 != '') {                              // 入力された日付のデータがすでに存在する場合
    print '同じ日付のデータがすでに存在します<br>';
    $flg = false;
} else if ($last_data_used && $rec1 == '') {    // 入力された日付以前の情報(前回の情報)が存在しない場合
    print '入力された日付以前の情報(前回の情報)が存在しません<br>';
    $flg = false;
} else {                                        // 上記以外の場合
    // 身長について
    if ($height == '') {
        print '身長が入力されていません<br>';
        $flg = false;
    } else if ($height == 'on') {
        // 最新のheightの値を代入
        $height = $rec1['height'];
    }

    // 体重について
    if ($weight == '') {
        print '体重が入力されていません<br>';
        $flg = false;
    } else if ($weight == 'on') {
        // 最新のweightの値を代入
        $weight = $rec1['weight'];
    }

    // 体脂肪率について
    if ($body_fat == '') {
        print '体重が入力されていません<br>';
        $flg = false;
    } else if ($body_fat == 'on') {
        // 最新のbody_fatの値を代入
        $body_fat = $rec1['body_fat'];
    }

    // 筋量について
    if ($muscle_mass == '') {
        print '筋量が入力されていません<br>';
        $flg = false;
    } else if ($muscle_mass == 'on') {
        // 最新のmuscle_massの値を代入
        $muscle_mass = $rec1['muscle_mass'];
    }
}


if ($flg) {             // 入力に問題がなかった場合
    $_SESSION['date'] = $date;                          // SESSION変数にdateを保持
    $_SESSION['height'] = $height;                      // SESSION変数にheightを保持
    $_SESSION['weight'] = $weight;                      // SESSION変数にweightを保持
    $_SESSION['body_fat'] = $body_fat;                  // SESSION変数にbody_fatを保持
    $_SESSION['muscle_mass'] = $muscle_mass;            // SESSION変数にmuscle_massを保持
    header('Location:p_phisical_info_add_done.php');    // p_phisical_info_add_done.phpへリダイレクト
    exit();
} else {                // 入力に問題があった場合
    print '<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_info_add.php\'" value="戻る">';
}
