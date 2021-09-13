<!-- 
    c_phisical_test_contentの入力済み選手一覧を表示する。
    ラジオボタンで選択し、編集・成績表ボタンを押すことで遷移する。

    編集→c_phisical_test_done_player_edit.php
    成績表→c_phisical_test_done_player_result.php
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_login'])) {     // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
    print 'ログインされていません。<br>';
    print '<a href="../c_top/c_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
    print $_SESSION['coach_name'];
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
    <title>c_phisical_test_done_player_list.php</title>
</head>

<body>

    <h3>フィジカルテスト入力済選手一覧</h3>

    <?php

    // c_phisical_test_list_check.phpからphisical_test_codeをSESSIONで受け取る
    $phisical_test_code = $_SESSION['phisical_test_code'];

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_testテーブルからphisical_test_codeを使って情報を検索
        $sql = '
                SELECT * 
                FROM phisical_test 
                WHERE phisical_test_code = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $phisical_test_code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // データをそれぞれ変数で保持
        $date = $rec['date'];
        $belong_code = $rec['belong_code'];
        $test1_boolean = $rec['10m走'];
        $test2_boolean = $rec['20m走'];
        $test3_boolean = $rec['30m走'];
        $test4_boolean = $rec['50m走'];
        $test5_boolean = $rec['1500m走'];
        $test6_boolean = $rec['プロアジリティ'];
        $test7_boolean = $rec['立ち幅跳び'];
        $test8_boolean = $rec['メディシンボール投げ'];
        $test9_boolean = $rec['垂直飛び'];
        $test10_boolean = $rec['背筋力'];
        $test11_boolean = $rec['握力'];
        $test12_boolean = $rec['サイドステップ'];

        // SESSION変数に情報を保持
        $_SESSION['date'] = $date;
        $_SESSION['belong_code'] = $belong_code;
        $_SESSION['10m走_boolean'] = $test1_boolean;
        $_SESSION['20m走_boolean'] = $test2_boolean;
        $_SESSION['30m走_boolean'] = $test3_boolean;
        $_SESSION['50m走_boolean'] = $test4_boolean;
        $_SESSION['1500m走_boolean'] = $test5_boolean;
        $_SESSION['プロアジリティ_boolean'] = $test6_boolean;
        $_SESSION['立ち幅跳び_boolean'] = $test7_boolean;
        $_SESSION['メディシンボール投げ_boolean'] = $test8_boolean;
        $_SESSION['垂直飛び_boolean'] = $test9_boolean;
        $_SESSION['背筋力_boolean'] = $test10_boolean;
        $_SESSION['握力_boolean'] = $test11_boolean;
        $_SESSION['サイドステップ_boolean'] = $test12_boolean;

        // playerテーブルからbelong_codeを使ってplayer_codeとplayer_nameを検索
        $sql2 = '
                SELECT player_code, player_name 
                FROM player 
                WHERE player_code IN (
                    SELECT player_code
                    FROM phisical_test_record
                    WHERE date = ? AND belong_code = ?
                )
                AND belong_code = ?
                ';
        $stmt2 = $dbh->prepare($sql2);
        $data2[] = $date;
        $data2[] = $belong_code;
        $data2[] = $belong_code;
        $stmt2->execute($data2);
        $rec2 = $stmt2->fetchAll();

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    if (empty($rec2)) {
        print '入力済の選手はいません';
        print '<br><br>';
        print '<input type="button" onclick="location.href=\'c_phisical_test_content.php\'" value="戻る">';
    } else {

        $record_max = 3;                        // 1ページあたりの最大レコード数
        $record_num = count($rec2);              // レコードの総数
        $page_max = ceil($record_num / $record_max);    // 総ページ数の計算

        if (!isset($_GET['page_id']))    // $_GET['page_id']が定義されてない場合
        {
            $page_now = 1;
        } else                           // $_GET['page_id']が定義されている場合
        {
            $page_now = $_GET['page_id'];
        }

        $record_start = ($page_now - 1) * $record_max;            // ページに表示する最初のレコード番号（1個目を0番目とする）

        print '<form method="post" action="c_phisical_test_done_player_check.php">';

        // ページに表示する分のデータだけ切り取る
        $disp_data = array_slice($rec2, $record_start, $record_max, true);
        foreach ($disp_data as $key => $value) {
            print '<input type="radio" name="player_code" value="' . $value['player_code'] . '">';
            print '会員コード：' . $value['player_code'] . '　';
            print '氏名：' . $value['player_name'] . '　';
            print '<br>';
        }

        print '全件数' . $record_num . '件（' . ($record_start + 1) . '件～';

        if ($record_num >= $record_start + $record_max)        // 最後のレコードが現在のページに収まらない場合
        {
            print $record_start + $record_max;
        } else                                                 // 最後のレコードが現在のページに収まる場合
        {
            print $record_num;
        }

        print '件表示中）　';

        // if文によってリンクを貼るかどうかを決定
        if ($page_now > 1)                        // 現在のページ番号が1より大きい場合
        {
            print '<a href=c_phisical_test_done_player_list.php?page_id=' . ($page_now - 1) . '>前へ</a>' . '　';
        } else                                    // 現在のページ番号が1の場合（1未満になることはないため）
        {
            print '前へ' . '　';
        }

        // if文によってリンクを貼るかどうかを決定
        if ($page_now < $page_max)                    // 現在のページ番号が最後のページ番号未満の場合
        {
            print '<a href=c_phisical_test_done_player_list.php?page_id=' . ($page_now + 1) . '>次へ</a>' . '　';
        } else                                        // 現在のページ番号と最後のページ番号が等しい場合（現在のページ番号は最後のページ番より大きくならないため）
        {
            print '次へ';
        }

        print '<br><br>';
        print '<input type="button" onclick="location.href=\'c_phisical_test_content.php\'" value="戻る">';
        print '<input type="submit" name="edit" value="編集">';
        print '<input type="submit" name="result" value="成績表">';
    }


    ?>

</body>

</html>