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
				$code = 'A';
				break;
			case 'D.B.アカデミー':
				$code = 'B';
				break;
		}

		# player_managementデータベースに接続
		$dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
		$user = 'root';
		$password = 'root';
		$dbh = new PDO($dsn, $user, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		# mst_playerテーブルに対してINSERT文で選手の追加
		$sql = 'INSERT INTO mst_player (belong, name, password) VALUES (?,?,?)';
		$stmt = $dbh->prepare($sql);
		$data[0] = $belong;
		$data[1] = $name;
		$data[2] = $pass;
		$stmt->execute($data);

		# player_managementデータベースから切断
		$dbh = null;

		print $user_name . 'さん登録ありがとうございます。<br />';
		print '<br />';
	} catch (Exception $e) {
		var_dump($e);
		exit();
	}

	?>

</body>

</html>