<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="../p_top/p_top_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['player_name'];
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
    <title>p_phisical_info_add</title>
</head>

<body>

    <h3>身体情報の登録</h3>
    <br>

    <?php

    // 自作の関数を呼び出す
    require_once('../../function/function.php');


    if ($_SESSION['phisical_info_flg'] == '') {
        // POSTの中身をすべてサニタイズする
        $post = sanitize($_POST);

        // p_phisical_info_topからphisical_info_flgをPOSTで受け取る
        $phisical_info_flg = $post['phisical_info_flg'];
        $_SESSION['phisical_info_flg'] = $phisical_info_flg;
    } else {
        $phisical_info_flg = $_SESSION['phisical_info_flg'];
    }

    print '<form method="post" action="p_phisical_info_add_check.php">';

    print '日付<br>';
    print '<input type="date" name="date">';
    print '<br><br>';

    print '身長<br>';
    print '<input type="text" name="height">cm　';
    if ($phisical_info_flg == 1) {             // 前回の情報がある場合
        print '<input type="checkbox" name="height" value="on">前回の情報を適用';
    }
    print '<br><br>';

    print '体重<br>';
    print '<input type="text" name="weight">kg　';
    if ($phisical_info_flg == 1) {             // 前回の情報がある場合
        print '<input type="checkbox" name="weight" value="on">前回の情報を適用';
    }
    print '<br><br>';

    print '体脂肪率<br>';
    print '<input type="text" name="body_fat">%　';
    if ($phisical_info_flg == 1) {             // 前回の情報がある場合
        print '<input type="checkbox" name="body_fat" value="on">前回の情報を適用';
    }
    print '<br><br>';

    print '筋量<br>';
    print '<input type="text" name="muscle_mass">kg　';
    if ($phisical_info_flg == 1) {             // 前回の情報がある場合
        print '<input type="checkbox" name="muscle_mass" value="on">前回の情報を適用';
    }
    print '<br><br>';

    print '<br>';
    print '<input type="button" onclick="location.href=\'p_phisical_info_top.php\'" value="戻る">';
    print '<input type="submit" value="登録">';
    print '</form>';

    ?>

</body>

</html>