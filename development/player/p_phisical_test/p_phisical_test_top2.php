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
    <title>p_phisical_test_top</title>
</head>

<body>

    <h3>フィジカルテストトップ</h3>

    <?php
    // p_phisical_testディレクトリで使うSESSIONを初期化
    // $_SESSION['phisical_info_flg'] = '';
    // $_SESSION['date'] = '';                  
    // $_SESSION['height'] = '';               
    // $_SESSION['weight'] = '';                      
    // $_SESSION['body_fat'] = '';                  
    // $_SESSION['muscle_mass'] = '';           

    try {
        // player_codeをセッションで受け取る
        $player_code = $_SESSION['player_code'];

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_recordテーブルからplayer_codeを使って最新の情報を検索
        $sql1 = '
                SELECT date, 10m走, 20m走, 30m走, 50m走, 1500m走, 
                プロアジリティ, 立ち幅跳び, メディシンボール投げ, 
                垂直飛び, 背筋力, 握力, サイドステップ 
                FROM phisical_test_record 
                WHERE player_code = ?
                AND date = (
                SELECT MAX(date)
                FROM phisical_test_record
                WHERE player_code = ?
                )
                ';
        $stmt1 = $dbh->prepare($sql1);
        $data1[] = $player_code;
        $data1[] = $player_code;
        $stmt1->execute($data1);
        $rec1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        // belong_codeとdateを変数で保持
        $belong_code = $player_code[0];
        $date = $rec1['date'];

        // phisical_testテーブルからbelong_codeとdateを使って情報を検索
        $sql2 = '
                SELECT 10m走, 20m走, 30m走, 50m走, 1500m走, 
                プロアジリティ, 立ち幅跳び, メディシンボール投げ, 
                垂直飛び, 背筋力, 握力, サイドステップ 
                FROM phisical_test
                WHERE belong_code = ?
                AND date = ?
                ';
        $stmt2 = $dbh->prepare($sql2);
        $data2[] = $belong_code;
        $data2[] = $date;
        $stmt2->execute($data2);
        $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        // db_academyデータベースから切断する
        $dbh = null;

        print '<form method="post" action="p_phisical_test_add.php">';

        if ($rec1 == '') {                     // データベースからの問い合わせ結果がない場合
            print '登録情報がありません。<br><br>';
            print '<br><br>';
            print '<input type="hidden" name="phisical_test_flg" value=0>';
            print '<input type="button" onclick="location.href=\'../p_top/p_top.php\'" value="戻る">';
            print '<input type="submit" value="登録">';
        } else {                              // データベースからの問い合わせ結果があった場合
            print '最新のフィジカルテスト結果(' . $rec1['date'] . ')<br><br>';
            if ($rec2['10m走']) {
                print '10m走：' . $rec1['10m走'] . '秒<br>';
            }
            if ($rec2['20m走']) {
                print '20m走：' . $rec1['20m走'] . '秒<br>';
            }
            if ($rec2['30m走']) {
                print '30m走：' . $rec1['30m走'] . '秒<br>';
            }
            if ($rec2['50m走']) {
                print '50m走：' . $rec1['50m走'] . '秒<br>';
            }
            if ($rec2['1500m走']) {
                print '1500m走：' . $rec1['1500m走'] . '分<br>';
            }
            if ($rec2['プロアジリティ']) {
                print 'プロアジリティ：' . $rec1['プロアジリティ'] . '秒<br>';
            }
            if ($rec2['立ち幅跳び']) {
                print '立ち幅跳び：' . $rec1['立ち幅跳び'] . 'cm<br>';
            }
            if ($rec2['メディシンボール投げ']) {
                print 'メディシンボール投げ：' . $rec1['メディシンボール投げ'] . 'm<br>';
            }
            if ($rec2['垂直飛び']) {
                print '垂直飛び：' . $rec1['垂直飛び'] . 'cm<br>';
            }
            if ($rec2['背筋力']) {
                print '背筋力：' . $rec1['背筋力'] . 'kg<br>';
            }
            if ($rec2['握力']) {
                print '握力：' . $rec1['握力'] . 'kg<br>';
            }
            if ($rec2['サイドステップ']) {
                print 'サイドステップ：' . $rec1['サイドステップ'] . '回<br>';
            }
            print '<br><br>';
            print '<input type="hidden" name="phisical_test_flg" value=1>';
            print '<input type="button" onclick="location.href=\'../p_top/p_top.php\'" value="戻る">';
            print '<input type="submit" value="登録">';
            print '<input type="button" onclick="location.href=\'p_phisical_test_list.php\'" value="一覧">';
        }
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>