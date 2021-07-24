<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['login'])) {
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

<?php
    try {
        // p_phisical_info_branch.phpから渡された値をサニタイズ
        $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルからIDを使って情報を検索
        $sql = '
                SELECT date, height, weight 
                FROM phisical_info 
                WHERE id = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[0] = $id;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // player_managementデータベースから切断する
        $dbh = null;

    } catch (Exception $e) {
        exit();
    }
?>
<body>

    <h3>身体情報の編集</h3>
    <br>
    <form method="post" action="p_phisical_info_edit_done.php">
        <input type="hidden" name="id" value="<?php print $id; ?>">
        日付<br>
        <input type="date" name="date" value="<?php print $rec['date']; ?>"><br>
        身長<br>
        <input type="text" name="height" value="<?php print $rec['height']; ?>">cm<br>
        体重<br>
        <input type="text" name="weight" value="<?php print $rec['weight']; ?>">kg<br>
        <br><br>

        <br>
        <input type="button" onclick="location.href='p_phisical_info_list.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>


</body>

</html>