<!-- 
    p_phisical_info_edit.phpからの入力情報をチェックし、遷移先を決定する。
    問題なし→p_phisical_info_edit_done.phpへリダイレクト
    問題あり→エラーメッセージを出力し、戻るボタンでp_phisical_info_edit.phpへ遷移
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

// p_phisical_info_edit.phpから身体情報を受け取る
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

    // phisical_infoテーブルからplayer_codeとdateを使って情報を検索
    $sql = '
            SELECT * 
            FROM phisical_info 
            WHERE player_code = ? 
            AND date = ?
            ';
    $stmt = $dbh->prepare($sql);
    $data[] = $player_code;
    $data[] = $date;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // db_academyデータベースから切断する
    $dbh = null;
} catch (Exception $e) {
    var_dump($e);
    exit();
}

// 入力内容の問題の有無をflgによって判定(問題なし:true、問題あり:false)
$flg = true;

// 日付について
if ($date == '') {                              // 日付が入力されていない場合
    print '日付が入力されていません<br>';
    $flg = false;
} else if ($rec2 != '') {                       // 入力された日付のデータがすでに存在する場合
    print '同じ日付のデータがすでに存在します<br>';
    $flg = false;
}

// 身長について
if ($height == '') {
    print '身長が入力されていません<br>';
    $flg = false;
}

// 体重について
if ($weight == '') {
    print '体重が入力されていません<br>';
    $flg = false;
}

// 体脂肪率について
if ($body_fat == '') {
    print '体脂肪率が入力されていません<br>';
    $flg = false;
}

// 筋量について
if ($muscle_mass == '') {
    print '筋量が入力されていません<br>';
    $flg = false;
}

if ($flg) {             // 入力に問題がなかった場合
    $_SESSION['date'] = $date;                          // セッション変数にdateを保持
    $_SESSION['height'] = $height;                      // セッション変数にheightを保持
    $_SESSION['weight'] = $weight;                      // セッション変数にweightを保持
    $_SESSION['body_fat'] = $body_fat;                  // セッション変数にbody_fatを保持
    $_SESSION['muscle_mass'] = $muscle_mass;            // セッション変数にmuscle_massを保持
    header('Location:p_phisical_info_edit_done.php');   // p_phisical_info_edit_done.phpへリダイレクト
    exit();
} else {                // 入力に問題があった場合
    print '入力に誤りがあります<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_info_edit.php\'" value="戻る">';
}
