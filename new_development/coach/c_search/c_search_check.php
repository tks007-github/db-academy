<!-- 
    c_search_list.phpから選手コード(player_code)が送られてきたかの確認。

    送られてきた場合→p_top.phpに遷移
    送られてきていない場合→c_search_ng.phpに遷移
 -->

<?php

session_start();
session_regenerate_id(true);

if (!isset($_POST['player_code'])) {        // 選手コードが送られてきていない場合
    header('Location: c_search_ng.php');
    exit();
} else {                                    // 選手コードが送られてきた場合
    // 自作の関数を呼び出す
    require_once('../../function/function.php');
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);
    $player_code = $post['player_code'];


    // DB接続
    try {
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
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    $_SESSION['p_login'] = 1;			        		// SESSION['p_login']に1をセット(ログイン状態を表す)
	$_SESSION['player_code'] = $player_code;			// SESSION['player_code']をセット
	$_SESSION['player_name'] = $rec['player_name'];		// SESSION['player_name']をセット
	$_SESSION['belong_code'] = $rec['belong_code'];		// SESSION['belong_code']をセット
    header('Location:../../player/p_top/p_top.php');    // p_top.phpへリダイレクト
    exit();
}
