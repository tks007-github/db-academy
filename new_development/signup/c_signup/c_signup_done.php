<!-- 
    c_signup_top.phpで入力された氏名(coach_name)、パスワード(coach_password)を
    coachテーブルにインサートする。
    その際、パスワード(coach_password)はmd5で暗号化する。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_signup_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="c_signup_login.php">ログイン画面へ</a>';
    exit();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>c_signup_done.php</title>
</head>

<body>

    <h3>新規登録完了</h3>

    <?php

    // c_signup_top_check.phpから渡された値をセッションで受け取る
    $coach_name = $_SESSION['coach_name'];
    $coach_password = $_SESSION['coach_password'];
    // coach_codeをmd5で暗号化
    $coach_password = md5($coach_password);

    // DB接続
    try {

        // db_academyデータベースに接続
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // new_coach_codeテーブルからnew_coach_codeを取得
        $sql1 = 'SELECT new_coach_code FROM new_coach_code';
        $stmt1 = $dbh->prepare($sql1);
        $stmt1->execute();
        $rec1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $new_coach_code = $rec1['new_coach_code'];

        // new_coach_codeテーブルのnew_coach_codeの値に1を加えて更新する
        $sql2 = 'UPDATE new_coach_code SET new_coach_code = ?';
        $stmt2 = $dbh->prepare($sql2);
        $data2[] = $new_coach_code + 1;
        $stmt2->execute($data2);

        // coach_codeを決定
        $coach_code = 'C' . sprintf('%04d', $new_coach_code);

        // coachテーブルにINSERT文で管理者の追加
        $sql3 = 'INSERT INTO coach (coach_code, coach_name, coach_password) VALUES (?, ?, ?)';
        $stmt3 = $dbh->prepare($sql3);
        $data3[] = $coach_code;
        $data3[] = $coach_name;
        $data3[] = $coach_password;
        $stmt3->execute($data3);

        // db_academyデータベースから切断
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print '以下の情報を登録しました。<br>';
    print '管理者コードとパスワードは忘れないようにしてください。<br>';
    print '<br>';
    print '管理者コード：' . $coach_code . '<br>';
    print '氏名：' . $coach_name . '<br>';
    print 'パスワード：' . $_SESSION['coach_password'] . '<br>';


    ?>

</body>

</html>