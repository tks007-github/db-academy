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

    <h3>選手検索</h3>
    <br>
    
    選手の会員コードを入力してください<br>
    <br>
    <form method="post" action="m_search_check.php">
        会員コード<br>
        <input type="text" name="p_code"><br>
        <br>
        <input type="submit" value="検索">
    </form>

</body>
</html>