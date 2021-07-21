<?php
    session_start();
    if (!isset($_SESSION['login'])) {
        print 'ログインされていません。<br>';
        print '<a href="s_login.html">ログイン画面へ</a>';
        exit();
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h3>ログイン成功</h3>
    
</body>
</html>