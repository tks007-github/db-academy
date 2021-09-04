<!-- 
    p_signup_top.phpで入力された所属(belong_code)、氏名(player_name)、パスワード(player_password)を
    playerテーブルにインサートする。
    その際、パスワード(player_password)はmd5で暗号化する。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_signup_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="p_signup_login.php">ログイン画面へ</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_signup_done.php</title>
</head>

<body>

    <h3>新規登録完了</h3>

    <?php

    // p_signup_top_check.phpから渡された値をセッションで受け取る
    $belong_code = $_SESSION['belong_code'];
    $player_name = $_SESSION['player_name'];
    $player_password = $_SESSION['player_password'];
    // player_passwordをmd5で暗号化
    $player_password = md5($player_password);

    // belong_codeからbelong_nameを得るための連想配列を用意
    $belong_name['A'] = '新川高校';
    $belong_name['B'] = 'D.B.アカデミー';

    // DB接続
    try {

        // db_academyデータベースに接続
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // new_player_codeテーブルからnew_player_codeを取得
        $sql1 = 'SELECT new_player_code FROM new_player_code WHERE belong_code = ?';
        $stmt1 = $dbh->prepare($sql1);
        $data1[] = $belong_code;
        $stmt1->execute($data1);
        $rec1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $new_player_code = $rec1['new_player_code'];

        // new_player_codeテーブルのnew_player_codeの値に1を加えて更新する
        $sql2 = 'UPDATE new_player_code SET new_player_code = ? WHERE belong_code = ?';
        $stmt2 = $dbh->prepare($sql2);
        $data2[] = $new_player_code + 1;
        $data2[] = $belong_code;
        $stmt2->execute($data2);

        // player_codeを決定
        $player_code = $belong_code . sprintf('%04d', $new_player_code);

        // playerテーブルにINSERT文で選手の追加
        $sql3 = 'INSERT INTO player (player_code, player_name, player_password, belong_code) VALUES (?, ?, ?, ?)';
        $stmt3 = $dbh->prepare($sql3);
        $data3[] = $player_code;
        $data3[] = $player_name;
        $data3[] = $player_password;
        $data3[] = $belong_code;
        $stmt3->execute($data3);

        // player_managementデータベースから切断
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }


    print '以下の情報を登録しました。<br>';
    print '選手コードとパスワードは忘れないようにしてください。<br>';
    print '<br>';
    print '選手コード：' . $player_code . '<br>';
    print '所属：' . $belong_name[$belong_code] . '<br>';
    print '氏名：' . $player_name . '<br>';
    print 'パスワード：' . $_SESSION['player_password'] . '<br>';   // $player_passwordは暗号化されてしまっているのでSESSION変数を用いている


    ?>

</body>

</html>