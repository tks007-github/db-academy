<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="p_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['player_name'];
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
        $current_month = date('n');

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルからplayer_codeを使って過去1年間の月平均のデータを検索
        for ($i = 0; $i < 12; $i++) {
            $sql = '
                    SELECT phisical_info_code, date, height, weight, body_fat, muscle_mass
                    FROM phisical_info 
                    WHERE player_code = ?
                    ORDER BY date DESC
                    ';
            $stmt = $dbh->prepare($sql);
            $data[] = $player_code;
            $stmt->execute($data);
        }


        // db_academyデータベースから切断する
        $dbh = null;

        print '<form method="post" action="p_phisical_info_branch.php">';
        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec == '') {
                break;
            }
            print '<input type="radio" name="phisical_info_code" value="' . $rec['phisical_info_code'] . '">';
            print '日付：' . $rec['date'] . '　';
            print '身長：' . $rec['height'] . '　';
            print '体重：' . $rec['weight'] . '　';
            print '体脂肪率：' . $rec['body_fat'] . '　';
            print '筋量：' . $rec['muscle_mass'] . '　';
            print '<br>';
        }
        print '<br><br>';
        print '<input type="button" onclick="location.href=\'p_phisical_info_top.php\'" value="戻る">';
        print '<input type="submit" name="edit" value="編集">';
        print '<input type="submit" name="delete" value="削除">';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>