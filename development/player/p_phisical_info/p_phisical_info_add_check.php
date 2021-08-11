<?php
session_start();
session_regenerate_id(true);
$player_code = $_SESSION['player_code'];

try {
    // 自作の関数を呼び出す
    require_once('../../function/function.php');
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);

    // p_phisical_info_add.phpから身体情報を受け取る
    $date = $post['date'];
    $height = $post['height'];
    $weight = $post['weight'];
    $body_fat = $post['body_fat'];
    $muscle_mass = $post['muscle_mass'];

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

    // 入力内容の問題の有無をflgによって判定(問題なし:true、問題あり:false)
    $flg = true;

    if ($date == '') {
        $flg = false;
    } else {
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

        // 同じplayer_codeとdateのデータがすでにある場合
        if ($rec2 != '') {
            $flg = false;
        }
    }

    if ($height == '') {
        $flg = false;
    } else if ($height == 'on') {
        // 最新のheightの値を代入
        $height = $rec1['height'];
    }

    if ($weight == '') {
        $flg = false;
    } else if ($weight == 'on') {
        // 最新のweightの値を代入
        $weight = $rec1['weight'];
    }

    if ($body_fat == '') {
        $flg = false;
    } else if ($body_fat == 'on') {
        // 最新のbody_fatの値を代入
        $body_fat = $rec1['body_fat'];
    }

    if ($muscle_mass == '') {
        $flg = false;
    } else if ($muscle_mass == 'on') {
        // 最新のmuscle_massの値を代入
        $muscle_mass = $rec1['muscle_mass'];
    }

    // db_academyデータベースから切断する
    $dbh = null;

    if ($flg) {             // 入力に問題がなかった場合
        $_SESSION['date'] = $date;                          // セッション変数にdateを保持
        $_SESSION['height'] = $height;                      // セッション変数にheightを保持
        $_SESSION['weight'] = $weight;                      // セッション変数にweightを保持
        $_SESSION['body_fat'] = $body_fat;                  // セッション変数にbody_fatを保持
        $_SESSION['muscle_mass'] = $muscle_mass;            // セッション変数にmuscle_massを保持
        header('Location:p_phisical_info_add_done.php');    // p_phisical_info_add_done.phpへリダイレクト
        exit();
    } else {                // 入力に問題があった場合
        print '入力に誤りがあります<br><br>';
        print '<input type="button" onclick="location.href=\'p_phisical_info_add.php\'" value="戻る">';
    }
} catch (Exception $e) {
    var_dump($e);
    exit();
}
