<!-- 
	ログアウト処理を行います。
	セッションを破棄し、ログイン画面(p_top_login.php)へのボタンを表示します。
 -->

<?php
session_start();	                                	// セッションを再開
$_SESSION = array();	                                // セッション変数を空にする
if (isset($_COOKIE[session_name()]) == true) {	        // cookieが存在する場合
	setcookie(session_name(), '', time() - 42000, '/');	// セッションIDをcookieから削除
}
session_destroy();										//セッションを破棄する
?>


<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>p_top_logout.php</title>
</head>

<body>
	<h3>ログアウト</h3>
	<br>
	ログアウトしました<br>
	<br>
	<a href="p_top_login.php">ログイン画面へ</a>
</body>

</html>