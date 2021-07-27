<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['m_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="m_login.html">ログイン画面へ</a>';
        exit();
    } else {
        print $_SESSION['m_code'];
        print 'さんログイン中<br>';
        print '（検索条件：' . $_SESSION['p_code'] . '）';
        print '<br>';
    }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
</head>

<body>

    <h3>身体情報削除</h3>

    <?php
    try {
        // m_p_phisical_info_branch.phpから渡された値をサニタイズ
        $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルから会員コードを使って情報を検索
        $sql = '
                SELECT id, date, height, weight 
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

    本当に削除しますか？<br><br>
    <form method="post" action="m_p_phisical_info_delete_done.php">
        <input type="hidden" name="id" value="<?php print $id; ?>">
        日付：<?php print $rec['date']; ?><br>
        身長：<?php print $rec['height']; ?><br>
        体重：<?php print $rec['weight']; ?><br>
        <br>
        <input type="button" onclick="location.href='m_p_phisical_info_list.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>

</body>

</html>