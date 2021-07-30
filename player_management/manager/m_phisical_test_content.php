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
    <title>Player</title>
</head>

<body>

    <h3>フィジカルテストの内容</h3>

    <?php

    // m_phisical_test_check.phpから渡された値をサニタイズ
    $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

    try {
        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_recordテーブルからIDを使って情報を検索
        $sql = '
                SELECT *
                FROM phisical_test_record
                WHERE id = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $id;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        // 取得した内容を変数で保持
        $date = $rec['date'];
        $test_value[] = $rec['test1'];
        $test_value[] = $rec['test2'];
        $test_value[] = $rec['test3'];

        // phisical_test_itemテーブルから項目名を検索
        $sql2 = '
                SELECT test_value 
                FROM phisical_test_item 
                ORDER BY test_code
                ';
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->execute();

        // player_managementデータベースから切断する
        $dbh = null;

        print '日付<br>';
        print $date;
        print '<br><br>';
        print '項目<br>';

        // test_codeのmax値(1～3)までforループをまわす
        print '<form method="post" action="p_phisical_test_add_done.php">';
        print '<input type="hidden" name="date" value="' . $date . '">';
        for ($i = 0; $i < 3; $i++) {
            $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($test_value[$i]) {
                print $rec2['test_value'] . '　';
                print '<br>';
            }
        }
        print '<br>';
        print '<input type="button" onclick="location.href=\'m_phisical_test_list.php\'" value="戻る">';
        print '<input type="submit" value="削除">';
    } catch (Exception $e) {
        exit();
    }
    ?>

</body>

</html>