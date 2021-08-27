<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['p_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="p_top_login.html">ログイン画面へ</a>';
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
    <title>p_top</title>
</head>
<body>

    <h3>トップページ</h3>
    <br>
    
    <a href="../p_questionnaire/p_questionnaire_top_branch.php">問診表</a><br>
    <a href="../p_phisical_info/p_phisical_info_top_branch.php">身体情報</a><br>
    <a href="../p_phisical_test/p_phisical_test_top.php">フィジカルテスト</a><br>
    <br><br>
    <a href="p_top_pass_change.php">パスワードの変更はこちらから</a>
    <br><br>

    <?php

    if (!isset($_SESSION['c_login'])) {
        print '<input type="button" onclick="location.href=\'p_top_logout.php\'" value="ログアウト">';
    } else {
        print '<input type="button" onclick="location.href=\'../../coach/c_search/c_search_top.php\'" value="戻る">';
    }
    

    ?>

</body>
</html>