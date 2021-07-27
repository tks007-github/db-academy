<?php
try
{
	// m_login.htmlからパスワードを受け取る
	$m_code = htmlspecialchars($_POST['m_code'], ENT_QUOTES, 'UTF-8');
	$m_pass = htmlspecialchars($_POST['m_pass'], ENT_QUOTES, 'UTF-8');

	// player_managementデータベースに接続する
	$dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// managerテーブルから会員コードとパスワードを使って名前を検索
	$sql = 'SELECT manager_name FROM manager WHERE manager_code = ? AND manager_password = ?';
	$stmt = $dbh -> prepare($sql);
	$data[0] = $m_code;
	$data[1] = $m_pass;
	$stmt -> execute($data);
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

	// player_managementデータベースから切断する
	$dbh = null;

	if ($rec == false) { 				 // データベースからの問い合わせ結果がない場合
		print '<h3>ログイン失敗</h3><br>';
		print 'パスワードに間違いがあります。<br>';
		print '<input type="button" onclick="location.href=\'m_login.html\'" value="戻る">';
	} else {							// データベースからの問い合わせ結果があった場合
		session_start();						// セッションを開始
		$_SESSION['login'] = 1;					// セッション変数に値を格納
		$_SESSION['m_code'] = $m_code;			// セッション変数に管理者コードを格納
		header('Location:m_top.php');			// m_top.phpへリダイレクト
		exit();
	}
}

catch(Exception $e)
{
	exit();
}