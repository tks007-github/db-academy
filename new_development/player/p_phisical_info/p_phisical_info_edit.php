<!-- 
    身体情報の編集画面です。
 -->


<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません<br>';
    print '<a href="p_top_login.php">ログイン画面へ</a>';
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
    <title>p_phisical_info_edit.php</title>
</head>

<body>

    <h3>身体情報の編集</h3>
    <br>

    <?php

    // 自作の関数を呼び出す
    require_once('../../function/function.php');

    // 身体情報コード(phisical_info_code)を受け取る
    if (!empty($_GET)) {                            // p_phisical_info_list_branch.phpからの遷移
        // getの中身をすべてサニタイズする
        $get = sanitize($_GET);
        // p_phisical_info_branchからphisical_info_codeをGETで受け取る
        $phisical_info_code = $get['phisical_info_code'];
        $_SESSION['phisical_info_code'] = $phisical_info_code;
    } else {                                        // p_phisical_info_edit_check.phpからの遷移
        $phisical_info_code = $_SESSION['phisical_info_code'];
    }

    // DB接続
    try {
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
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print '<form method="post" action="p_phisical_info_edit_check.php">';

    // 同じ日付でのデータベースへの登録を避けるために日付は変更不可
    print '日付<br>';
    print $date;
    print '<br><br>';

    print '身長<br>';
    print '<input type="text" name="height" value="' . $height . '">cm　';
    print '<br><br>';

    print '体重<br>';
    print '<input type="text" name="weight" value="' . $weight . '">kg　';
    print '<br><br>';

    print '体脂肪率<br>';
    print '<input type="text" name="body_fat" value="' . $body_fat . '">%　';
    print '<br><br>';

    print '筋量<br>';
    print '<input type="text" name="muscle_mass" value="' . $muscle_mass . '">kg　';
    print '<br><br>';

    print '<br>';
    print '<input type="button" onclick="location.href=\'p_phisical_info_list.php\'" value="戻る">';
    print '<input type="submit" value="編集">';
    print '</form>';


    ?>

</body>

</html>