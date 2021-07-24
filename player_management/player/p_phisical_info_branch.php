<?php

if (isset($_POST['edit'])) {
    if (!isset($_POST['id'])) {
        header('Location: p_phisical_info_ng.php');
        exit();
    }
    $id = $_POST['id'];
    header('Location: p_phisical_info_edit.php?id=' . $id);
    exit();
}

if (isset($_POST['delete'])) {
    if (!isset($_POST['id'])) {
        header('Location: p_phisical_info_ng.php');
        exit();
    }
    $id = $_POST['id'];
    header('Location: p_phisical_info_delete.php?id=' . $id);
    exit();
}