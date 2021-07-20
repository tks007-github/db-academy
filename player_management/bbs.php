<?php
session_start();	                    # login_check.phpで作成したセッションを再開
session_regenerate_id(true);		    # 既存のセッションIDを新しく置き換える
if(isset($_SESSION['login'])==false)	# セッション変数loginに値が格納されていない場合（ログイン失敗）
{
	print 'ログインされていません。<br />';
	print '<a href="login.html">ログイン画面へ</a><br />';
	exit();
}
else                                    # セッション変数loginに値が格納されている場合（ログイン成功）
{
	print 'ようこそ！'.$_SESSION['user_name'].'さん<br />';	# セッション変数user_nameを表示
    print '<a href="logout.php">ログアウトはこちら</a><br />';
    print '<br />';
}
?>

<form method="post" action="bbs_post.php">
書き込み：<br>
<textarea name="post_text" rows="10" cols="50"></textarea><br />
<br />
<input type="submit" value="送信">
</form>
<br />
<br />

<table>
    <tr><th>書き込みユーザ</th> <th>書き込み時間</th> <th>本文</th></tr>
<?php
try
{
    # bbsデータベースに接続
    $dsn='mysql:dbname=bbs;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    # mst_postテーブルとmst_userテーブルを内部結合し、SELECT文で検索を行う
    $sql='SELECT mst_user.name, mst_post.post_time, mst_post.text FROM mst_post INNER JOIN mst_user ON mst_post.user_id = mst_user.id ORDER BY mst_post.post_time';
    $stmt=$dbh->prepare($sql);
    $stmt->execute(); 

    $rec=$stmt->fetchAll();
    foreach ($rec as $key => $value) {
        print '<tr>';
        print '<th>'.$value['name'].'</th><th>'.$value['post_time'].'</th><th>'.$value['text'].'</th>';
        print '</tr>';
    }

    # bbsデータベースから切断
    $dbh=null;
}
catch (Exception $e)		# エラーが発生した場合の処理
{
    var_dump($e);;
	exit();
}
?>
</table>
</body>
</html>