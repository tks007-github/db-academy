<!-- 
    c_top_password_change_checkから受け取った新しいパスワード(new_coach_password)を
    coachテーブルにアップデートする。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_login'])) {     // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
    print 'ログインされていません。<br>';
    print '<a href="c_top_login.html">ログイン画面へ</a>';
    exit();
} else {                                // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
    print $_SESSION['coach_name'];
    print 'さんログイン中<br>';
    print '<br>';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>c_top_password_change_done.php</title>
</head>

<body>

    <h3>パスワード変更完了</h3>

    <?php

    // coach_codeをSESSIONで受け取る
    $coach_code = $_SESSION['coach_code'];

    // c_top_pass_change.phpから渡された値をセッションで受け取る
    $new_coach_password = $_SESSION['new_coach_password'];
    // new_coach_passwordをmd5で暗号化
    $new_coach_password = md5($new_coach_password);

    // DB接続
    try {
        // db_academyデータベースに接続
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // coachテーブルのcoach_passwordを更新する
        $sql = 'UPDATE coach SET coach_password = ? WHERE coach_code = ?';
        $stmt = $dbh->prepare($sql);
        $data[] = $new_coach_password;
        $data[] = $coach_code;
        $stmt->execute($data);

        // db_academyデータベースから切断
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print 'パスワードを変更しました<br>';
    print '新しいパスワード：' . $_SESSION['new_coach_password'] . '<br>';


    ?>

    <br>
    <input type="button" onclick="location.href='c_top.php'" value="トップ">

</body>

</html>