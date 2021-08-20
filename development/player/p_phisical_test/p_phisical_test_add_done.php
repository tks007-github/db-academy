<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="../p_top/p_top_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['player_name'];
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
    <title>p_phisical_test_add_done</title>
</head>

<body>

    <h3>フィジカルテストの登録完了</h3>

    <?php
    try {

        // player_codeをSESSIONで受け取る
        $player_code = $_SESSION['player_code'];
        // dateをSESSIONで受け取る
        $date = $_SESSION['date'];

        // p_phisical_test_add_checkからSESSIONで身体情報を受け取る
        $test1_value = $_SESSION['test1_value'];
        $test2_value = $_SESSION['test2_value'];
        $test3_value = $_SESSION['test3_value'];
        $test4_value = $_SESSION['test4_value'];
        $test5_1_value = $_SESSION['test5_1_value'];
        $test5_2_value = $_SESSION['test5_2_value'];
        $test6_value = $_SESSION['test6_value'];
        $test7_value = $_SESSION['test7_value'];
        $test8_value = $_SESSION['test8_value'];
        $test9_value = $_SESSION['test9_value'];
        $test10_value = $_SESSION['test10_value'];
        $test11_value = $_SESSION['test11_value'];
        $test12_value = $_SESSION['test12_value'];

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルに情報を追加
        $sql = '
                INSERT INTO phisical_test_record(player_code, date,
                10m走, 20m走, 30m走, 50m走, 1500m走_min, 1500m走_sec, 
                プロアジリティ, 立ち幅跳び, メディシンボール投げ, 垂直飛び,
                背筋力, 握力, サイドステップ) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $player_code;
        $data[] = $date;
        $data[] = $test1_value;
        $data[] = $test2_value;
        $data[] = $test3_value;
        $data[] = $test4_value;
        $data[] = $test5_1_value;
        $data[] = $test5_2_value;
        $data[] = $test6_value;
        $data[] = $test7_value;
        $data[] = $test8_value;
        $data[] = $test9_value;
        $data[] = $test10_value;
        $data[] = $test11_value;
        $data[] = $test12_value;
        $stmt->execute($data);

        // player_managementデータベースから切断する
        $dbh = null;

        print '登録が完了しました<br><br>';
        print '<input type="button" onclick="location.href=\'p_phisical_test_top.php\'" value="戻る">';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>