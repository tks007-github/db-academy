<!-- 
    フィジカルテストのトップ画面です。
    フィジカルテストの情報を掲載します。

    フィジカルテストがある場合
    ラジオボタンで選択し、ＯＫボタンでc_phisical_test_top_check.phpに遷移します。

    フィジカルテストがない場合
    c_phisical_test_add.phpにリダイレクト。
 -->

<?php
session_start();
session_regenerate_id(true);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>c_phisical_test_top.php</title>
</head>

<body>

    <h3>フィジカルテスト一覧</h3>

    <?php

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_testテーブルから情報を検索
        $sql = '
                SELECT *
                FROM phisical_test 
                ORDER BY date DESC, belong_code
                ';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $rec = $stmt->fetchAll();

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    if (empty($rec)) {      // データベースからの問い合わせがない場合(フィジカルテストがない場合)
        header('Location:c_phisical_test_add.php?no_rec=1');
        exit();
    } else {                // データベースからの問い合わせがある場合(フィジカルテストがある場合)

        if (!isset($_SESSION['c_login'])) {     // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
            print 'ログインされていません。<br>';
            print '<a href="../c_top/c_top_login.php">ログイン画面へ</a>';
            exit();
        } else {                                // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
            print $_SESSION['coach_name'];
            print 'さんログイン中<br>';
            print '<br>';
        }

        $record_max = 3;                        // 1ページあたりの最大レコード数
        $record_num = count($rec);              // レコードの総数
        $page_max = ceil($record_num / $record_max);    // 総ページ数の計算

        if (!isset($_GET['page_id']))    // $_GET['page_id']が定義されてない場合
        {
            $page_now = 1;
        } else                           // $_GET['page_id']が定義されている場合
        {
            $page_now = $_GET['page_id'];
        }

        $record_start = ($page_now - 1) * $record_max;            // ページに表示する最初のレコード番号（1個目を0番目とする）

        print '<form method="post" action="c_phisical_test_top_check.php">';

        // ページに表示する分のデータだけ切り取る
        $disp_data = array_slice($rec, $record_start, $record_max, true);
        foreach ($disp_data as $key => $value) {
            print '<input type="radio" name="phisical_test_code" value="' . $value['phisical_test_code'] . '">';
            print '日付：' . $value['date'] . '　';
            print '所属：' . $value['belong_code'] . '　';
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
            print '<a href=c_phisical_test_top.php?page_id=' . ($page_now - 1) . '>前へ</a>' . '　';
        } else                                    // 現在のページ番号が1の場合（1未満になることはないため）
        {
            print '前へ' . '　';
        }

        // if文によってリンクを貼るかどうかを決定
        if ($page_now < $page_max)                    // 現在のページ番号が最後のページ番号未満の場合
        {
            print '<a href=c_phisical_test_top.php?page_id=' . ($page_now + 1) . '>次へ</a>' . '　';
        } else                                        // 現在のページ番号と最後のページ番号が等しい場合（現在のページ番号は最後のページ番より大きくならないため）
        {
            print '次へ';
        }

        print '<br><br>';
        print '<input type="button" onclick="location.href=\'../c_top/c_top.php\'" value="戻る">';
        print '<input type="button" onclick="location.href=\'c_phisical_test_add.php\'" value="登録">';
        print '<input type="submit" name="content" value="内容">';
    }

    ?>

</body>

</html>