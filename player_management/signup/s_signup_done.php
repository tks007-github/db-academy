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
	try {
		# s_signup_check.phpから渡された値をサニタイズ
		$belong = htmlspecialchars($_POST['belong'], ENT_QUOTES, 'UTF-8');
		$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
		$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');

		// 会員コードをつけるための頭文字を所属によって取得(新川高校：A, D.B.アカデミー：B)
		switch ($belong) {
			case '新川高校':
				$ini = 'A';
				break;
			case 'D.B.アカデミー':
				$ini = 'B';
				break;
		}

		// player_managementデータベースに接続
		$dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
		$user = 'root';
		$password = 'root';
		$dbh = new PDO($dsn, $user, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// mst_playerテーブルに対してINSERT文で選手の追加
		$sql1 = 'INSERT INTO player (name, password, belong) VALUES (?,?,?)';
		$stmt1 = $dbh->prepare($sql1);
		$data1[0] = $name;
		$data1[1] = $pass;
		$data1[2] = $belong;
		$stmt1->execute($data1);

		// mst_playerテーブルから選手のIDを取得
		$sql2 = 'SELECT id FROM mst_player WHERE name = ? and password = ? and belong = ?';
		$stmt2 = $dbh->prepare($sql2);
		$data2[0] = $name;
		$data2[1] = $pass;
		$data2[2] = $belong;
		$stmt2->execute($data2);
		$rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);

		// player_managementデータベースから切断
		$dbh = null;

		print '以下の情報を登録しました。<br>';
		print '下記のリンクからログインし、問診票の入力を完了してください。<br>';
		print '<br>';
		print '会員コード：' . $ini . $rec2['id'] . '<br>';
		print '氏名：' . $name . '<br>';
		print '所属：' . $belong . '<br>';
	} catch (Exception $e) {
		var_dump($e);
		exit();
	}

	?>

	<br>
	<a href="../p_login.html"> 選手管理</a>

</body>

</html>