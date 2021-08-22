<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['c_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="c_top_login.html">ログイン画面へ</a>';
        exit();
    } else {
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
    <title>c_search_top</title>
</head>
<body>

    <h3>選手検索</h3>
    <br>
    選手の氏名を入力してください<br>
    <br>
    <form method="post" action="c_search_top_check.php">
        氏名<br>
        <input type="text" name="player_name"><br>
        <br>
        <input type="button" onclick="location.href='../c_top/c_top.php'" value="戻る">
        <input type="submit" value="検索">
    </form>

</body>
</html>