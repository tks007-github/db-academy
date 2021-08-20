<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="../p_top/p_top_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['player_name'];
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
    <title>p_phisical_info_edit_done</title>
</head>

<body>

    <h3>身体情報の編集完了</h3>

    <?php
    try {
        // p_phisical_info_edit_checkからSESSIONで身体情報を受け取る
        $phisical_info_code = $_SESSION['phisical_info_code'];
        $date = $_SESSION['date'];
        $height = $_SESSION['height'];
        $weight = $_SESSION['weight'];
        $body_fat = $_SESSION['body_fat'];
        $muscle_mass = $_SESSION['muscle_mass'];

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルに情報を追加
        $sql = '
                UPDATE phisical_info  
                SET date = ?, height = ?, weight = ?, body_fat = ?, muscle_mass = ?
                WHERE phisical_info_code = ? 
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $date;
        $data[] = $height;
        $data[] = $weight;
        $data[] = $body_fat;
        $data[] = $muscle_mass;
        $data[] = $phisical_info_code;
        $stmt->execute($data);

        // player_managementデータベースから切断する
        $dbh = null;

        print '編集が完了しました<br><br>';
        print '<input type="button" onclick="location.href=\'p_phisical_info_top.php\'" value="戻る">';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>