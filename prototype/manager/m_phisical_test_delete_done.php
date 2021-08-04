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

    <h3>削除完了</h3>

    <?php
    try {
        // m_phisical_test_delete.phpから渡された値をサニタイズ
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');

        // player_managementデータベースに接続
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_recordテーブルのデータを削除
        $sql = 'DELETE FROM phisical_test_record WHERE id = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $id;
        $stmt->execute($data);

        // phisical_testテーブルのデータを削除
        $sql1 = 'DELETE FROM phisical_test WHERE date = ?';
        $stmt1 = $dbh->prepare($sql1);
        $data1[0] = $date;
        $stmt1->execute($data1);

        // player_managementデータベースから切断
        $dbh = null;

    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

    削除が完了しました<br>
    <br>
    <a href="m_phisical_test_list.php">フィジカルテスト一覧</a>

</body>

</html>