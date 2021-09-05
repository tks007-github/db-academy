<!-- 
    c_signup_top.phpで入力された情報で登録して良いかの最終確認。
    登録→c_signup_done.php
    戻る→c_signup_top.php
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_signup_login'])) {
    print 'ログインされていません<br>';
    print '<a href="c_signup_login.php">ログイン画面へ</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>c_signup_check</title>
</head>

<body>

    <h3>新規登録確認</h3>

    <?php

    print '下記の内容で登録を行います<br>';
    print '<br>';

    // c_signup_top_check.phpから渡された値をセッションで受け取る
    $coach_name = $_SESSION['coach_name'];
    $coach_password = $_SESSION['coach_password'];

    print '氏名：' . $coach_name . '<br>';
    print 'パスワード：' . $coach_password . '<br>';

    ?>

    <br>
    <input type="button" onclick="location.href='c_signup_top.php'" value="戻る">
    <input type="button" onclick="location.href='c_signup_done.php'" value="登録">

</body>

</html>