<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['m_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="m_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['m_code'];
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
    <title>Manager</title>
</head>

<body>

    <h3>フィジカルテスト削除</h3>

    <?php

    // m_phisical_test_content.phpから渡された値をサニタイズ
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');

    ?>

    選手が入力したデータも消えてしまいます。<br>
    本当に削除しますか？<br><br>
    <form method="post" action="m_phisical_test_delete_done.php">
        <input type="hidden" name="id" value="<?php print $id; ?>">
        <input type="hidden" name="date" value="<?php print $date; ?>">
        <input type="button" onclick="location.href='m_phisical_test_list.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>

</body>

</html>