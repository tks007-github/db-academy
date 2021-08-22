<?php
try
{
	// 自作のsanitize関数を呼び出す
	require_once('../../function/function.php');
	// POSTの中身をすべてサニタイズする
	$post = sanitize($_POST);

	// c_top_login.htmlからcoach_codeとcoach_passwordを受け取る
	$coach_code = $post['coach_code'];
    $coach_password = $post['coach_password'];

	// db_academyデータベースに接続する
	$dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// coachテーブルからcoach_codeとcoach_passwordを使ってcoach_nameを検索
	$sql = '
            SELECT coach_name 
            FROM coach 
            WHERE coach_code = ? AND coach_password = ?
            ';
	$stmt = $dbh -> prepare($sql);
	$data[] = $coach_code;
    $data[] = $coach_password;
	$stmt -> execute($data);
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

	// db_academyデータベースから切断する
	$dbh = null;

	if ($rec != '') {					            // データベースからの問い合わせ結果があった場合
		session_start();							// セッションを開始
		$_SESSION['c_login'] = 1;			        // セッション変数に値を格納
        $_SESSION['coach_code'] = $coach_code;
        $_SESSION['coach_name'] = $rec['coach_name'];
		header('Location:c_top.php');		        // c_top.phpへリダイレクト
		exit();
	} else {										// データベースからの問い合わせ結果がない場合
		header('Location:c_top_login_ng.html');	    // c_top_login_ng.htmlへリダイレクト
		exit();
	}
}

catch(Exception $e)
{
	var_dump($e);
	exit();
}