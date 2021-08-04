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

    <h3>フィジカルテストの内容</h3>

    <?php

    // p_phisical_test.phpから渡された値をサニタイズ
    $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

    try {
        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_recordテーブルからIDを使って情報を検索
        $sql = '
                SELECT *
                FROM phisical_test_record
                WHERE id = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $id;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        // 取得した内容を変数で保持
        $date = $rec['date'];
        $test_value[] = $rec['test1'];
        $test_value[] = $rec['test2'];
        $test_value[] = $rec['test3'];

        // phisical_testテーブルから会員コードと日付を使って情報を検索
        $sql1 = '
                SELECT id, date, test1, test2, test3 
                FROM phisical_test 
                WHERE player_code = ? 
                AND date = ?
                ';
        $stmt1 = $dbh->prepare($sql1);
        $data1[0] = $p_code;
        $data1[1] = $date;
        $stmt1->execute($data1);
        $rec1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $test_result[] = $rec1['test1'];
        $test_result[] = $rec1['test2'];
        $test_result[] = $rec1['test3'];

        // phisical_test_itemテーブルから項目名を検索
        $sql2 = '
                SELECT test_value 
                FROM phisical_test_item 
                ORDER BY test_code
                ';
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->execute();

        // player_managementデータベースから切断する
        $dbh = null;

        if ($rec1 == false) {        // データベースからの問い合わせ結果がない場合
            print '登録情報がありません。<br><br>';
            print '<form method="post" action="p_phisical_test_add.php">';
            print '<input type="hidden" name="id" value=' . $id . '>';
            print '<input type="button" onclick="location.href=\'p_phisical_test.php\'" value="戻る">';
            print '<input type="submit" name="edit" value="登録">';
        } else {                    // データベースからの問い合わせ結果があった場合
            print '日付<br>';
            print $date;
            print '<br><br>';
            print '項目<br>';
            // test_codeのmax値(1～3)までforループをまわす
            for ($i = 0; $i < 3; $i++) {
                $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($test_value[$i]) {
                    print $rec2['test_value'] .'　';
                    print $test_result[$i];
                    print '<br>';
                }
            }
            print '<br>';
            print '<form method="post" action="p_phisical_test_branch.php">';
            print '<input type="hidden" name="id" value=' . $id . '>';
            print '<input type="hidden" name="test_id" value=' . $rec1['id'] . '>';
            print '<input type="button" onclick="location.href=\'p_phisical_test.php\'" value="戻る">';
            print '<input type="submit" name="edit" value="編集">';
            print '<input type="submit" name="graph" value="グラフ">';
            print '<input type="submit" name="delete" value="削除">';
        }
    } catch (Exception $e) {
        exit();
    }
    ?>

</body>

</html>