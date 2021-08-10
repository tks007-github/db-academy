<?php
try
{
	// 自作のsanitize関数を呼び出す
	require_once('../../function/function.php');
	// POSTの中身をすべてサニタイズする
	$post = sanitize($_POST);

	// p_top_login.htmlからplayer_codeとplayer_passwordを受け取る
	$player_code = $post['player_code'];
    $player_password = $post['player_password'];

	// db_academyデータベースに接続する
	$dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// playerテーブルからplayer_codeとplayer_passwordを使ってplayer_nameとbelong_codeを検索
	$sql = '
            SELECT player_name, belong_code 
            FROM player 
            WHERE player_code = ? AND player_password = ?
            ';
	$stmt = $dbh -> prepare($sql);
	$data[] = $player_code;
    $data[] = $player_password;
	$stmt -> execute($data);
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

	// db_academyデータベースから切断する
	$dbh = null;

	if ($rec != '') {					            // データベースからの問い合わせ結果があった場合
		session_start();							// セッションを開始
		$_SESSION['p_login'] = 1;			        // セッション変数に値を格納
        $_SESSION['player_code'] = $player_code;
        $_SESSION['player_name'] = $rec['player_name'];
        $_SESSION['belong_code'] = $rec['belong_code'];
		header('Location:p_top.php');		        // p_top.phpへリダイレクト
		exit();
	} else {										// データベースからの問い合わせ結果がない場合
		header('Location:p_top_login_ng.html');	    // p_top_login_ng.htmlへリダイレクト
		exit();
	}
}

catch(Exception $e)
{
	var_dump($e);
	exit();
}