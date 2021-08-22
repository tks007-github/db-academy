<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['p_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="p_top_login.html">ログイン画面へ</a>';
        exit();
    } else {
        if (!isset($_SESSION['c_login'])) {
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
    <title>p_top_pass_change_done</title>
</head>

<body>

    <h3>パスワード変更完了</h3>

    <?php
    try {
        // player_codeをセッションで受け取る
        $player_code = $_SESSION['player_code'];

        // p_top_pass_change.phpから渡された値をセッションで受け取る
        $new_player_password = $_SESSION['new_player_password'];

        // db_academyデータベースに接続
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // playerテーブルのplayer_passwordを更新する
        $sql = 'UPDATE player SET player_password = ? WHERE player_code = ?';
        $stmt = $dbh->prepare($sql);
        $data[] = $new_player_password;
        $data[] = $player_code;
        $stmt->execute($data);

        // player_managementデータベースから切断
        $dbh = null;

        print 'パスワードを変更しました<br>';
        print '新しいパスワード：' . $new_player_password . '<br>';
        
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

    <br>
    <input type="button" onclick="location.href='p_top.php'" value="トップ">

</body>

</html>