<?php

if (isset($_POST['edit'])) {
    if (!isset($_POST['phisical_info_code'])) {
        header('Location: p_phisical_info_branch_ng.php');
        exit();
    }
    $phisical_info_code = $_POST['phisical_info_code'];
    header('Location: p_phisical_info_edit.php?id=' . $phisical_info_code);
    exit();
}

if (isset($_POST['delete'])) {
    if (!isset($_POST['phisical_info_code'])) {
        header('Location: p_phisical_info_branch_ng.php');
        exit();
    }
    $phisical_info_code = $_POST['phisical_info_code'];
    header('Location: p_phisical_info_delete.php?id=' . $phisical_info_code);
    exit();
}