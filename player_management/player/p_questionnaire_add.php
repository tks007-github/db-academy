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

    <h3>問診表の編集</h3>
    <br>
    <form method="post" action="p_questionnaire_add_done.php">
        怪我<br>
        <textarea name="injury" rows="6" cols="50"></textarea><br>
        アレルギー<br>
        <textarea name="allergies" rows="6" cols="50"></textarea><br>
        病気<br>
        <textarea name="sick" rows="6" cols="50"></textarea><br>
        <br>
        <br>
        <input type="button" onclick="location.href='p_questionnaire.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>

</body>

</html>