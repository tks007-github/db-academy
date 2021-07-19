<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>新規登録</title>
</head>
<body>
<?php
print '下記の内容で登録を行います。<br />';
print '<br />';

# user_register.phpから渡された値をサニタイズ
$user_name=htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
$user_mail=htmlspecialchars($_POST['mail'],ENT_QUOTES, 'UTF-8');
$user_pass=htmlspecialchars($_POST['pass'],ENT_QUOTES,'UTF-8');
$user_pass2=htmlspecialchars($_POST['pass2'],ENT_QUOTES,'UTF-8');

if($user_name=='')											# $user_passが空の場合
{
	print 'ユーザ名が入力されていません。<br /><br />';
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
	exit();
}
else
{
	print 'ユーザ名：'.$user_name.'<br />';
}

if(filter_var($user_mail, FILTER_VALIDATE_EMAIL)==false)	# $user_mailが無効なアドレスの場合
{
	print '無効なメールアドレスです。<br /><br />';
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
	exit();
}
else
{
	print 'メールアドレス：'.$user_mail.'<br />';
}

if($user_pass=='')											# $user_passが空の場合
{
	print 'パスワードが入力されていません。<br /><br />';
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
	exit();
}

if($user_pass!=$user_pass2)									# $user_passと$user_pass2が異なる場合
{
	print 'パスワードが一致しません。<br /><br />';
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
	exit();
}

$user_pass=password_hash($user_pass, PASSWORD_DEFAULT);		# パスワードを暗号化
print '<form method="post" action="user_register_done.php">';
print '<input type="hidden" name="name" value="'.$user_name.'">';
print '<input type="hidden" name="mail" value="'.$user_mail.'">';
print '<input type="hidden" name="pass" value="'.$user_pass.'">';
print '<br />';
print '<input type="button" onclick="history.back()" value="戻る">';
print '<input type="submit" value="ＯＫ">';
print '</form>';

?>
</body>
</html>