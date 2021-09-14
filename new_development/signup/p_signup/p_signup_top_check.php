<!-- 
    p_signup_top.phpから所属(belong_code)、氏名(player_name)、パスワード(player_password)、パスワード確認(player_password2)を
    受け取り、入力漏れがないかの確認をする。
    入力漏れがない場合→p_signup_check.phpへリダイレクト
    入力漏れがある場合→エラーメッセージの表示(戻るボタンでp_signup_top.phpへ戻す)
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_signup_login'])) {
    print 'ログインされていません<br>';
    print '<a href="p_signup_login.php">ログイン画面へ</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_signup_top_check.php</title>
</head>

<body>

    <?php

    // 自作のsanitize関数を呼び出す
    require_once('../../function/function.php');
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);

    // p_signup_top.phpからbelong_code、player_name、player_password、player_password2を受け取る
    $belong_code = $post['belong_code'];
    $player_name = $post['player_name'];
    $player_password = $post['player_password'];
    $player_password2 = $post['player_password2'];

    // セッション変数に値を格納
    $_SESSION['belong_code'] = $belong_code;            
    $_SESSION['player_name'] = $player_name;
    $_SESSION['player_password'] = $player_password;

    // 入力内容の問題の有無をflgによって判定(問題なし:true、問題あり:false)
    $flg = true;

    // belong_codeが空の場合
    if ($belong_code == '') {
        print '所属先が選択されていません<br>';
        $flg = false;
    }

    // player_nameが空の場合
    if ($player_name == '') {
        print '氏名が入力されていません<br>';
        $flg = false;
    }

    // player_passwordが条件を満たしていない場合
    if(!preg_match("/^[a-z][a-z0-9_]{5,13}$/i", $player_password)) {
        print 'パスワードの条件を満たしていません<br>';
        $flg = false;
    }

    // player_passwordとplayer_password2が一致しない場合
    if ($player_password != $player_password2) {
        print 'パスワードが一致しません<br>';
        $flg = false;
    }

    if ($flg) {             // 入力に問題がなかった場合
        header('Location:p_signup_check.php');                // p_signup_check.phpへリダイレクト
        exit();
    } else {                // 入力に問題があった場合
        print '<br>';
        print '<input type="button" onclick="location.href=\'p_signup_top.php\'" value="戻る">';
    }


    ?>

</body>

</html>