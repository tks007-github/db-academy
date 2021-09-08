<!-- 
    p_phisical_info_delete.phpから受け取った身体情報コード(phisical_info_code)の
    データをphisical_infoテーブルから削除する。
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
    <title>p_phisical_info_delete_done</title>
</head>

<body>

    <h3>身体情報の削除完了</h3>

    <?php

    // SESSIONでphisical_info_codeを受け取る
    $phisical_info_code = $_SESSION['phisical_info_code'];

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルに情報を追加
        $sql = '
                DELETE FROM phisical_info  
                WHERE phisical_info_code = ? 
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $phisical_info_code;
        $stmt->execute($data);

        // player_managementデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print '削除が完了しました<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_info_top.php\'" value="戻る">';

    ?>

</body>

</html>