<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_signup_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="c_signup_login.html">ログイン画面へ</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>c_signup_top_check</title>
</head>

<body>

    <?php

    // 自作のsanitize関数を呼び出す
    require_once('../../function/function.php');
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);

    // c_signup_top.htmlからmst_passwordを受け取る
    $coach_name = $post['coach_name'];
    $coach_password = $post['coach_password'];
    $coach_password2 = $post['coach_password2'];

    // セッション変数に値を格納      
    $_SESSION['coach_name'] = $coach_name;
    $_SESSION['coach_password'] = $coach_password;

    // 入力内容の問題の有無をflgによって判定(問題なし:true、問題あり:false)
    $flg = true;


    // coach_nameが空の場合
    if ($coach_name == '') {
        print '氏名が入力されていません<br>';
        $flg = false;
    }

    // coach_passwordが空の場合
    if ($coach_password == '') {
        print 'パスワードが入力されていません<br>';
        $flg = false;
    }

    // coach_passwordとcoach_password2が一致しない場合
    if ($coach_password != $coach_password2) {
        print 'パスワードが一致しません<br>';
        $flg = false;
    }

    if ($flg) {             // 入力に問題がなかった場合
        header('Location:c_signup_check.php');                // c_signup_check.phpへリダイレクト
        exit();
    } else {                // 入力に問題があった場合
        print '<br>';
        print '<input type="button" onclick="location.href=\'c_signup_top.php\'" value="戻る">';
    }


    ?>

</body>

</html>