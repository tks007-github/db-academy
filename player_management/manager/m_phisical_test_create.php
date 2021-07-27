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

    <h3>フィジカルテストの新規作成</h3>
    
    <?php
    try {
        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_itemテーブルからtest_codeとtest_valueを検索
        $sql = '
                SELECT test_code, test_value 
                FROM phisical_test_item
                ORDER BY test_code 
                ';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        // player_managementデータベースから切断する
        $dbh = null;

        
        print '<form method="post" action="m_phisical_test_create_check.php">';
        print '日付<br>';
        print '<input type="date" name="date">';
        print '<br><br>';
        print '項目<br>';
        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!isset($rec['test_value'])) {
                break;
            }
            print '<input type="checkbox" name="id" value="' . $rec['test_code'] . '">';
            print $rec['test_code'] . ' ';
            print '項目名：' . $rec['test_value'] . '　';
            print '<br>';
        }
        print '<br>';
        print '<input type="button" onclick="location.href=\'m_top.php\'" value="戻る">';
        print '<input type="submit" name="edit" value="作成">';

    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>