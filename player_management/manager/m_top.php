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

    <h3>トップページ</h3>
    <br>
    
    <a href="m_search.php">選手検索</a><br>
    <a href="m_phisical_test.php">新規フィジカルテスト作成</a><br>
    <br><br>
    <input type="button" onclick="location.href='m_logout.php'" value="ログアウト">

</body>
</html>