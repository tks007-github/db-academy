<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="c_top_login.html">ログイン画面へ</a>';
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
    <title>c_phisical_test_add_done</title>
</head>

<body>

    <h3>フィジカルテストの登録完了</h3>

    <?php
    try {

        // c_phisical_test_add_checkからSESSIONでフィジカルテストの情報を受け取る
        $belong_code = $_SESSION['belong_code'];
        $date = $_SESSION['date'];
        $test1_boolean = $_SESSION['10m走_boolean'];
        $test2_boolean = $_SESSION['20m走_boolean'];
        $test3_boolean = $_SESSION['30m走_boolean'];
        $test4_boolean = $_SESSION['50m走_boolean'];
        $test5_boolean = $_SESSION['1500m走_boolean'];
        $test6_boolean = $_SESSION['プロアジリティ_boolean'];
        $test7_boolean = $_SESSION['立ち幅跳び_boolean'];
        $test8_boolean = $_SESSION['メディシンボール投げ_boolean'];
        $test9_boolean = $_SESSION['垂直飛び_boolean'];
        $test10_boolean = $_SESSION['背筋力_boolean'];
        $test11_boolean = $_SESSION['握力_boolean'];
        $test12_boolean = $_SESSION['サイドステップ_boolean'];

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルに情報を追加
        $sql = '
                INSERT INTO phisical_test(belong_code, date,
                10m走, 20m走, 30m走, 50m走, 1500m走, プロアジリティ, 
                立ち幅跳び, メディシンボール投げ, 垂直飛び,
                背筋力, 握力, サイドステップ) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $belong_code;
        $data[] = $date;
        $data[] = $test1_boolean;
        $data[] = $test2_boolean;
        $data[] = $test3_boolean;
        $data[] = $test4_boolean;
        $data[] = $test5_boolean;
        $data[] = $test6_boolean;
        $data[] = $test7_boolean;
        $data[] = $test8_boolean;
        $data[] = $test9_boolean;
        $data[] = $test10_boolean;
        $data[] = $test11_boolean;
        $data[] = $test12_boolean;
        $stmt->execute($data);

        // db_academyデータベースから切断する
        $dbh = null;

        print '登録が完了しました<br><br>';
        print '<input type="button" onclick="location.href=\'c_phisical_test_top.php\'" value="戻る">';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>