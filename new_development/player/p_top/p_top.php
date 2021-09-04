<!-- 
    選手ページのトップ画面です。
    以下のページへのリンクを用意します。

    問診票→p_questionnaire_top_branch.php
    身体情報→p_phisical_info_top_branch.php
    フィジカルテスト→p_phisical_test_top.php

    パスワード変更→p_top_password_change.php
    ログアウト→p_top_logout.php
 -->

<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
        print 'ログインされていません。<br>';
        print '<a href="p_top_login.php">ログイン画面へ</a>';
        exit();
    } else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)の場合)
        if (!isset($_SESSION['c_login'])) {         // 管理者でログイン状態の場合(SESSION[''])
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
    <title>p_top.php</title>
</head>
<body>

    <h3>トップページ</h3>
    <br>
    
    <a href="../p_questionnaire/p_questionnaire_top_branch.php">問診表</a><br>
    <a href="../p_phisical_info/p_phisical_info_top_branch.php">身体情報</a><br>
    <a href="../p_phisical_test/p_phisical_test_top.php">フィジカルテスト</a><br>
    <br><br>
    <a href="p_top_password_change.php">パスワードの変更はこちらから</a>
    <br><br>

    <?php

    if (!isset($_SESSION['c_login'])) {     // 管理者でログイン状態でない場合(SESSION['c_login']が未定義の場合)
        print '<input type="button" onclick="location.href=\'p_top_logout.php\'" value="ログアウト">';
    } else {                                // 管理者でログイン状態の場合(SESSION['c_login']が定義されている(=1)の場合)
        print '<input type="button" onclick="location.href=\'../../coach/c_search/c_search_list.php\'" value="戻る">';
    }
    

    ?>

</body>
</html>