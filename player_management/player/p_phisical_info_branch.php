<?php

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    header('Location: p_phisical_info_edit.php?id=' . $id);
    exit();
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    header('Location: p_phisical_info_delete.php?id=' . $id);
    exit();
}