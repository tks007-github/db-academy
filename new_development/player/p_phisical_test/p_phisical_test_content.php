<!-- 
    p_phisical_test_top_branchで選択された情報をフィジカルテストの情報を表示する。
    ラジオボタンで選択し、編集・削除・成績表ボタンを押すことで遷移する。

    編集→p_phisical_test_edit.php
    削除→p_phisical_test_delete.php
    成績表→p_phisical_test_graph.php
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません<br>';
    print '<a href="../p_top/p_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)場合)
    if (!isset($_SESSION['c_login'])) {         // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
        print $_SESSION['player_name'];
        print 'さんログイン中<br>';
        print '<br>';
    } else {                                    // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
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
    <title>p_phisical_test_content.php</title>
</head>

<body>

    <h3>フィジカルテスト内容</h3>

    <?php

    // player_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];

    // p_phisical_test_topからの情報をSESSIONで受け取る
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

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_recordテーブルからplayer_codeとdateを使って情報を検索
        $sql = '
                SELECT 10m走, 20m走, 30m走, 50m走, 1500m走, 
                プロアジリティ, 立ち幅跳び, メディシンボール投げ, 
                垂直飛び, 背筋力, 握力, サイドステップ 
                FROM phisical_test_record 
                WHERE player_code = ?
                AND date = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $player_code;
        $data[] = $date;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }


    print 'フィジカルテスト結果(' . $date . ')<br><br>';
    if ($test1_boolean) {
        print '10m走：' . $rec['10m走'] . '秒<br>';
    }
    if ($test2_boolean) {
        print '20m走：' . $rec['20m走'] . '秒<br>';
    }
    if ($test3_boolean) {
        print '30m走：' . $rec['30m走'] . '秒<br>';
    }
    if ($test4_boolean) {
        print '50m走：' . $rec['50m走'] . '秒<br>';
    }
    if ($test5_boolean) {
        print '1500m走：' . floor($rec['1500m走'] / 60) . '分' . $rec['1500m走'] % 60 . '秒<br>';
    }
    if ($test6_boolean) {
        print 'プロアジリティ：' . $rec['プロアジリティ'] . '秒<br>';
    }
    if ($test7_boolean) {
        print '立ち幅跳び：' . $rec['立ち幅跳び'] . 'cm<br>';
    }
    if ($test8_boolean) {
        print 'メディシンボール投げ：' . $rec['メディシンボール投げ'] . 'm<br>';
    }
    if ($test9_boolean) {
        print '垂直飛び：' . $rec['垂直飛び'] . 'cm<br>';
    }
    if ($test10_boolean) {
        print '背筋力：' . $rec['背筋力'] . 'kg<br>';
    }
    if ($test11_boolean) {
        print '握力：' . $rec['握力'] . 'kg<br>';
    }
    if ($test12_boolean) {
        print 'サイドステップ：' . $rec['サイドステップ'] . '回<br>';
    }
    print '<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_test_top.php\'" value="戻る">';
    print '<input type="button" onclick="location.href=\'p_phisical_test_edit.php\'" value="編集">';
    print '<input type="button" onclick="location.href=\'p_phisical_test_delete.php\'" value="削除">';
    print '<input type="button" onclick="location.href=\'p_phisical_test_result.php\'" value="成績表">';

    ?>

</body>

</html>