<!-- 
    身体情報のトップ画面です。
    最新の身体情報を掲載します。
    以下のページへのリンクを用意します。

    登録→p_phisical_info_add.php
    一覧→p_phisical_info_list.php
    グラフ→p_phisical_info_graph.php
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません<br>';
    print '<a href="../p_top/p_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)場合)
    if (!isset($_SESSION['c_login'])) {         // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
        print $_SESSION['player_name'];
        print 'さんログイン中<br>';
        print '<br>';
    } else {                                    // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
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
    <title>p_phisical_info_top.php</title>
</head>

<body>

    <h3>身体情報トップ</h3>

    <?php


    // SESSION変数からplayer_codeを受け取る
    $player_code = $_SESSION['player_code'];

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルから選手コード(player_code)を使って最新の情報を検索
        $sql = '
                SELECT date, height, weight, body_fat, muscle_mass 
                FROM phisical_info 
                WHERE player_code = ?
                AND date = (
                SELECT MAX(date)
                FROM phisical_info
                WHERE player_code = ?
                )
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $player_code;
        $data[] = $player_code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print '最新の身体情報(' . $rec['date'] . ')<br><br>';
    print '身長：' . $rec['height'] . 'cm<br>';
    print '体重：' . $rec['weight'] . 'kg<br>';
    print '体脂肪率：' . $rec['body_fat'] . '%<br>';
    print '筋量：' . $rec['muscle_mass'] . 'kg<br>';
    
    print '<br><br>';
    
    print '<input type="button" onclick="location.href=\'../p_top/p_top.php\'" value="戻る">';
    print '<input type="button" onclick="location.href=\'p_phisical_info_add.php\'" value="登録">';
    print '<input type="button" onclick="location.href=\'p_phisical_info_list.php\'" value="一覧">';
    print '<input type="button" onclick="location.href=\'p_phisical_info_graph.php?graph=height\'" value="グラフ">';


    ?>

</body>

</html>