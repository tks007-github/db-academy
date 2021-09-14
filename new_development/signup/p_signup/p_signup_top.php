<!-- 
    選手のサインアップ画面です。
    所属(belong_code)、氏名(player_name)、パスワード(player_password)、パスワード確認(player_password2)の
    入力を受け付ける。
 -->

<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['p_signup_login'])) {
        print 'ログインされていません<br>';
        print '<a href="p_signup_login.php">ログイン画面へ</a>';
        exit();
    }

    // SESSION変数(サインアップする内容を表す変数)の削除(初期化)
    unset($_SESSION['belong_code']);
    unset($_SESSION['player_name']);
    unset($_SESSION['player_password']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_signup_top.php</title>
</head>
<body>

    <h3>新規登録</h3>
    <br>
    <form method="post" action="p_signup_top_check.php">
        所属を選択してください<br>
        <select name="belong_code">
            <option value=""></option>
            <option value="A">新川高校</option>
            <option value="B">D.B.アカデミー</option>
        </select><br>
        <br>
        氏名を入力してください<br>
        <input type="text" name="player_name"><br>
        <br>
        パスワードを入力してください(半角英数字6文字以上14文字以内)<br>
        <input type="password" name="player_password"><br>
        <br>
        パスワードをもう１度入力してください<br>
        <input type="password" name="player_password2"><br>
        <br>
        <input type="submit" value="次へ">
    </form>
    
</body>
</html>