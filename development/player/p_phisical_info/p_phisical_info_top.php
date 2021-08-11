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
    <title>p_phisical_info_top</title>
</head>

<body>

    <h3>身体情報トップ</h3>

    <?php
    // p_phisical_infoディレクトリで使うSESSIONを初期化
    $_SESSION['phisical_info_flg'] = '';
    $_SESSION['date'] = '';                  
    $_SESSION['height'] = '';               
    $_SESSION['weight'] = '';                      
    $_SESSION['body_fat'] = '';                  
    $_SESSION['muscle_mass'] = '';           

    try {
        // player_codeをセッションで受け取る
        $player_code = $_SESSION['player_code'];

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルから会員コードを使って情報を検索
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

        // player_managementデータベースから切断する
        $dbh = null;

        print '<form method="post" action="p_phisical_info_add.php">';

        if ($rec == '') {                     // データベースからの問い合わせ結果がない場合
            print '登録情報がありません。<br><br>';
            print '<br><br>';
            print '<input type="hidden" name="phisical_info_flg" value=0>';
            print '<input type="button" onclick="location.href=\'../p_top/p_top.php\'" value="戻る">';
            print '<input type="submit" value="登録">';
        } else {                              // データベースからの問い合わせ結果があった場合
            print '最新の身体情報(' . $rec['date'] . ')<br><br>';
            print '身長：' . $rec['height'] . 'cm<br>';
            print '体重：' . $rec['weight'] . 'kg<br>';
            print '体脂肪率：' . $rec['body_fat'] . '%<br>';
            print '筋量：' . $rec['muscle_mass'] . 'kg<br>';
            print '<br><br>';
            print '<input type="hidden" name="phisical_info_flg" value=1>';
            print '<input type="button" onclick="location.href=\'../p_top/p_top.php\'" value="戻る">';
            print '<input type="submit" value="登録">';
            print '<input type="button" onclick="location.href=\'p_phisical_info_list.php\'" value="一覧">';
            print '<input type="button" onclick="location.href=\'p_phisical_info_graph.php\'" value="グラフ">';
        }
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>