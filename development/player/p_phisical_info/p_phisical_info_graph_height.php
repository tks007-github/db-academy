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
    <title>p_phisical_info_graph_height</title>
</head>

<body>

    <h3>身体情報一覧</h3>

    <?php
    // player_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];

    try {
        date_default_timezone_set('Asia/Tokyo');
        // 現在の年(西暦)を取得
        $current_year = date('Y');
        // 現在の月を取得
        $current_month = date('m');
        // 現在の年と月を結合(例. 2021年08月 → 202108)
        $year_month = $current_year . $current_month;

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルからplayer_codeを使って過去1年間の月平均のデータを検索
        $year_month_arr = [];
        $avg_height_arr = [];

        // 今年分
        for ($i = 0; $i < $current_month; $i++) {
            $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(height) AS grouping_height
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ';
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $year_month - $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $year_month_arr[] = $current_year . '/' . ($current_month - $i);
                $avg_height_arr[] = 0;
            } else {
                $year_month_arr[] = $current_year . '/' . ($current_month - $i);
                $avg_height_arr[] = $rec['grouping_height'];
            }
        }

        // 去年分
        $year_month = ($current_year - 1) . 12;
        for ($i = 0; $i < (12 - $current_month); $i++) {
            $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(height) AS grouping_height
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ';
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $year_month - $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $year_month_arr[] = ($current_year - 1) . '/' . (12 - $i);
                $avg_height_arr[] = 0;
            } else {
                $year_month_arr[] = ($current_year - 1) . '/' . (12 - $i);
                $avg_height_arr[] = $rec['grouping_height'];
            }
        }

        var_dump($year_month_arr);
        var_dump($avg_height_arr);

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>