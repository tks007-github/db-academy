<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['m_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="m_login.html">ログイン画面へ</a>';
        exit();
    } else {
        $p_code = $_SESSION['p_code'];
        print $_SESSION['m_code'];
        print 'さんログイン中<br>';
        print '（検索条件：' . $_SESSION['p_code'] . '）';
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
    
    <a href="m_p_questionnaire.php">問診表</a><br>
    <a href="m_p_phisical_info.php">身体情報</a><br>
    <a href="m_p_phisical_test.php">フィジカルテスト</a><br>
    <br><br>
    <input type="button" onclick="location.href='m_search.php'" value="戻る">

</body>
</html>