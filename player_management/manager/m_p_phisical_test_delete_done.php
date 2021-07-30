<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['m_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="m_login.html">ログイン画面へ</a>';
        exit();
    } else {
        $p_code = $_SESSION['p_code'];
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

    <h3>削除完了</h3>

    <?php
    try {
        // m_p_phisical_test_delete.phpから渡された値をサニタイズ
        $test_id = htmlspecialchars($_POST['test_id'], ENT_QUOTES, 'UTF-8');

        // player_managementデータベースに接続
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_testテーブルのデータを削除
        $sql = 'DELETE FROM phisical_test WHERE id = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $test_id;
        $stmt->execute($data);

        // player_managementデータベースから切断
        $dbh = null;

    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

    削除が完了しました<br>
    <br>
    <a href="m_p_phisical_test.php">フィジカルテストトップ</a>

</body>

</html>