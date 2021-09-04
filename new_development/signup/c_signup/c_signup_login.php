<!-- 
    コーチのサインアップページへのログイン画面です。
    コーチは管理者から教えてもらったパスワード(mst_password)を用いてログインをします。
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
    <title>c_signup_login.php</title>
</head>
<body>

    <h3>ログイン(コーチ登録)</h3>
    <br>
    <?php 
        // c_signup_login_check.phpからリダイレクトされた場合(パスワードが正しくなかった場合)
        if (isset($_SESSION['c_signup_login_ng'])) {
            print '入力されたパスワードに誤りがあります。<br><br>';
        }
    ?>
    <form method="post" action="c_signup_login_check.php">
    パスワードを入力してください<br>
    <br>
    <input type="password" name="mst_password" style="width: 100px;"><br>
    <br><br>
    <input type="submit" value="ログイン">
    </form>
    
</body>
</html>