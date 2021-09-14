<!-- 
    c_signup_top.phpから氏名(coach_name)、パスワード(coach_password)、パスワード確認(player_password2)を
    受け取り、入力漏れがないかの確認をする。
    入力漏れがない場合→c_signup_check.phpへリダイレクト
    入力漏れがある場合→エラーメッセージの表示(戻るボタンでc_signup_top.phpへ戻す)
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_signup_login'])) {
    print 'ログインされていません<br>';
    print '<a href="c_signup_login.php">ログイン画面へ</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>c_signup_top_check.php</title>
</head>

<body>

    <?php

    // 自作のsanitize関数を呼び出す
    require_once('../../function/function.php');
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);

    // c_signup_top.phpからmst_passwordを受け取る
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

    // coach_passwordが条件を満たしていない場合
    if(!preg_match("/^[a-z][a-z0-9_]{5,13}$/i", $coach_password)) {
        print 'パスワードの条件を満たしていません<br>';
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