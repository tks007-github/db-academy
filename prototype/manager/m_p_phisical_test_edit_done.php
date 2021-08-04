<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['m_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="m_login.html">ログイン画面へ</a>';
        exit();
    } else {
        $p_code = $_SESSION['p_code'];
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

    <h3>登録完了</h3>

    <?php
    try {
        // m_p_phisical_test_add.phpから渡された値をサニタイズ
        $test_id = htmlspecialchars($_POST['test_id'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
        
        if (isset($_POST['test1'])) {
            $test1 = htmlspecialchars($_POST['test1'], ENT_QUOTES, 'UTF-8');
            $test1_value = 1;
        } else {
            $test1 = '';
            $test1_value = 0;
        }
        if (isset($_POST['test2'])) {
            $test2 = htmlspecialchars($_POST['test2'], ENT_QUOTES, 'UTF-8');
            $test2_value = 1;
        } else {
            $test2 = '';
            $test2_value = 0;
        }
        if (isset($_POST['test3'])) {
            $test3 = htmlspecialchars($_POST['test3'], ENT_QUOTES, 'UTF-8');
            $test3_value = 1;
        } else {
            $test3 = '';
            $test3_value = 0;
        }

        $test_result[] = $test1;
        $test_result[] = $test2;
        $test_result[] = $test3;

        $test_value[] = $test1_value;
        $test_value[] = $test2_value;
        $test_value[] = $test3_value;

        // player_managementデータベースに接続
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルに新たなデータを登録
        $sql = '
                UPDATE phisical_test 
                SET test1 = ?, test2 = ?, test3 = ?
                WHERE id = ? 
                ';
        $stmt = $dbh->prepare($sql);
        $data[0] = $test1;
        $data[1] = $test2;
        $data[2] = $test3;
        $data[3] = $test_id;
        $stmt->execute($data);

        // phisical_test_itemテーブルから項目名を検索
        $sql2 = '
                SELECT test_value 
                FROM phisical_test_item 
                ORDER BY test_code
                ';
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->execute();

        // player_managementデータベースから切断
        $dbh = null;

        print '以下の情報を登録しました。<br>';
        print '<br>';
        print '日付<br>';
        print $date;
        print '<br><br>';
        print '項目<br>';

        // test_codeのmax値(1～3)までforループをまわす
        for ($i = 0; $i < 3; $i++) {
            $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($test_value[$i]) {
                print $rec2['test_value'] . '　';
                print $test_result[$i];
                print '<br>';
            }
        }
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

    <br>
    <a href="m_p_phisical_test.php">フィジカルテストトップ</a>

</body>

</html>