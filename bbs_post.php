<?php
session_start();	                    # login_check.phpで作成したセッションを再開
session_regenerate_id(true);		    # 既存のセッションIDを新しく置き換える
if(isset($_SESSION['login'])==false)	# セッション変数loginに値が格納されていない場合（ログイン失敗）
{
	print 'ログインされていません。<br />';
	print '<a href="login.html">ログイン画面へ</a>';
	exit();
}
?>

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
	# bbs.phpから渡された値をサニタイズ
	$post_text=htmlspecialchars($_POST['post_text'],ENT_QUOTES,'UTF-8');

    if($post_text=='')  # 書き込みに入力がない場合
    {
        print '文章が入力されていません。<br /><br />';
        print '<form>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '</form>';
        exit();
    }

	# bbsデータベースに接続
	$dsn='mysql:dbname=bbs;host=localhost;charset=utf8';
	$user='root';
	$password='';
	$dbh=new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	# bbsデータベースに対してINSERT文でテキストの追加
	$sql='INSERT INTO mst_post (user_id,post_time,text) VALUES (?,?,?)';
	$stmt=$dbh->prepare($sql);
	$data[0]=$_SESSION['user_id'];
    $data[1]=date('Y-m-d H:i:s');
	$data[2]=$post_text;
	$stmt->execute($data);

	# bbsデータベースから切断
	$dbh=null;

	print '書き込みが完了しました。<br />';
	print '<br />';
}
catch (Exception $e)
{
	var_dump($e);
	exit();
}
?>
<a href="bbs.php"> 戻る</a>
</body>
</html>