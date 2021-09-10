<!-- 
	c_top_login.phpから会員コード(coach_code)とパスワード(coach_password)を受け取って、
	正しい情報が入力されたかの確認を行います。
	コーチコード(coach_code)とパスワード(coach_password)が正しい場合→c_top.phpへリダイレクト
	コーチコード(coach_code)とパスワード(coach_password)が正しくない場合→c_top_login.phpへリダイレクト
 -->

<?php

// 自作のsanitize関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);

// c_top_login.phpからcoach_codeとcoach_passwordを受け取る
$coach_code = $post['coach_code'];
$coach_password = $post['coach_password'];
// coach_passwordをmd5で暗号化
$coach_password = md5($coach_password);

// DB接続
try {
	// db_academyデータベースに接続する
	$dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// coachテーブルからcoach_codeとcoach_passwordを使ってcoach_nameを検索
	$sql = '
            SELECT coach_name 
            FROM coach 
            WHERE coach_code = ? AND coach_password = ?
            ';
	$stmt = $dbh->prepare($sql);
	$data[] = $coach_code;
	$data[] = $coach_password;
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
if ($rec != '') {					            // データベースからの問い合わせ結果があった場合(coach_codeとcoach_passwordの組み合わせが正しかった場合)
	$_SESSION['c_login'] = 1;			        		// SESSION['c_login']に1をセット(ログイン状態を表す)
	unset($_SESSION['c_login_ng']);						// SESSION['c_login_ng']を削除(初期化)
	$_SESSION['coach_code'] = $coach_code;				// SESSION['coach_code']をセット
	$_SESSION['coach_name'] = $rec['coach_name'];		// SESSION['coach_name']をセット
	header('Location:c_top.php');		        		// c_top.phpへリダイレクト
	exit();
} else {										// データベースからの問い合わせ結果がない場合(coach_codeとcoach_passwordの組み合わせが正しくなかった場合)
	$_SESSION['c_login_ng'] = 1;						// SESSION['c_login_ng']に1をセット(ログインの失敗を表す)
	header('Location:c_top_login.php');		    		// c_top_login.phpへリダイレクト
	exit();
}
