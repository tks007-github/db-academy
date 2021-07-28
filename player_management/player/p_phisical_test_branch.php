<?php

if (isset($_POST['edit'])) {
    if (!isset($_POST['id'])) {
        header('Location: p_phisical_test_ng.php');
        exit();
    }
    $id = $_POST['id'];
    header('Location: p_phisical_test_edit.php?id=' . $id);
    exit();
}

if (isset($_POST['delete'])) {
    if (!isset($_POST['id'])) {
        header('Location: p_phisical_test_ng.php');
        exit();
    }
    $id = $_POST['id'];
    header('Location: p_phisical_test_delete.php?id=' . $id);
    exit();
}