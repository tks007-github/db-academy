<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['m_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="m_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['m_code'];
    print 'さんログイン中<br>';
    print '<br>';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
</head>

<body>

    <h3>フィジカルテストの新規作成（確認）</h3>

    <?php

    // m_phisical_test_create_check.phpから渡された値をサニタイズ
    $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');

    print '<form method="post" action="m_phisical_test_create_done.php">';

    print '日付<br>';
    print $date;
    print '<br><br>';
    print '<input type="hidden" name="date" value="' . $date . '">';

    print '項目<br>';
    // test_codeのmax値までforループをまわす
    for ($i = 1; $i < 4; $i++) {
        if (isset($_POST['test_code' . $i])) {
            $test_code = htmlspecialchars($_POST['test_code' . $i], ENT_QUOTES, 'UTF-8');
            $test_value = htmlspecialchars($_POST['test_value' . $i], ENT_QUOTES, 'UTF-8');

            print $test_code;
            print '　';
            print $test_value;
            print '<br>';
            print '<input type="hidden" name="test_code' . $i . '" value="' . $test_code . '">';
            print '<input type="hidden" name="test_value' . $i . '" value="' . $test_code . '">';
        }
    }

    print '<input type="button" onclick="location.href=\'m_phisical_test_create.php\'" value="戻る">';
    print '<input type="submit" value="ＯＫ">';
    print '</form>';

    ?>

</body>

</html>