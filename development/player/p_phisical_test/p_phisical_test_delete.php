<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['p_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="../p_top/p_top_login.html">ログイン画面へ</a>';
        exit();
    } else {
        if (!isset($_SESSION['c_login'])) {
            print $_SESSION['player_name'];
            print 'さんログイン中<br>';
            print '<br>';
        } else {
            print $_SESSION['coach_name'];
            print 'さんログイン中<br>';
            print '選手検索：' . $_SESSION['player_name'];
        }
        
    }
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_phisical_test_delete</title>
</head>

<body>

    <h3>フィジカルテストの削除</h3>
    <br>

    <?php

        print '本当に削除しますか<br><br>';

        print '<br>';
        print '<input type="button" onclick="location.href=\'p_phisical_test_content.php\'" value="戻る">';
        print '<input type="button" onclick="location.href=\'p_phisical_test_delete_done.php\'" value="削除">';

    ?>

</body>

</html>