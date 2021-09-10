<!-- 
    コーチのトップページへのログイン画面です。
    コーチはコーチコード(coach_code)とパスワード(coach_password)を使ってログインします。
 -->

 <?php
    session_start();
    session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>c_top_login.php</title>
</head>
<body>

    <h3>ログイン</h3>
    <br>
    <?php 
        // c_top_login_check.phpからリダイレクトされた場合(パスワードが正しくなかった場合)
        if (isset($_SESSION['c_login_ng'])) {
            print '入力されたコーチコードまたはパスワードが正しくありません。<br><br>';
        }
    ?>
    コーチコードとパスワードを入力してください<br>
    <br>
    <form method="post" action="c_top_login_check.php">
        コーチコード<br>
        <input type="text" name="coach_code"><br>
        <br>
        パスワード<br>
        <input type="password" name="coach_password"><br>
        <br>
        <input type="submit" value="ログイン">
    </form>

</body>
</html>