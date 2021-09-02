<?php

session_start();
session_regenerate_id(true);

try {
    if (!isset($_POST['player_code'])) {
        header('Location: c_search_ng.php');
        exit();
    } else {
        // 自作の関数を呼び出す
        require_once('../../function/function.php');
        // POSTの中身をすべてサニタイズする
        $post = sanitize($_POST);
        $player_code = $post['player_code'];

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // playerテーブルからplayer_codeを使ってplayer_nameとbelong_codeを検索
        $sql = '
            SELECT player_name, belong_code 
            FROM player 
            WHERE player_code = ?
            ';
        $stmt = $dbh->prepare($sql);
        $data[] = $player_code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // db_academyデータベースから切断する
        $dbh = null;

        $_SESSION['p_login'] = 1;                    // セッション変数に値を格納
        $_SESSION['player_code'] = $player_code;
        $_SESSION['player_name'] = $rec['player_name'];
        $_SESSION['belong_code'] = $rec['belong_code'];
        header('Location:../../player/p_top/p_top.php');                // p_top.phpへリダイレクト
        exit();
    }
} catch (Exception $e) {
    var_dump($e);
    exit();
}
