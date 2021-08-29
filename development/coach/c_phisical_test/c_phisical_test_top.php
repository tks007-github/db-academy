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
    <title>c_phisical_test_list</title>
</head>

<body>

    <h3>フィジカルテスト一覧</h3>

    <?php
    // $_SESSIONを初期化
    $_SESSION['phisical_test_code'] = '';
    $_SESSION['belong_code'] = '';
    $_SESSION['date'] = '';
    $_SESSION['10m走_boolean'] = '';
    $_SESSION['20m走_boolean'] = '';
    $_SESSION['30m走_boolean'] = '';
    $_SESSION['50m走_boolean'] = '';
    $_SESSION['1500m走_boolean'] = '';
    $_SESSION['プロアジリティ_boolean'] = '';
    $_SESSION['立ち幅跳び_boolean'] = '';
    $_SESSION['メディシンボール投げ_boolean'] = '';
    $_SESSION['垂直飛び_boolean'] = '';
    $_SESSION['背筋力_boolean'] = '';
    $_SESSION['握力_boolean'] = '';
    $_SESSION['サイドステップ_boolean'] = '';

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

        if (empty($rec)) {
            header('Location:c_phisical_test_add.php');          
            exit();
        } else {

            if (!isset($_SESSION['c_login'])) {
                print 'ログインされていません。<br>';
                print '<a href="../c_top/c_top_login.html">ログイン画面へ</a>';
                exit();
            } else {
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

            print '<form method="post" action="c_phisical_test_list_check.php">';

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
                print '<a href=p_phisical_test_top.php?page_id=' . ($page_now - 1) . '>前へ</a>' . '　';
            } else                                    // 現在のページ番号が1の場合（1未満になることはないため）
            {
                print '前へ' . '　';
            }

            // // ループを回してすべてのページ番号を表示する
            // for ($i = 1; $i <= $page_max; $i++) {
            //     // if文によってリンクを貼るかどうかを決定
            //     if ($i == $page_now)                // $iと現在のページ番号が等しい場合			
            //     {
            //         print $page_now . '　';
            //     } else                              // $iと現在のページ番号が等しくない場合
            //     {
            //         print '<a href=p_phisical_info_list.php?page_id=' . $i . '>' . $i . '</a>' . '　';
            //     }
            // }

            // if文によってリンクを貼るかどうかを決定
            if ($page_now < $page_max)                    // 現在のページ番号が最後のページ番号未満の場合
            {
                print '<a href=p_phisical_test_top.php?page_id=' . ($page_now + 1) . '>次へ</a>' . '　';
            } else                                        // 現在のページ番号と最後のページ番号が等しい場合（現在のページ番号は最後のページ番より大きくならないため）
            {
                print '次へ';
            }

            print '<br><br>';
            print '<input type="button" onclick="location.href=\'../c_top/c_top.php\'" value="戻る">';
            print '<input type="button" onclick="location.href=\'c_phisical_test_add.php\'" value="追加">';
            print '<input type="submit" name="delete" value="削除">';
            print '<input type="submit" name="player_list" value="未入力選手">';
        }
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>