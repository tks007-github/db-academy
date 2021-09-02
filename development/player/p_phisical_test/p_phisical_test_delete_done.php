<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['p_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="../p_top/p_top_login.html">ログイン画面へ</a>';
        exit();
    } else {
        if (!isset($_SESSION['c_login'])) {
            print $_SESSION['player_name'];
            print 'さんログイン中<br>';
            print '<br>';
        } else {
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
    <title>p_phisical_test_delete_done</title>
</head>

<body>

    <h3>フィジカルテストの削除完了</h3>

    <?php
    try {
        // SESSIONでplayer_codeとdateを受け取る
        $player_code = $_SESSION['player_code'];
        $date = $_SESSION['date'];
        
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_recordテーブルから情報を削除
        $sql = '
                DELETE FROM phisical_test_record  
                WHERE player_code = ? AND date = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $player_code;
        $data[] = $date;
        $stmt->execute($data);

        // db_academyデータベースから切断する
        $dbh = null;

        print '削除が完了しました<br><br>';
        print '<input type="button" onclick="location.href=\'p_phisical_test_top.php\'" value="戻る">';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>