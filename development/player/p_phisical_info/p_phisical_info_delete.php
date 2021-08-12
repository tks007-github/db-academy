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
    <title>p_phisical_info_delete</title>
</head>

<body>

    <h3>身体情報の削除</h3>
    <br>

    <?php

    try {
        // 自作の関数を呼び出す
        require_once('../../function/function.php');

        if ($_SESSION['phisical_info_code'] == '') {
            // getの中身をすべてサニタイズする
            $get = sanitize($_GET);

            // p_phisical_info_branchからphisical_info_codeをGETで受け取る
            $phisical_info_code = $get['phisical_info_code'];
            $_SESSION['phisical_info_code'] = $phisical_info_code;
        } else {
            $phisical_info_code = $_SESSION['phisical_info_code'];
        }

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルからphisical_info_codeを使って情報を検索
        $sql = '
                SELECT date, height, weight, body_fat, muscle_mass 
                FROM phisical_info 
                WHERE phisical_info_code = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $phisical_info_code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // 編集するデータをそれぞれ変数で保持
        $date = $rec['date'];
        $height = $rec['height'];
        $weight = $rec['weight'];
        $body_fat = $rec['body_fat'];
        $muscle_mass = $rec['muscle_mass'];

        // db_academyデータベースから切断する
        $dbh = null;

        print '本当に削除しますか<br><br>';

        print '日付<br>';
        print $date;
        print '<br><br>';

        print '身長<br>';
        print $height . 'cm';
        print '<br><br>';

        print '体重<br>';
        print $weight . 'kg';
        print '<br><br>';

        print '体脂肪率<br>';
        print $body_fat . '%';
        print '<br><br>';

        print '筋量<br>';
        print $muscle_mass . 'kg';
        print '<br><br>';

        print '<br>';
        print '<input type="button" onclick="location.href=\'p_phisical_info_list.php\'" value="戻る">';
        print '<input type="button" onclick="location.href=\'p_phisical_info_delete_done.php\'" value="削除">';
        
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

</body>

</html>