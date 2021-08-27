<?php
session_start();
session_regenerate_id(true);

try {
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

    // db_academyデータベースに接続する
    $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // phisical_test_recordテーブルからplayer_codeとdateを使って情報を検索
    $sql = '
            SELECT 10m走, 20m走, 30m走, 50m走, 1500m走_min, 1500m走_sec,  
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

    if ($rec == '') {                     // データベースからの問い合わせ結果がない場合
        header('Location: p_phisical_test_add.php');
        exit();
    } else {                              // データベースからの問い合わせ結果があった場合
        header('Location: p_phisical_test_content.php');
        exit();
    }
} catch (Exception $e) {
    var_dump($e);
    exit();
}
