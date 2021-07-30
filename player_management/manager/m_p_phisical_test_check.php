<?php

if (!isset($_POST['id'])) {
    header('Location: m_p_phisical_test_ng.php');
    exit();
} else {
    $id = $_POST['id'];
    header('Location: m_p_phisical_test_content.php?id=' . $id);
    exit();
}
