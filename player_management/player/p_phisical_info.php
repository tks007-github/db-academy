<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="s_login.html">ログイン画面へ</a>';
    exit();
} else {
    $p_code = $_SESSION['p_code'];
    print $p_code;
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
    <title>Player</title>
</head>

<body>

    <h3>身体情報トップ</h3>

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
                SELECT date, height, weight 
                FROM phisical_info 
                WHERE player_code = ?
                AND date = (
                SELECT MAX(date)
                FROM phisical_info
                WHERE player_code = ?
                )
                ';
        $stmt = $dbh->prepare($sql);
        $data[0] = $p_code;
        $data[1] = $p_code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // player_managementデータベースから切断する
        $dbh = null;

        if ($rec == false) {                  // データベースからの問い合わせ結果がない場合
            print '登録情報がありません。<br><br>';
            print '<br><br>';
            print '<input type="button" onclick="location.href=\'p_top.php\'" value="戻る">';
            print '<input type="button" onclick="location.href=\'p_phisical_add.php\'" value="登録">';
        } else {                              // データベースからの問い合わせ結果があった場合
            print '最新の身体情報(' .$rec['date']. ')<br><br>';
            print '身長：' . $rec['height'] . 'cm<br>';
            print '体重：' . $rec['weight'] . 'kg<br>';
            print '<br><br>';
            print '<input type="button" onclick="location.href=\'p_top.php\'" value="戻る">';
            print '<input type="button" onclick="location.href=\'p_phisical_info_add.php\'" value="登録">';
            print '<input type="button" onclick="location.href=\'p_phisical_info_list.php\'" value="一覧">';
            print '<input type="button" onclick="location.href=\'p_phisical_info_graph.php\'" value="グラフ">';
        }
    } catch (Exception $e) {
        exit();
    }
    ?>

</body>

</html>