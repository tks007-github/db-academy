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

    <h3>フィジカルテストの項目追加</h3>
    
    <?php
    try {
        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_itemテーブルからtest_valueを検索
        $sql = '
                SELECT test_code, test_value 
                FROM phisical_test_item
                ORDER BY test_code 
                ';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        // player_managementデータベースから切断する
        $dbh = null;

        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec['test_value'] == '') {
                $test_code = $rec['test_code'];
                break;
            }
        }
        
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

    新規項目<br>
    <form method="post" action="m_phisical_test_item_add_done.php">
        <?php print $test_code; ?>
        <input type="hidden" name="test_code" value="<?php print $test_code; ?>">
        <input type="text" name="test_value" value="">
        <br><br>
        <input type="button" onclick="location.href='m_p_top.php'" value="戻る">
        <input type="submit" value="登録">
    </form>

</body>

</html>