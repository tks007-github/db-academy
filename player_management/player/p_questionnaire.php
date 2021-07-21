<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['login'])) {
        print 'ログインされていません。<br>';
        print '<a href="s_login.html">ログイン画面へ</a>';
        exit();
    } else {
        print $_SESSION['p_code'];
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
    <title>Player</title>
</head>
<body>

    
    
</body>
</html>