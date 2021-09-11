<!-- 
    c_top_master_password_change_checkから受け取った新しいパスワード(new_mst_password)を
    mst_passwordテーブルにアップデートする。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_login'])) {     // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
    print 'ログインされていません。<br>';
    print '<a href="c_top_login.php">ログイン画面へ</a>';
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
    <title>c_top_master_password_change_done.php</title>
</head>

<body>

    <h3>マスターパスワード変更完了</h3>

    <?php

    // c_top_master_pass_change.phpから渡された値をセッションで受け取る
    $new_mst_password = $_SESSION['new_mst_password'];
    // new_mst_passwordをmd5で暗号化
    $new_mst_password = md5($new_mst_password);

    $mst_code = 1;

    // DB接続
    try {
        // db_academyデータベースに接続
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // mst_passwordテーブルのmst_passwordを更新する
        $sql = 'UPDATE mst_password SET mst_password = ? WHERE mst_code = ?';
        $stmt = $dbh->prepare($sql);
        $data[] = $new_mst_password;
        $data[] = $mst_code;
        $stmt->execute($data);

        // db_academyデータベースから切断
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print 'マスターパスワードを変更しました<br>';
    print '新しいマスターパスワード：' . $_SESSION['new_mst_password'] . '<br>';

    ?>

    <br>
    <input type="button" onclick="location.href='c_top.php'" value="トップ">

</body>

</html>