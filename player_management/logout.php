<?php
session_start();	                                # staff_login_check.phpで作成したセッションを再開
$_SESSION=array();	                                # セッション変数を空にする
if(isset($_COOKIE[session_name()])==true)	        # cookieが存在する場合
{
	setcookie(session_name(),'',time()-42000,'/');	# セッションIDをcookieから削除
}
session_destroy();	# セッションを破棄する
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>○○掲示板</title>
</head>
<body>
ログアウトしました。ご利用ありがとうございます。<br />
<br />
<a href="login.html">ログイン画面へ</a>
</body>
</html>