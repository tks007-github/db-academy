<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['c_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="../c_top/c_top_login.html">ログイン画面へ</a>';
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
    <title>c_phisical_test_top</title>
</head>
<body>

    <h3>フィジカルテストトップ</h3>
    <br>
    
    <a href="c_phisical_test_add.php">新規作成</a><br>
    <a href="c_phisical_test_list.php">一覧</a><br>
    
    <br><br>
    <input type="button" onclick="location.href='../c_top/c_top.php'" value="戻る">

</body>
</html>