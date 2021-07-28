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

    <h3>フィジカルテストの新規作成（完了）</h3>

    <?php

    try {

        // m_phisical_test_create_check.phpから渡された値をサニタイズ
        $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
        // player_managementデータベースに接続
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data[0] = $date;
        // test_codeのmax値(1～3)までforループをまわす
        for ($i = 1; $i < 4; $i++) {
            if (isset($_POST['test_code' . $i])) {
                $data[$i] = 1;
            } else {
                $data[$i] = 0;
            }
        }

        // phisical_test_recordテーブルの内容を更新
        $sql = '
    INSERT INTO phisical_test_record(date, test1, test2, test3) 
    VALUES(?, ?, ?, ?) 
  ';
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // player_managementデータベースから切断
        $dbh = null;

        print '日付<br>';
        print $date;
        print '<br><br>';

        print '項目<br>';
        // test_codeのmax値(1～3)までforループをまわす
        for ($i = 1; $i < 4; $i++) {
            if (isset($_POST['test_code' . $i])) {
                $test_code = htmlspecialchars($_POST['test_code' . $i], ENT_QUOTES, 'UTF-8');
                $test_value = htmlspecialchars($_POST['test_value' . $i], ENT_QUOTES, 'UTF-8');

                print $test_code;
                print '　';
                print $test_value;
                print '<br>';
            }
        }
        print '<br>';
        print '<input type="button" onclick="location.href=\'m_phisical_test_create.php\'" value="戻る">';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>