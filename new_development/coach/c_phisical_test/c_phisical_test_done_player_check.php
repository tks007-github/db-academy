<!-- 
    c_phisical_test_done_player_list.phpで選手が選択されているかをチェックし、遷移先を決定する。
    選択されている(編集)→c_phisical_test_done_player_edit.phpへリダイレクト
    選択されている(成績表)→c_phisical_test_done_player_result.phpへリダイレクト
    選択されていない→c_phisical_test_done_player_check_ng.phpへ遷移
 -->

<?php
session_start();
session_regenerate_id(true);

if (!isset($_POST['player_code'])) {
    header('Location: c_phisical_test_done_player_check_ng.php');
    exit();
} else {
    // 自作の関数を呼び出す
    require_once('../../function/function.php');
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);
    $_SESSION['player_code'] = $post['player_code'];
    if (isset($_POST['edit'])) {
        header('Location: c_phisical_test_done_player_edit.php');
        exit();
    }  else if (isset($_POST['result'])) {
        header('Location: c_phisical_test_done_player_result.php');
        exit();
    }
    
}
