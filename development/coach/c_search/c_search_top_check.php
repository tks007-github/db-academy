<?php
try
{
	// 自作のsanitize関数を呼び出す
	require_once('../../function/function.php');
	// POSTの中身をすべてサニタイズする
	$post = sanitize($_POST);

	// c_search_top.phpからplayer_nameを受け取る
	$player_name = $post['player_name'];

	// db_academyデータベースに接続する
	$dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// playerテーブルからplayer_nameを使ってplayer_codeとbelong_codeを検索
	$sql = '
            SELECT player_code, belong_code 
            FROM player 
            WHERE player_name = ?
            ';
	$stmt = $dbh -> prepare($sql);
	$data[] = $player_name;
	$stmt -> execute($data);
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

	// db_academyデータベースから切断する
	$dbh = null;

	if ($rec != '') {					            // データベースからの問い合わせ結果があった場合
		session_start();							// セッションを再開
        session_regenerate_id(true);
		$_SESSION['p_login'] = 1;			        // セッション変数に値を格納
        $_SESSION['player_code'] = $rec['player_code'];
        $_SESSION['player_name'] = $player_name;
        $_SESSION['belong_code'] = $rec['belong_code'];
		header('Location:../../player/p_top/p_top.php');	// p_top.phpへリダイレクト
		exit();
	} else {										// データベースからの問い合わせ結果がない場合
		header('Location:c_search_top_ng.php');	    // c_search_top_ng.phpへリダイレクト
		exit();
	}
}

catch(Exception $e)
{
	var_dump($e);
	exit();
}