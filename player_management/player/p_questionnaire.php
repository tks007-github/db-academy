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

    <?php
    try {
        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // questionnaireテーブルから会員コードを使って情報を検索
        $sql = 'SELECT injury, allergies, sick FROM questionnaire WHERE player_code = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $p_code;
        $stmt -> execute($data);
        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

        // player_managementデータベースから切断する
        $dbh = null;

        if ($rec == false) {                  // データベースからの問い合わせ結果がない場合
            print '登録情報がありません。';
        } else {                              // データベースからの問い合わせ結果があった場合
            print '<h3>怪我：' . $rec['injury'] . '</h3>';
            print '<h3>アレルギー：' . $rec['allergies'] . '</h3>';
            print '<h3>病気：' . $rec['sick'] . '</h3>';
        }
    } catch (Exception $e) {
        exit();
    }
    ?>

    <a href="p_top.php">戻る</a>
    <a href="p_questionnaire_edit.php">編集</a>
    
</body>

</html>