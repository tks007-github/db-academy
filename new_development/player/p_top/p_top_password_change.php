<!-- 
    選手のパスワード変更画面です。
    現在のパスワード(player_password)と新しいパスワード(new_player_password)、新しいパスワード確認(new_player_password2)の
    入力を求める。
    ＯＫボタンでp_top_pass_change_check.phpへ遷移。
 -->

<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
        print 'ログインされていません。<br>';
        print '<a href="p_top_login.php">ログイン画面へ</a>';
        exit();
    } else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)の場合)
        if (!isset($_SESSION['c_login'])) {         // 管理者でログイン状態の場合(SESSION[''])
            print $_SESSION['player_name'];
            print 'さんログイン中<br>';
            print '<br>';
        } else {
            print $_SESSION['coach_name'];
            print 'さんログイン中<br>';
            print '選手検索：' . $_SESSION['player_name'];
        }
    }

    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_top_pass_change</title>
</head>
<body>

    <h3>パスワードの変更</h3>
    <br>
    
    <form method="post" action="p_top_pass_change_check.php">
        現在のパスワードを入力してください<br>
        <input type="password" name="player_password"><br>
        <br>
        新しいパスワードを入力してください<br>
        <input type="password" name="new_player_password"><br>
        <br>
        新しいパスワードをもう一度入力してください<br>
        <input type="password" name="new_player_password2"><br>
        <br>
        <input type="button" onclick="location.href='p_top.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>
    
</body>
</html>