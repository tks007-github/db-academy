<!-- 
	c_signup_login.phpからパスワード(mst_password)を受け取って、
	正しいパスワードが入力されたかの確認を行います。
	パスワード(mst_password)が正しい場合→c_signup_top.phpへリダイレクト
	パスワード(mst_password)が正しくない場合→c_signup_login.phpへリダイレクト
 -->

<?php

// 自作のsanitize関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);

// c_signup_login.phpからmst_passwordを受け取る
$mst_password = $post['mst_password'];
// mst_passwordをmd5で暗号化
$mst_password = md5($mst_password);

// DB接続
try {
	// db_academyデータベースに接続する
	$dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// mst_passwordテーブルからmst_passwordを使ってmst_codeを検索
	$sql = 'SELECT mst_code FROM mst_password WHERE mst_password = ?';
	$stmt = $dbh->prepare($sql);
	$data[] = $mst_password;
	$stmt->execute($data);
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	// db_academyデータベースから切断する
	$dbh = null;
} catch (Exception $e) {
	var_dump($e);
	exit();
}

// セッションを開始
session_start();
if ($rec['mst_code'] == 1) {					// データベースからの問い合わせ結果があった場合(mst_passwordが正しかった場合)	
	$_SESSION['c_signup_login'] = 1;				// SESSION['c_signup_login']に1をセット(ログイン状態を表す)
	unset($_SESSION['c_signup_login_ng']);			// SESSION['c_signup_login_ng']を削除(初期化)
	header('Location:c_signup_top.php');			// c_signup_top.phpへリダイレクト
	exit();
} else {										// データベースからの問い合わせ結果がない場合(mst_passwordが正しくなかった場合)
	$_SESSION['c_signup_login_ng'] = 1;				// SESSION['c_signup_login_ng']に1をセット(ログインの失敗を表す)
	header('Location:c_signup_login.php');			// c_signup_login.phpへリダイレクト
	exit();
}
