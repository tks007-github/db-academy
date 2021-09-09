<!-- 
    p_phisical_test_edit_check.phpから受け取ったフィジカルテストの情報をphisical_test_recordテーブルに
    インサートする。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません。<br>';
    print '<a href="p_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)の場合)
    if (!isset($_SESSION['c_login'])) {         // 管理者でログイン状態の場合(SESSION[''])
        print $_SESSION['player_name'];
        print 'さんログイン中<br>';
        print '<br>';
    } else {
        print $_SESSION['coach_name'];
        print 'さんログイン中<br>';
        print '選手検索：' . $_SESSION['player_name'];
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_phisical_test_edit_done.php</title>
</head>

<body>

    <h3>フィジカルテストの編集完了</h3>

    <?php

    // player_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];
    // phisical_test_record_codeをSESSIONで受け取る
    $phisical_test_record_code = $_SESSION['phisical_test_record_code'];

    // p_phisical_test_add_checkからSESSIONでフィジカルテスト情報を受け取る
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

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_recordテーブルの情報を更新
        $sql = '
                UPDATE phisical_test_record
                SET 
                10m走 = ?, 20m走 = ?, 30m走 = ?, 50m走 = ?, 1500m走_min = ?, 1500m走_sec = ?, 
                プロアジリティ = ?, 立ち幅跳び = ?, メディシンボール投げ = ?, 垂直飛び = ?,
                背筋力 = ?, 握力 = ?, サイドステップ = ?
                WHERE phisical_test_record_code = ? 
                ';
        $stmt = $dbh->prepare($sql);
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
        $data[] = $phisical_test_record_code;
        $stmt->execute($data);

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print '編集が完了しました<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_test_top.php\'" value="戻る">';

    ?>

</body>

</html>