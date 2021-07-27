<?php
try
{
	// m_search.phpから会員コードを受け取る
	$p_code = htmlspecialchars($_POST['p_code'], ENT_QUOTES, 'UTF-8');

	// player_managementデータベースに接続する
	$dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// playerテーブルから会員コードを使って名前を検索
	$sql = 'SELECT player_name FROM player WHERE player_code = ?';
	$stmt = $dbh -> prepare($sql);
	$data[0] = $p_code;
	$stmt -> execute($data);
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);

	// player_managementデータベースから切断する
	$dbh = null;

	if ($rec == false) { 				 // データベースからの問い合わせ結果がない場合
		print '<h3>検索失敗</h3><br>';
		print '検索された会員コードは登録されていません<br>';
		print '<input type="button" onclick="location.href=\'m_search.php\'" value="戻る">';
	} else {							// データベースからの問い合わせ結果があった場合
		session_start();
        $_SESSION['p_code'] = $p_code;			// セッション変数に会員コードを格納
		header('Location:m_p_top.php');			// p_top.phpへリダイレクト
		exit();
	}
}

catch(Exception $e)
{
	exit();
}