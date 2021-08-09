<?php
try
{
	// 自作のsanitize関数を呼び出す
	require_once('../../function/function.php');
	// POSTの中身をすべてサニタイズする
	$post = sanitize($_POST);

	// p_signup_login.htmlからmst_passwordを受け取る
	$mst_password = $post['mst_password'];

	// db_academyデータベースに接続する
	$dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// mst_passwordテーブルからmst_passwordを使ってmst_codeを検索
	$sql = 'SELECT mst_code FROM mst_password WHERE mst_password = ?';
	$stmt = $dbh -> prepare($sql);
	$data[] = $mst_password;
	$stmt -> execute($data);
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

	// db_academyデータベースから切断する
	$dbh = null;

	if ($rec['mst_code'] == 1) {					// データベースからの問い合わせ結果があった場合
		session_start();							// セッションを開始
		$_SESSION['p_signup_login'] = 1;			// セッション変数に値を格納
		header('Location:p_signup_top.php');		// p_signup_top.phpへリダイレクト
		exit();
	} else {										// データベースからの問い合わせ結果がない場合
		header('Location:p_signup_login_ng.html');	// p_signup_login_ng.htmlへリダイレクト
		exit();
	}
}

catch(Exception $e)
{
	var_dump($e);
	exit();
}