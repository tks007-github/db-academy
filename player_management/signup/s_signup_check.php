<?php
    session_start();
	session_regenerate_id(true);
    if (!isset($_SESSION['login'])) {
        print 'ログインされていません。<br>';
        print '<a href="s_login.html">ログイン画面へ</a>';
        exit();
    }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Signup</title>
</head>

<body>

	<h3>新規登録確認</h3>

	<?php

	print '下記の内容で登録を行います。<br>';
	print '<br>';

	// s_signup.phpから渡された値をサニタイズ
	$belong_name = htmlspecialchars($_POST['belong_name'], ENT_QUOTES, 'UTF-8');
	$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
	$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');

	print '所属：' . $belong_name . '<br>';
	print '氏名：' . $name . '<br>';
	print 'パスワード：' . $pass . '<br>'; 

	// $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);		// パスワードを暗号化
	print '<form method="post" action="s_signup_done.php">';
	print '<input type="hidden" name="belong_name" value="' . $belong_name . '">';
	print '<input type="hidden" name="name" value="' . $name . '">';
	print '<input type="hidden" name="pass" value="' . $pass . '">';
	print '<br>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="登録">';
	print '</form>';

	?>

</body>

</html>