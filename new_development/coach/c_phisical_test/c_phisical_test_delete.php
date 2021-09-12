<!-- 
    フィジカルテストの削除画面です。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_login'])) {     // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
    print 'ログインされていません。<br>';
    print '<a href="../c_top/c_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
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
    <title>c_phisical_test_delete.php</title>
</head>

<body>

    <h3>フィジカルテストの削除</h3>
    <br>

    
    本当に削除しますか<br>

    <br><br>

    <input type="button" onclick="location.href='c_phisical_test_content.php'" value="戻る">
    <input type="button" onclick="location.href='c_phisical_test_delete_check.php'" value="削除">



</body>

</html>