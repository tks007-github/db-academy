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
    // p_questionnaire.phpから怪我、アレルギー、病気の情報を受け取る
    $injury = htmlspecialchars($_POST['injury'], ENT_QUOTES, 'UTF-8');
    $allergies = htmlspecialchars($_POST['allergies'], ENT_QUOTES, 'UTF-8');
    $sick = htmlspecialchars($_POST['sick'], ENT_QUOTES, 'UTF-8');
    ?>

    <h3>問診表の編集</h3>
    <br>
    <form method="post" action="p_questionnaire_edit_done.php">
        怪我<br>
        <textarea name="injury" rows="6" cols="50"><?php print $injury; ?></textarea><br>
        アレルギー<br>
        <textarea name="allergies" rows="6" cols="50"><?php print $allergies; ?></textarea><br>
        病気<br>
        <textarea name="sick" rows="6" cols="50"><?php print $sick; ?></textarea><br>
        <br>
        <br>
        <input type="button" onclick="location.href='p_questionnaire.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>
</body>

</html>