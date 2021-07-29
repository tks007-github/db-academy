<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="p_login.html">ログイン画面へ</a>';
    exit();
} else {
    $p_code = $_SESSION['p_code'];
    print $p_code;
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
    <title>Player</title>
</head>

<body>

    <h3>登録完了</h3>

    <?php
    try {
        // p_phisical_test_add.phpから渡された値をサニタイズ
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
        if (isset($_POST['test1'])) {
            $test1 = htmlspecialchars($_POST['test1'], ENT_QUOTES, 'UTF-8');
        } else {
            $test1 = '';
        }
        if (isset($_POST['test2'])) {
            $test2 = htmlspecialchars($_POST['test2'], ENT_QUOTES, 'UTF-8');
        } else {
            $test2 = '';
        }
        if (isset($_POST['test3'])) {
            $test3 = htmlspecialchars($_POST['test3'], ENT_QUOTES, 'UTF-8');
        } else {
            $test3 = '';
        }

        var_dump($_POST);
        // // player_managementデータベースに接続
        // $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
        // $user = 'root';
        // $password = 'root';
        // $dbh = new PDO($dsn, $user, $password);
        // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // // phisical_infoテーブルに新たなデータを登録
        // $sql = 'INSERT INTO phisical_test (player_code, date, test1, test2, test3) VALUES (?, ?, ?, ?, ?)';
        // $stmt = $dbh->prepare($sql);
        // $data[0] = $p_code;
        // $data[1] = $date;
        // $data[2] = $test1;
        // $data[3] = $test2;
        // $data[4] = $test3;
        // $stmt->execute($data);

        // // player_managementデータベースから切断
        // $dbh = null;

        // print '以下の情報を登録しました。<br>';
        // print '<br>';
        // print '日付：' . $date . '<br>';
        // print '身長：' . $height . '<br>';
        // print '体重：' . $weight . '<br>';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

    <br>
    <a href="p_phisical_info.php">身体情報トップ</a>

</body>

</html>