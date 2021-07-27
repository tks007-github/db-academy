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

    <h3>身体情報一覧</h3>

    <?php
    try {
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
                WHERE player_code = ?
                ORDER BY date
                ';
        $stmt = $dbh->prepare($sql);
        $data[0] = $p_code;
        $stmt->execute($data);

        // player_managementデータベースから切断する
        $dbh = null;

        print '<form method="post" action="m_p_phisical_info_branch.php">';
        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec == false) {
                break;
            }
            print '<input type="radio" name="id" value="' . $rec['id'] . '">';
            print '日付：' . $rec['date'] . '　';
            print '身長：' . $rec['height'] . '　';
            print '体重：' . $rec['weight'] . '　';
            print '<br>';
        }
        print '<br>';
        print '<input type="button" onclick="location.href=\'m_p_phisical_info.php\'" value="戻る">';
        print '<input type="submit" name="edit" value="編集">';
        print '<input type="submit" name="delete" value="削除">';

    } catch (Exception $e) {
        exit();
    }
    ?>

</body>

</html>