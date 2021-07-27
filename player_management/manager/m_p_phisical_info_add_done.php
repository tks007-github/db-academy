<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['m_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="m_login.html">ログイン画面へ</a>';
        exit();
    } else {
        print $_SESSION['m_code'];
        print 'さんログイン中<br>';
        print '（検索条件：' . $_SESSION['p_code'] . '）';
        print '<br>';
    }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
</head>

<body>

    <h3>登録完了</h3>

    <?php
    try {
        // m_p_phisical_info_add.phpから渡された値をサニタイズ
        $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
        $height = htmlspecialchars($_POST['height'], ENT_QUOTES, 'UTF-8');
        $weight = htmlspecialchars($_POST['weight'], ENT_QUOTES, 'UTF-8');

        // player_managementデータベースに接続
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルに新たなデータを登録
        $sql = 'INSERT INTO phisical_info (player_code, date, height, weight) VALUES (?, ?, ?, ?)';
        $stmt = $dbh->prepare($sql);
        $data[0] = $p_code;
        $data[1] = $date;
        $data[2] = $height;
        $data[3] = $weight;
        $stmt->execute($data);

        // player_managementデータベースから切断
        $dbh = null;

        print '以下の情報を登録しました。<br>';
        print '<br>';
        print '日付：' . $date . '<br>';
        print '身長：' . $height . '<br>';
        print '体重：' . $weight . '<br>';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

    <br>
    <a href="m_p_phisical_info.php">身体情報トップ</a>

</body>

</html>