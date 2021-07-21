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

    編集<br>
    <br>
    <br>
    <form method="post" action="p_questionnaire_edit_check.php">
    怪我<br>
    <input type="text" name="injury" style="width:200px"><br>
    アレルギー<br> 
    <input type="text" name="allergies" style="width:200px"><br>
    病気<br>
    <input type="text" name="sick" style="width:200px"><br>
    <input type="submit" value="ＯＫ">
    <br>
    <a href="p_questionnaire.php">戻る</a>

</body>

</html>