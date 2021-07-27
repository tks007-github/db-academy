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

    <h3>編集完了</h3>

    <?php
    try {
        // p_phisical_info_edit.phpから渡された値をサニタイズ
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
        $height = htmlspecialchars($_POST['height'], ENT_QUOTES, 'UTF-8');
        $weight = htmlspecialchars($_POST['weight'], ENT_QUOTES, 'UTF-8');

        // player_managementデータベースに接続
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルのデータを更新
        $sql = 'UPDATE phisical_info SET date = ?, height = ?, weight = ? WHERE id = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $date;
        $data[1] = $height;
        $data[2] = $weight;
        $data[3] = $id;
        $stmt->execute($data);

        // player_managementデータベースから切断
        $dbh = null;

        print '以下の情報を編集しました。<br>';
        print '<br>';
        print '日付：' . $date . '<br>';
        print '身長：' . $height . '<br>';
        print '体重：' . $weight . '<br>';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

    <br>
    <a href="p_phisical_info.php">身体情報トップ</a>

</body>

</html>