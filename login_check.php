<?php
try
{
	# login.htmlからユーザ名・パスワードを受け取る
	$user_name=htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
	$user_pass=htmlspecialchars($_POST['pass'],ENT_QUOTES,'UTF-8');

	# bbsデータベースに接続する
	$dsn='mysql:dbname=bbs;host=localhost;charset=utf8';
	$user='root';
	$password='';
	$dbh=new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	# mst_userテーブルからユーザ名とパスワードを使ってIDと名前を検索
	$sql='SELECT * FROM mst_user WHERE name=?';
	$stmt=$dbh->prepare($sql);
	$data[0]=$user_name;
	$data[1]=$user_name;
	$stmt->execute($data);

	# bbsデータベースから切断する
	$dbh=null;

	$rec=$stmt->fetch(PDO::FETCH_ASSOC);

	if($rec['name']==false || password_verify($user_pass, $rec['password'])==false )		# データベースからの問い合わせ結果がない場合
	{
		print 'ユーザ名またはパスワードに間違いがあります。<br />';
		print '<a href="login.html"> 戻る</a>';
	}
	else										# データベースからの問い合わせ結果があった場合
	{
		session_start();			# セッションを開始
		$_SESSION['login']=1;			# セッション変数に値を格納
		$_SESSION['user_id']=$rec['id'];	# セッション変数にIDを格納
		$_SESSION['user_name']=$rec['name'];	# セッション変数に名前を格納
		header('Location:bbs.php');		# staff_top.phpへリダイレクト
		exit();
	}
}
catch(Exception $e)
{
	var_dump($e);
	exit();
}