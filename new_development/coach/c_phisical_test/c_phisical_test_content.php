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
    <title>c_phisical_test_content</title>
</head>

<body>

    <h3>フィジカルテストの内容</h3>
    <br>

    <?php

    try {
        // c_phisical_test_top.phpからphisical_test_codeをSESSIONで受け取る
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

        print '日付<br>';
        print $date;
        print '<br><br>';

        print '所属<br>';
        print $belong_code;
        print '<br><br>';

        print '項目<br>';
        if ($test1_boolean) {
            print '10m走<br>';
        }
        if ($test2_boolean) {
            print '20m走<br>';
        }
        if ($test3_boolean) {
            print '30m走<br>';
        }
        if ($test4_boolean) {
            print '50m走<br>';
        }
        if ($test5_boolean) {
            print '1500m走<br>';
        }
        if ($test6_boolean) {
            print 'プロアジリティ<br>';
        }
        if ($test7_boolean) {
            print '立ち幅跳び<br>';
        }
        if ($test8_boolean) {
            print 'メディシンボール投げ<br>';
        }
        if ($test9_boolean) {
            print '垂直飛び<br>';
        }
        if ($test10_boolean) {
            print '背筋力<br>';
        }
        if ($test11_boolean) {
            print '握力<br>';
        }
        if ($test12_boolean) {
            print 'サイドステップ<br>';
        }

        
        print '<br>';
        print '<input type="button" onclick="location.href=\'c_phisical_test_top.php\'" value="戻る">';
        print '<input type="button" onclick="location.href=\'c_phisical_test_delete.php\'" value="削除">';
        print '<input type="button" onclick="location.href=\'c_phisical_test_player_list.php\'" value="入力済選手一覧">';
        print '<input type="button" onclick="location.href=\'c_phisical_test_player_no_list.php\'" value="未入力選手一覧">';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

</body>

</html>