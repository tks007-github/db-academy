<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>○○掲示板</title>
</head>
<body>

<?php
try
{
	# staff_add_check.phpから渡された値をサニタイズ
	$user_name=htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
	$user_mail=htmlspecialchars($_POST['mail'],ENT_QUOTES,'UTF-8');
	$user_pass=htmlspecialchars($_POST['pass'],ENT_QUOTES,'UTF-8');

	# bbsデータベースに接続
	$dsn='mysql:dbname=bbs;host=localhost;charset=utf8mb4';
	$user='root';
	$password='';
	$dbh=new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	# bbsデータベースに対してINSERT文でユーザ情報の追加
	$sql='INSERT INTO mst_user (name,mail,password) VALUES (?,?,?)';
	$stmt=$dbh->prepare($sql);
	$data[0]=$user_name;
	$data[1]=$user_mail;
	$data[2]=$user_pass;
	$stmt->execute($data);

	# bbsデータベースから切断
	$dbh=null;

	print $user_name.'さん登録ありがとうございます。<br />';
	print '<br />';
}
catch (Exception $e)
{
	var_dump($e);
	exit();
}

?>
<a href="login.html"> 戻る</a>
</body>
</html>