<?php

session_start();
session_regenerate_id(true);

if (!isset($_POST['phisical_test_code'])) {
    header('Location: c_phisical_test_list_ng.php');
    exit();
} else {
    // 自作の関数を呼び出す
    require_once('../../function/function.php');
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);
    $_SESSION['phisical_test_code'] = $post['phisical_test_code'];
    header('Location: c_phisical_test_delete.php');
    exit();
}
