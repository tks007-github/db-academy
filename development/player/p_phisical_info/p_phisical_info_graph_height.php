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
    <title>p_phisical_info_graph</title>
</head>

<body>

    <h3>身体情報一覧</h3>

    <?php
    // player_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];
    // graph_height、graph_weight、graph_body_fat、graph_muscle_massをSESSIONで受け取る
    $graph_height = $_SESSION['graph_height'];
    $graph_weight = $_SESSION['graph_weight'];
    $graph_body_fat = $_SESSION['graph_body_fat'];
    $graph_muscle_mass = $_SESSION['graph_muscle_mass'];

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

        $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(height) AS grouping_height
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ORDER BY grouping_date DESC
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $player_code;
        $data[] = $year_month - 1;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);


        // db_academyデータベースから切断する
        $dbh = null;

        var_dump($rec);
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>