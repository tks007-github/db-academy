<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="p_login.html">ログイン画面へ</a>';
    exit();
} else {
    $p_code = $_SESSION['p_code'];
    print $p_code;
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
    <title>Player</title>
</head>

<body>

    <h3>削除完了</h3>

    <?php
    try {
        // p_phisical_info_delete.phpから渡された値をサニタイズ
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');

        // player_managementデータベースに接続
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルのデータを削除
        $sql = 'DELETE FROM phisical_info WHERE id = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $id;
        $stmt->execute($data);

        // player_managementデータベースから切断
        $dbh = null;

    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

    削除が完了しました<br>
    <br>
    <a href="p_phisical_info.php">身体情報トップ</a>

</body>

</html>