<!-- 
    p_top_password_change_checkから受け取った新しいパスワード(new_player_password)を
    playerテーブルにアップデートする。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません<br>';
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
    <title>p_top_password_change_done.php</title>
</head>

<body>

    <h3>パスワード変更完了</h3>

    <?php

    // player_codeをセッションで受け取る
    $player_code = $_SESSION['player_code'];

    // p_top_password_change.phpから渡された値をセッションで受け取る
    $new_player_password = $_SESSION['new_player_password'];
    // new_player_passwordをmd5で暗号化
    $new_player_password = md5($new_player_password);

    try {
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
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print 'パスワードを変更しました<br>';
    print '新しいパスワード：' . $_SESSION['new_player_password'] . '<br>';

    ?>

    <br>
    <input type="button" onclick="location.href='p_top.php'" value="トップ">

</body>

</html>