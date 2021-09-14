<!-- 
    マスターパスワード変更画面です。
    現在のパスワード(mst_password)と新しいパスワード(new_mst_password)、新しいパスワード確認(new_mst_password2)の
    入力を求める。
    ＯＫボタンでc_top_master_password_change_check.phpへ遷移。
 -->

 <?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['c_login'])) {     // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
        print 'ログインされていません。<br>';
        print '<a href="c_top_login.php">ログイン画面へ</a>';
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
    <title>c_top_master_password_change.php</title>
</head>
<body>

    <h3>マスターパスワードの変更</h3>
    <br>
    
    <form method="post" action="c_top_master_password_change_check.php">
        現在のマスターパスワードを入力してください<br>
        <input type="password" name="mst_password"><br>
        <br>
        新しいマスターパスワードを入力してください(半角英数字6文字以上14文字以内)<br>
        <input type="password" name="new_mst_password"><br>
        <br>
        新しいパスワードをもう一度入力してください<br>
        <input type="password" name="new_mst_password2"><br>
        <br>
        <input type="button" onclick="location.href='c_top.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>
    
</body>
</html>