<!-- 
    p_phisical_info_edit_check.phpから受け取った身体情報をphisical_infoテーブルに
    アップデートする。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません<br>';
    print '<a href="../p_top/p_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)場合)
    if (!isset($_SESSION['c_login'])) {         // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
        print $_SESSION['player_name'];
        print 'さんログイン中<br>';
        print '<br>';
    } else {                                    // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
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
    <title>p_phisical_info_edit_done.php</title>
</head>

<body>

    <h3>身体情報の編集完了</h3>

    <?php

    // p_phisical_info_edit_checkからSESSIONで身体情報を受け取る
    $phisical_info_code = $_SESSION['phisical_info_code'];
    $height = $_SESSION['height'];
    $weight = $_SESSION['weight'];
    $body_fat = $_SESSION['body_fat'];
    $muscle_mass = $_SESSION['muscle_mass'];

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
                UPDATE phisical_info  
                SET height = ?, weight = ?, body_fat = ?, muscle_mass = ?
                WHERE phisical_info_code = ? 
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $height;
        $data[] = $weight;
        $data[] = $body_fat;
        $data[] = $muscle_mass;
        $data[] = $phisical_info_code;
        $stmt->execute($data);

        // player_managementデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print '編集が完了しました<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_info_top_branch.php\'" value="戻る">';

    ?>

</body>

</html>