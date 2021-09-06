<!-- 
    身体情報の登録画面です。
 -->


<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません。<br>';
    print '<a href="p_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)の場合)
    if (!isset($_SESSION['c_login'])) {         // 管理者でログイン状態の場合(SESSION[''])
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
    <title>p_phisical_info_add.php</title>
</head>

<body>

    <h3>身体情報の登録</h3>
    <br>

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

    print '<form method="post" action="p_phisical_info_add_check.php">';

    print '日付<br>';
    print '<input type="date" name="date">';
    print '<br><br>';

    print '身長<br>';
    print '<input type="text" name="height">cm　';
    if ($rec != '') {             // 前回の情報がある場合
        print '<input type="checkbox" name="height" value="on">前回の情報を適用';
    }
    print '<br><br>';

    print '体重<br>';
    print '<input type="text" name="weight">kg　';
    if ($rec != '') {             // 前回の情報がある場合
        print '<input type="checkbox" name="weight" value="on">前回の情報を適用';
    }
    print '<br><br>';

    print '体脂肪率<br>';
    print '<input type="text" name="body_fat">%　';
    if ($rec != '') {             // 前回の情報がある場合
        print '<input type="checkbox" name="body_fat" value="on">前回の情報を適用';
    }
    print '<br><br>';

    print '筋量<br>';
    print '<input type="text" name="muscle_mass">kg　';
    if ($rec != '') {             // 前回の情報がある場合
        print '<input type="checkbox" name="muscle_mass" value="on">前回の情報を適用';
    }
    print '<br><br>';

    print '<br>';
    print '<input type="button" onclick="location.href=\'p_phisical_info_top_branch_return.php\'" value="戻る">';
    print '<input type="submit" value="登録">';
    print '</form>';

    ?>

</body>

</html>