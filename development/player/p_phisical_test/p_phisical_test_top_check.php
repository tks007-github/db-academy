<?php

session_start();
session_regenerate_id(true);

if (!isset($_POST['phisical_test_code'])) {
    header('Location: p_phisical_test_top_ng.php');
    exit();
} else {
    // 自作の関数を呼び出す
    require_once('../../function/function.php');

    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);

    // p_phisical_test_topから情報をPOSTで受け取る
    $phisical_test_code = $post['phisical_test_code'];

    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_testテーブルからbelong_codeを使って情報を検索
        $sql = '
                SELECT date, 10m走, 20m走, 30m走, 50m走, 1500m走, 
                プロアジリティ, 立ち幅跳び, メディシンボール投げ, 
                垂直飛び, 背筋力, 握力, サイドステップ
                FROM phisical_test 
                WHERE phisical_test_code = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $phisical_test_code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // db_academyデータベースから切断する
        $dbh = null;

        $_SESSION['date'] = $rec['date'];
        $_SESSION['10m走_boolean'] = $rec['10m走'];
        $_SESSION['20m走_boolean'] = $rec['20m走'];
        $_SESSION['30m走_boolean'] = $rec['30m走'];
        $_SESSION['50m走_boolean'] = $rec['50m走'];
        $_SESSION['1500m走_boolean'] = $rec['1500m走'];
        $_SESSION['プロアジリティ_boolean'] = $rec['プロアジリティ'];
        $_SESSION['立ち幅跳び_boolean'] = $rec['立ち幅跳び'];
        $_SESSION['メディシンボール投げ_boolean'] = $rec['メディシンボール投げ'];
        $_SESSION['垂直飛び_boolean'] = $rec['垂直飛び'];
        $_SESSION['背筋力_boolean'] = $rec['背筋力'];
        $_SESSION['握力_boolean'] = $rec['握力'];
        $_SESSION['サイドステップ_boolean'] = $rec['サイドステップ'];

        header('Location: p_phisical_test_content.php');
        exit();
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
}
