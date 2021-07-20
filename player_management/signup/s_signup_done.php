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
		// s_signup_check.phpから渡された値をサニタイズ
		$belong_name = htmlspecialchars($_POST['belong_name'], ENT_QUOTES, 'UTF-8');
		$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
		$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');

		// player_managementデータベースに接続
		$dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
		$user = 'root';
		$password = 'root';
		$dbh = new PDO($dsn, $user, $password);
		$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// belongテーブルから所属先コードを取得
		$sql3 = 'SELECT belong_code FROM belong WHERE belong_name = ?';
		$stmt3 = $dbh -> prepare($sql3);
		$data3[0] = $belong_name;
		$stmt3 -> execute($data3);
		$rec3 = $stmt3 -> fetch(PDO::FETCH_ASSOC);

		$belong_code = $rec3['belong_code'];

		// new_idテーブルから新規id番号を取得
		$sql4 = 'SELECT new_id FROM new_id WHERE belong_code = ?';
		$stmt4 = $dbh -> prepare($sql4);
		$data4[0] = $belong_code;
		$stmt4 -> execute($data4);
		$rec4 = $stmt4 -> fetch(PDO::FETCH_ASSOC);

		$new_id = $rec4['new_id'];

		// playerテーブルに対してINSERT文で選手の追加
		$sql1 = 'INSERT INTO player (player_code, player_name, player_password, belong_code) VALUES (?, ?, ?, ?)';
		$stmt1 = $dbh -> prepare($sql1);
		$player_code = $belong_code . $new_id;
		$data1[0] = $player_code;
		$data1[1] = $name;
		$data1[2] = $pass;
		$data1[3] = $belong_code;
		$stmt1 -> execute($data1);

		// new_idテーブルに対してINSERT文でnew_idに1を加える
		$sql2 = 'UPDATE new_id SET new_id = ? WHERE belong_code = ?';
		$stmt2 = $dbh -> prepare($sql2);
		$new_id += 1;
		$data2[0] = $new_id;
		$data2[1] = $belong_code;
		$stmt2 -> execute($data2);

		// player_managementデータベースから切断
		$dbh = null;

		print '以下の情報を登録しました。<br>';
		print '下記のリンクからログインし、問診票の入力を完了してください。<br>';
		print '<br>';
		print '会員コード：' . $player_code . '<br>';
		print '氏名：' . $name . '<br>';
		print '所属：' . $belong_name . '<br>';
	} catch (Exception $e) {
		var_dump($e);
		exit();
	}

	?>

	<br>
	<a href="../p_login.html"> 選手管理</a>

</body>

</html>