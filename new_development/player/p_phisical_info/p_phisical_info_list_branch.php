<!-- 
    p_phisical_info_list.phpでラジオボタン選択(POST['phisical_info_code'])の有無と
    押されたボタン(POST['edit'] or POST['delete'])の種類によって遷移先を決定する。

    ラジオボタン選択なし→p_phisical_info_list_branch_ng.php
    編集ボタン→p_phisical_info_edit.php
    削除ボタン→p_phisical_info_delete.php
 -->

<?php

// p_phisical_info_list.phpにて編集ボタンが押された場合
if (isset($_POST['edit'])) {
    if (!isset($_POST['phisical_info_code'])) {
        header('Location: p_phisical_info_list_branch_ng.php');
        exit();
    }
    $phisical_info_code = $_POST['phisical_info_code'];
    header('Location: p_phisical_info_edit.php?phisical_info_code=' . $phisical_info_code);
    exit();
}

// p_phisical_info_list.phpにて削除ボタンが押された場合
if (isset($_POST['delete'])) {
    if (!isset($_POST['phisical_info_code'])) {
        header('Location: p_phisical_info_list_branch_ng.php');
        exit();
    }
    $phisical_info_code = $_POST['phisical_info_code'];
    header('Location: p_phisical_info_delete.php?phisical_info_code=' . $phisical_info_code);
    exit();
}