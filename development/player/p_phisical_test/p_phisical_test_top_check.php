<?php

session_start();
session_regenerate_id(true);

if (!isset($_POST['date'])) {
    header('Location: p_phisical_test_top_ng.php');
    exit();
} else {
    // 自作の関数を呼び出す
    require_once('../../function/function.php');

    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);

    // p_phisical_test_topから情報をPOSTで受け取る
    $date = $post['date'];
    $test1_boolean = $post['10m走_boolean'];
    $test2_boolean = $post['20m走_boolean'];
    $test3_boolean = $post['30m走_boolean'];
    $test4_boolean = $post['50m走_boolean'];
    $test5_boolean = $post['1500m走_boolean'];
    $test6_boolean = $post['プロアジリティ_boolean'];
    $test7_boolean = $post['立ち幅跳び_boolean'];
    $test8_boolean = $post['メディシンボール投げ_boolean'];
    $test9_boolean = $post['垂直飛び_boolean'];
    $test10_boolean = $post['背筋力_boolean'];
    $test11_boolean = $post['握力_boolean'];
    $test12_boolean = $post['サイドステップ_boolean'];

    $_SESSION['date'] = $date;
    $_SESSION['10m走_boolean'] = $test1_boolean;
    $_SESSION['20m走_boolean'] = $test2_boolean;
    $_SESSION['30m走_boolean'] = $test3_boolean;
    $_SESSION['50m走_boolean'] = $test4_boolean;
    $_SESSION['1500m走_boolean'] = $test5_boolean;
    $_SESSION['プロアジリティ_boolean'] = $test6_boolean;
    $_SESSION['立ち幅跳び_boolean'] = $test7_boolean;
    $_SESSION['メディシンボール投げ_boolean'] = $test8_boolean;
    $_SESSION['垂直飛び_boolean'] = $test9_boolean;
    $_SESSION['背筋力_boolean'] = $test10_boolean;
    $_SESSION['握力_boolean'] = $test11_boolean;
    $_SESSION['サイドステップ_boolean'] = $test12_boolean;

    header('Location: p_phisical_test_content.php');
    exit();
}
