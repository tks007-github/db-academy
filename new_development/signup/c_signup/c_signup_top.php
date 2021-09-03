<!-- 
    コーチのサインアップ画面です。
    氏名(coach_name)、パスワード(coach_password)、パスワード確認(coach_password2)の
    入力を受け付ける。
 -->

<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['c_signup_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="c_signup_login.php">ログイン画面へ</a>';
        exit();
    }

    // SESSION変数(coachテーブルにインサートする内容を表す変数)の削除(初期化)
    unset($_SESSION['coach_name']);
    unset($_SESSION['coach_password']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>c_signup_top.php</title>
</head>
<body>

    <h3>新規登録</h3>
    <br>
    <form method="post" action="c_signup_top_check.php">
        氏名を入力してください<br>
        <input type="text" name="coach_name"><br>
        <br>
        パスワードを入力してください<br>
        <input type="password" name="coach_password"><br>
        <br>
        パスワードをもう１度入力してください<br>
        <input type="password" name="coach_password2"><br>
        <br>
        <input type="submit" value="次へ">
    </form>
    
</body>
</html>