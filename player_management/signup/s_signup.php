<?php
    session_start();
    session_regenerate_id(true);
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
    <title>Signup</title>
</head>
<body>

    <h2>新規登録</h2>
    <br>
    <form method="post" action="s_signup_check.php">
        所属を選択してください。<br>
        <select name="belong_name">
            <option value="新川高校">新川高校</option>
            <option value="D.B.アカデミー">D.B.アカデミー</option>
        </select><br>
        <br>
        氏名を入力してください。<br>
        <input type="text" name="name"><br>
        <br>
        パスワードを入力してください。<br>
        <input type="password" name="pass"><br>
        <br>
        パスワードをもう１度入力してください。<br>
        <input type="password" name="pass2"><br>
        <br>
        <input type="submit" value="次へ">
    </form>
    
</body>
</html>