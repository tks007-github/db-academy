<!-- 
    選手検索画面です。
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
    <title>c_search_top.php</title>
</head>
<body>

    <h3>選手検索</h3>
    <br>
    選手の氏名、所属を入力してください<br>
    <br>
    <form method="post" action="c_search_list.php">
        氏名<br>
        <input type="text" name="search_name"><br>
        <br>
        所属<br>
        <select name="search_belong_code">
            <option value=""></option>
            <option value="A">新川高校</option>
            <option value="B">D.B.アカデミー</option>
        </select>
        <br>

        <br><br>

        <input type="button" onclick="location.href='../c_top/c_top.php'" value="戻る">
        <input type="submit" value="検索">
    </form>

</body>
</html>