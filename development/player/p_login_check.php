<?php
try
{
	// p_login.htmlからパスワードを受け取る
	$p_code = htmlspecialchars($_POST['p_code'], ENT_QUOTES, 'UTF-8');
	$p_pass = htmlspecialchars($_POST['p_pass'], ENT_QUOTES, 'UTF-8');

	// player_managementデータベースに接続する
	$dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// playerテーブルから会員コードとパスワードを使って名前を検索
	$sql = 'SELECT player_name FROM player WHERE player_code = ? AND player_password = ?';
	$stmt = $dbh -> prepare($sql);
	$data[0] = $p_code;
	$data[1] = $p_pass;
	$stmt -> execute($data);
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

	// player_managementデータベースから切断する
	$dbh = null;

	if ($rec == false) { 				 // データベースからの問い合わせ結果がない場合
		print '<h3>ログイン失敗</h3><br>';
		print 'パスワードに間違いがあります。<br>';
		print '<input type="button" onclick="location.href=\'p_login.html\'" value="戻る">';
	} else {							// データベースからの問い合わせ結果があった場合
		session_start();						// セッションを開始
		$_SESSION['p_login'] = 1;					// セッション変数に値を格納
		$_SESSION['p_code'] = $p_code;			// セッション変数に会員コードを格納
		header('Location:p_top.php');			// p_top.phpへリダイレクト
		exit();
	}
}

catch(Exception $e)
{
	exit();
}