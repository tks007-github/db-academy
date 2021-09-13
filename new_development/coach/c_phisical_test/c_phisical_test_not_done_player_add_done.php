<!-- 
    c_phisical_test_not_done_player_add_check.phpから受け取ったフィジカルテストの情報をphisical_test_recordテーブルに
    インサートする。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_login'])) {     // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
    print 'ログインされていません。<br>';
    print '<a href="../c_top/c_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
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
    <title>c_phisical_test_not_done_player_add_done.php</title>
</head>

<body>

    <h3>フィジカルテストの登録完了</h3>

    <?php
    try {

        // player_codeをSESSIONで受け取る
        $player_code = $_SESSION['player_code'];
        // dateをSESSIONで受け取る
        $date = $_SESSION['date'];

        // c_phisical_test_not_done_player_add_checkからSESSIONでフィジカルテスト情報を受け取る
        $test1_value = $_SESSION['10m走_value'];
        $test2_value = $_SESSION['20m走_value'];
        $test3_value = $_SESSION['30m走_value'];
        $test4_value = $_SESSION['50m走_value'];
        $test5_value = $_SESSION['1500m走_value'];
        $test6_value = $_SESSION['プロアジリティ_value'];
        $test7_value = $_SESSION['立ち幅跳び_value'];
        $test8_value = $_SESSION['メディシンボール投げ_value'];
        $test9_value = $_SESSION['垂直飛び_value'];
        $test10_value = $_SESSION['背筋力_value'];
        $test11_value = $_SESSION['握力_value'];
        $test12_value = $_SESSION['サイドステップ_value'];


        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_recordテーブルに情報を追加
        $sql = '
                INSERT INTO phisical_test_record(player_code, date,
                10m走, 20m走, 30m走, 50m走, 1500m走, 
                プロアジリティ, 立ち幅跳び, メディシンボール投げ, 垂直飛び,
                背筋力, 握力, サイドステップ) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $player_code;
        $data[] = $date;
        $data[] = $test1_value;
        $data[] = $test2_value;
        $data[] = $test3_value;
        $data[] = $test4_value;
        $data[] = $test5_value;
        $data[] = $test6_value;
        $data[] = $test7_value;
        $data[] = $test8_value;
        $data[] = $test9_value;
        $data[] = $test10_value;
        $data[] = $test11_value;
        $data[] = $test12_value;
        $stmt->execute($data);

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print '登録が完了しました<br><br>';
    print '<input type="button" onclick="location.href=\'c_phisical_test_not_done_player_list.php\'" value="戻る">';

    ?>

</body>

</html>