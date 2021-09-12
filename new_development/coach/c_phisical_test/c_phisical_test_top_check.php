<!-- 
    c_phisical_test_top.phpからの入力情報をチェックし、遷移先を決定する。
    問題なし→c_phisical_test_content.phpへリダイレクト
    問題あり→c_phisical_test_top_ng.phpへリダイレクト
 -->

<?php

session_start();
session_regenerate_id(true);

if (!isset($_POST['phisical_test_code'])) {
    header('Location: c_phisical_test_top_ng.php');
    exit();
} else {
    // 自作の関数を呼び出す
    require_once('../../function/function.php');
    
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);
    $_SESSION['phisical_test_code'] = $post['phisical_test_code'];

    header('Location: c_phisical_test_content.php');
    exit();
}
