<!-- 
    c_phisical_test_content.phpから受け取った日付(date)と所属(belong_code)の
    データをphisical_testテーブルから削除する。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_login'])) {     // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
    print 'ログインされていません。<br>';
    print '<a href="../c_top/c_top_login.php">ログイン画面へ</a>';
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
    <title>c_phisical_test_delete_done.php</title>
</head>

<body>

    <h3>フィジカルテストの削除完了</h3>

    <?php

    // c_phisical_test_content.phpからの情報をSESSIONで受け取る
    $date = $_SESSION['date'];
    $belong_code = $_SESSION['belong_code'];

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_testテーブルから情報を削除
        $sql = '
                DELETE FROM phisical_test
                WHERE date = ? AND belong_code = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $date;
        $data[] = $belong_code;
        $stmt->execute($data);

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print '削除が完了しました<br><br>';
    print '<input type="button" onclick="location.href=\'c_phisical_test_top.php\'" value="戻る">';

    ?>

</body>

</html>