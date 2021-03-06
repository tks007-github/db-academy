<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['c_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="../c_top/c_top_login.html">ログイン画面へ</a>';
        exit();
    } else {
        print $_SESSION['coach_name'];
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
    <title>c_phisical_test_delete</title>
</head>

<body>

    <h3>フィジカルテストの削除</h3>
    <br>

    <?php

    try {
        // c_phisical_test_list_check.phpからphisical_test_codeをSESSIONで受け取る
        $phisical_test_code = $_SESSION['phisical_test_code'];

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_testテーブルからphisical_test_codeを使って情報を検索
        $sql = '
                SELECT * 
                FROM phisical_test 
                WHERE phisical_test_code = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $phisical_test_code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // データをそれぞれ変数で保持
        $date = $rec['date'];
        $belong_code = $rec['belong_code'];
        $test1_boolean = $rec['10m走'];
        $test2_boolean = $rec['20m走'];
        $test3_boolean = $rec['30m走'];
        $test4_boolean = $rec['50m走'];
        $test5_boolean = $rec['1500m走'];
        $test6_boolean = $rec['プロアジリティ'];
        $test7_boolean = $rec['立ち幅跳び'];
        $test8_boolean = $rec['メディシンボール投げ'];
        $test9_boolean = $rec['垂直飛び'];
        $test10_boolean = $rec['背筋力'];
        $test11_boolean = $rec['握力'];
        $test12_boolean = $rec['サイドステップ'];

        // SESSION変数で保持
        $_SESSION['date'] = $date;
        $_SESSION['belong_code'] = $belong_code;

        // db_academyデータベースから切断する
        $dbh = null;

        print '本当に削除しますか<br><br>';

        print '<br>';
        print '<input type="button" onclick="location.href=\'c_phisical_test_content.php\'" value="戻る">';
        print '<input type="button" onclick="location.href=\'c_phisical_test_delete_check.php\'" value="削除">';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

</body>

</html>