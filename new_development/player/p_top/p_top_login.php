<!-- 
    選手のトップページへのログイン画面です。
    選手は会員コード(player_code)とパスワード(player_password)を使ってログインします。
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
    <title>p_top_login.php</title>
</head>
<body>

    <h3>ログイン</h3>
    <br>
    <?php 
        // p_top_login_check.phpからリダイレクトされた場合(パスワードが正しくなかった場合)
        if (isset($_SESSION['p_login_ng'])) {
            print '入力された会員コードとパスワードが正しくありません。<br><br>';
        }
    ?>
    会員コードとパスワードを入力してください<br>
    <br>
    <form method="post" action="p_top_login_check.php">
        会員コード<br>
        <input type="text" name="player_code"><br>
        <br>
        パスワード<br>
        <input type="password" name="player_password"><br>
        <br>
        <input type="submit" value="ログイン">
    </form>

</body>
</html>