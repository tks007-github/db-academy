<!-- 
    フィジカルテスト入力済み選手の編集画面です。
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
    <title>c_phisical_test_done_player_edit.php</title>
</head>

<body>

    <h3>フィジカルテスト編集</h3>

    <?php

    // player_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];
    // c_phisical_test_done_player_listからの情報をSESSIONで受け取る
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
                SELECT phisical_test_record_code, 10m走, 20m走, 30m走, 50m走, 1500m走,  
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
    print '<form method="post" action="c_phisical_test_done_player_edit_check.php">';
    print '<input type="hidden" name="phisical_test_record_code" value="' . $rec['phisical_test_record_code'] . '">';
    if ($test1_boolean) {
        print '10m走 <input type="text" name="10m走_value" value="' . $rec['10m走'] . '"> 秒<br>';
    }
    if ($test2_boolean) {
        print '20m走 <input type="text" name="20m走_value" value="' . $rec['20m走'] . '"> 秒<br>';
    }
    if ($test3_boolean) {
        print '30m走 <input type="text" name="30m走_value" value="' . $rec['30m走'] . '"> 秒<br>';
    }
    if ($test4_boolean) {
        print '50m走 <input type="text" name="50m走_value" value="' . $rec['50m走'] . '"> 秒<br>';
    }
    if ($test5_boolean) {
        print '1500m走 <input type="text" name="1500m走_min_value" value="' . floor($rec['1500m走'] / 60) . '"> 分 <input type="text" name="1500m走_sec_value" value="' . $rec['1500m走'] % 60 . '"> 秒<br>';
    }
    if ($test6_boolean) {
        print 'プロアジリティ <input type="text" name="プロアジリティ_value" value="' . $rec['プロアジリティ'] . '"> 秒<br>';
    }
    if ($test7_boolean) {
        print '立ち幅跳び <input type="text" name="立ち幅跳び_value" value="' . $rec['立ち幅跳び'] . '"> cm<br>';
    }
    if ($test8_boolean) {
        print 'メディシンボール投げ <input type="text" name="メディシンボール投げ_value" value="' . $rec['メディシンボール投げ'] . '"> m<br>';
    }
    if ($test9_boolean) {
        print '垂直飛び <input type="text" name="垂直飛び_value" value="' . $rec['垂直飛び'] . '"> cm<br>';
    }
    if ($test10_boolean) {
        print '背筋力 <input type="text" name="背筋力_value" value="' . $rec['背筋力'] . '"> kg<br>';
    }
    if ($test11_boolean) {
        print '握力 <input type="text" name="握力_value" value="' . $rec['握力'] . '"> kg<br>';
    }
    if ($test12_boolean) {
        print 'サイドステップ <input type="text" name="サイドステップ_value" value="' . $rec['サイドステップ'] . '"> 回<br>';
    }
    print '<br><br>';
    print '<input type="button" onclick="location.href=\'c_phisical_test_done_player_list.php\'" value="戻る">';
    print '<input type="submit" value="編集">';


    ?>

</body>

</html>