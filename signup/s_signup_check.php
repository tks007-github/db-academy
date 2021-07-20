<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Signup</title>
</head>

<body>

	<?php
	print '下記の内容で登録を行います。<br>';
	print '<br>';

	// s_signup2.phpから渡された値をサニタイズ
	$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
	$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');
	$height = htmlspecialchars($_POST['height'], ENT_QUOTES, 'UTF-8');
	$weight = htmlspecialchars($_POST['weight'], ENT_QUOTES, 'UTF-8');

	print '氏名：' . $name . '<br>';
	print 'パスワード：' . $pass . '<br>';
	print '身長：' . $height . '<br>';
	print '体重：' . $weight . '<br>'; 

	// $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);		// パスワードを暗号化
	print '<form method="post" action="user_register_done.php">';
	print '<input type="hidden" name="name" value="' . $name . '">';
	print '<input type="hidden" name="pass" value="' . $pass . '">';
	print '<input type="hidden" name="height" value="' . $height . '">';
	print '<input type="hidden" name="weight" value="' . $weight . '">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="登録">';
	print '</form>';

	?>

</body>

</html>