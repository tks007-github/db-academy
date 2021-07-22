<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['login'])) {
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

    <h3>問診表の登録情報内容</h3>
    
    <?php
    try {
        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // questionnaireテーブルから会員コードを使って怪我の情報を検索
        $sql1 = 'SELECT name, status_code, year, month FROM questionnaire WHERE player_code = ? AND item_code = 1';
        $stmt1 = $dbh -> prepare($sql1);
        $data1[0] = $p_code;
        $stmt1 -> execute($data1);
        $rec1_1 = $stmt1 -> fetch(PDO::FETCH_ASSOC);
        $rec1_2 = $stmt1 -> fetch(PDO::FETCH_ASSOC);
        

        // player_managementデータベースから切断する
        $dbh = null;

        if ($rec1_1 == false) {                  // データベースからの問い合わせ結果がない場合
            print '登録情報がありません。<br><br>';
            print '<input type="button" onclick="location.href=\'p_top.php\'" value="戻る">';
            print '<input type="button" onclick="location.href=\'p_questionnaire_add.php\'" value="登録">';
        } else {                              // データベースからの問い合わせ結果があった場合
            // print '怪我：' . $rec['injury'] . '<br>';
            // print 'アレルギー：' . $rec['allergies'] . '<br>';
            // print '病気：' . $rec['sick'] . '<br>';
            // print '<br><br>';
            // print '<form method="post" action="p_questionnaire_edit.php">';
			// print '<input type="hidden" name="injury" value="' . $rec['injury'] . '">';
            // print '<input type="hidden" name="allergies" value="' . $rec['allergies'] . '">';
            // print '<input type="hidden" name="sick" value="' . $rec['sick'] . '">';
            // print '<input type="button" onclick="location.href=\'p_top.php\'" value="戻る">';
            // print '<input type="submit" value="編集">';
            // print '</form>';
        }
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>
    
</body>

</html>