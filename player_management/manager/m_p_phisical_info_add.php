<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['m_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="m_login.html">ログイン画面へ</a>';
        exit();
    } else {
        $p_code = $_SESSION['p_code'];
        print $_SESSION['m_code'];
        print 'さんログイン中<br>';
        print '（検索条件：' . $_SESSION['p_code'] . '）';
        print '<br>';
    }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
</head>

<body>

    <h3>身体情報の登録</h3>
    <br>
    <form method="post" action="m_p_phisical_info_add_done.php">
        日付<br>
        <input type="date" name="date"><br>
        身長<br>
        <input type="text" name="height" value="">cm<br>
        体重<br>
        <input type="text" name="weight" value="">kg<br>
        <br><br>

        <br>
        <input type="button" onclick="location.href='m_p_phisical_info.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>


</body>

</html>