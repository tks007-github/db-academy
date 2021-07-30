<?php

if (isset($_POST['edit'])) {
    if (!isset($_POST['id'])) {
        header('Location: m_p_phisical_test_ng.php');
        exit();
    }
    $id = $_POST['id'];
    $test_id = $_POST['test_id'];
    header('Location: m_p_phisical_test_edit.php?id=' . $id . '&test_id=' .$test_id);
    exit();
}

if (isset($_POST['delete'])) {
    if (!isset($_POST['id'])) {
        header('Location: m_p_phisical_test_ng.php');
        exit();
    }
    $id = $_POST['id'];
    $test_id = $_POST['test_id'];
    header('Location: m_p_phisical_test_delete.php?id=' . $id . '&test_id=' .$test_id);
    exit();
}