<?php

session_start();
session_regenerate_id(true);

if (!isset($_POST['player_code'])) {
    header('Location: c_phisical_test_player_no_ng.php');
    exit();
} else {
    // 自作の関数を呼び出す
    require_once('../../function/function.php');
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);
    if (isset($_POST['add'])) {
        header('Location: c_phisical_test_player_no_add.php');
        exit();
    } else if (isset($_POST['player_list'])) {
        header('Location: c_phisical_test_player_list.php');
        exit();
    }  else if (isset($_POST['result'])) {
        header('Location: c_phisical_test_result.php');
        exit();
    }
    
}
