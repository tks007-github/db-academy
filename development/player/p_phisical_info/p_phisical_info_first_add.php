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
    <title>p_phisical_info_first_add</title>
</head>

<body>

    <h3>身体情報の登録</h3>
    <br>

    <?php

    print '<form method="post" action="p_phisical_info_add_check.php">';

    print '日付<br>';
    print '<input type="date" name="date">';
    print '<br><br>';

    print '身長<br>';
    print '<input type="text" name="height">cm　';
    print '<br><br>';

    print '体重<br>';
    print '<input type="text" name="weight">kg　';
    print '<br><br>';

    print '体脂肪率<br>';
    print '<input type="text" name="body_fat">%　';
    print '<br><br>';

    print '筋量<br>';
    print '<input type="text" name="muscle_mass">kg　';
    print '<br><br>';

    print '<br>';
    print '<input type="button" onclick="location.href=\'../p_top/p_top.php\'" value="戻る">';
    print '<input type="submit" value="登録">';
    print '</form>';

    ?>

</body>

</html>