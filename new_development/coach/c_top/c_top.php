<!-- 
    コーチページのトップ画面です。
    以下のページへのリンクを用意します。

    選手検索→c_search_top.php
    フィジカルテスト→c_phisical_test_top.php

    パスワード変更→c_top_password_change.php
    ログアウト→c_top_logout.php

    ※管理者(C0001)のみマスターパスワード変更ページへのリンクあり。
    マスターパスワード変更→c_top_master_password_change.php
 -->

<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['c_login'])) {     // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
        print 'ログインされていません。<br>';
        print '<a href="c_top_login.html">ログイン画面へ</a>';
        exit();
    } else {                                // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
        print $_SESSION['coach_name'];
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
    <title>c_top.php</title>
</head>
<body>

    <h3>トップページ</h3>
    <br>
    
    <a href="../c_search/c_search_top.php">選手検索</a><br>
    <a href="../c_phisical_test/c_phisical_test_top.php">フィジカルテスト</a><br>
    <br><br>
    
    <?php
        if ($_SESSION['coach_code'] == 'C0001') {   // 管理者(C0001)でログインしている場合
            print '<a href="c_top_master_password_change.php">マスターパスワードの変更はこちらから</a><br>';
        }
    ?>

    <a href="c_top_password_change.php">パスワードの変更はこちらから</a>
    <br><br>
    <input type="button" onclick="location.href='c_top_logout.php'" value="ログアウト">

</body>
</html>