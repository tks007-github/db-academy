<?php

if (isset($_POST['edit'])) {
    header('Location: p_phisical_info_edit.php');
    exit();
}

if (isset($_POST['delete'])) {
    header('Location: p_phisical_info_delete.php');
    exit();
}