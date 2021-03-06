<?php
try
{
	// s_login.htmlからパスワードを受け取る
	$mst_pass = htmlspecialchars($_POST['mst_pass'], ENT_QUOTES, 'UTF-8');

	// player_managementデータベースに接続する
	$dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// mst_passwordテーブルからパスワードを使ってIDを検索
	$sql = 'SELECT id FROM mst_password WHERE password = ?';
	$stmt = $dbh -> prepare($sql);
	$data[0] = $mst_pass;
	$stmt -> execute($data);
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

	// player_managementデータベースから切断する
	$dbh = null;

	if ($rec['id'] == 1) {				// データベースからの問い合わせ結果があった場合
		session_start();						// セッションを開始
		$_SESSION['s_login'] = 1;					// セッション変数に値を格納
		header('Location:s_signup.php');		// s_signup.phpへリダイレクト
		exit();
	} else {							// データベースからの問い合わせ結果がない場合
		print '<h3>ログイン失敗</h3><br>';
		print 'パスワードに間違いがあります。<br>';
		print '<a href="s_login.html"> 戻る</a>';
	}
}

catch(Exception $e)
{
	exit();
}