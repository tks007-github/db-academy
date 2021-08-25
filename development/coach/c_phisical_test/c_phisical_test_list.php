<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['c_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="../c_top/c_top_login.html">ログイン画面へ</a>';
        exit();
    } else {
        print $_SESSION['coach_name'];
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
    <title>c_phisical_test_list</title>
</head>

<body>

    <h3>フィジカルテスト一覧</h3>

    <?php
    // $_SESSIONを初期化
    $_SESSION['phisical_test_code'] = '';
    $_SESSION['belong_code'] = '';
    $_SESSION['date'] = '';
    $_SESSION['10m走_boolean'] = '';
    $_SESSION['20m走_boolean'] = '';
    $_SESSION['30m走_boolean'] = '';
    $_SESSION['50m走_boolean'] = '';
    $_SESSION['1500m走_boolean'] = '';
    $_SESSION['プロアジリティ_boolean'] = '';
    $_SESSION['立ち幅跳び_boolean'] = '';
    $_SESSION['メディシンボール投げ_boolean'] = '';
    $_SESSION['垂直飛び_boolean'] = '';
    $_SESSION['背筋力_boolean'] = '';
    $_SESSION['握力_boolean'] = '';
    $_SESSION['サイドステップ_boolean'] = '';

    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_testテーブルから情報を検索
        $sql = '
                SELECT *
                FROM phisical_test 
                ORDER BY date DESC, belong_code
                ';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        // db_academyデータベースから切断する
        $dbh = null;

        print '<form method="post" action="c_phisical_test_list_check.php">';
        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec == '') {
                break;
            }
            print '<input type="radio" name="phisical_test_code" value="' . $rec['phisical_test_code'] . '">';
            print '日付：' . $rec['date'] . '　';
            print '所属：' . $rec['belong_code'] . '　';
            print '<br>';
        }
        print '<br><br>';
        print '<input type="button" onclick="location.href=\'c_phisical_test_top.php\'" value="戻る">';
        print '<input type="submit" name="delete" value="削除">';
        print '<input type="submit" name="result" value="成績表">';

    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>