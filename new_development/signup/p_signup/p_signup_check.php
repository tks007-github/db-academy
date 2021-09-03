<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_signup_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="p_signup_login.php">ログイン画面へ</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_signup_check</title>
</head>

<body>

    <h3>新規登録確認</h3>

    <?php

    print '下記の内容で登録を行います。<br>';
    print '<br>';

    // p_signup_top_check.phpから渡された値をセッションで受け取る
    $belong_code = $_SESSION['belong_code'];
    $player_name = $_SESSION['player_name'];
    $player_password = $_SESSION['player_password'];

    // belong_codeからbelong_nameを得るための連想配列を用意
    $belong_name['A'] = '新川高校';
    $belong_name['B'] = 'D.B.アカデミー';

    print '所属：' . $belong_name[$belong_code] . '<br>';
    print '氏名：' . $player_name . '<br>';
    print 'パスワード：' . $player_password . '<br>';

    ?>

    <br>
    <input type="button" onclick="location.href='p_signup_top.php'" value="戻る">
    <input type="button" onclick="location.href='p_signup_done.php'" value="登録">

</body>

</html>