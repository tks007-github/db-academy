<!-- 
    c_top_password_change.phpから現在のパスワード(coach_password)と
    新しいパスワード(new_coach_password)、新しいパスワード確認(new_coach_password2)を
    受け取り、現在のパスワードが正しいか検証をします。

    問題なし→c_top_password_change_done.phpへリダイレクト
    問題あり→c_top_password_change.phpへリダイレクト
 -->

<?php
session_start();
session_regenerate_id(true);

// SESSION変数からcoach_codeを受け取る
$coach_code = $_SESSION['coach_code'];


// 自作の関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);

// c_top_pass_change.phpからcoach_passwordとnew_coach_passwordとnew_coach_password2を受け取る
$coach_password = $post['coach_password'];
// coach_passwordをmd5で暗号化
$coach_password = md5($coach_password);
$new_coach_password = $post['new_coach_password'];
$new_coach_password2 = $post['new_coach_password2'];

// DB接続
try {
    // db_academyデータベースに接続する
    $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // coachテーブルからcoach_codeとcoach_passwordを使って情報を検索
    $sql = '
            SELECT * 
            FROM coach 
            WHERE coach_code = ? AND coach_password = ?
            ';
    $stmt = $dbh->prepare($sql);
    $data[] = $coach_code;
    $data[] = $coach_password;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // db_academyデータベースから切断する
    $dbh = null;
} catch (Exception $e) {
    var_dump($e);
    exit();
}

// 入力内容の問題の有無をflgによって判定(問題なし:true、問題あり:false)
$flg = true;

// coach_passwordが空の場合
if ($coach_password == '') {
    print '現在のパスワードが入力されていません<br>';
    $flg = false;
}

// coach_passwordが間違っていた場合
if ($coach_password != '' && $rec == '') {
    print '現在のパスワードが間違っています<br>';
    $flg = false;
}

// new_coach_passwordが空の場合
if ($new_coach_password == '') {
    print '新しいパスワードが入力されていません<br>';
    $flg = false;
}

// new_coach_passwordとnew_coach_password2が一致しない場合
if ($new_coach_password != $new_coach_password2) {
    print '新しいパスワードが一致しません<br>';
    $flg = false;
}

if ($flg) {             // 入力に問題がなかった場合
    $_SESSION['new_coach_password'] = $new_coach_password;      // SESSION変数にnew_coach_passwordを保持
    header('Location:c_top_password_change_done.php');          // c_top_password_change_done.phpへリダイレクト
    exit();
} else {                // 入力に問題があった場合
    print '<br>';
    print '<input type="button" onclick="location.href=\'c_top_password_change.php\'" value="戻る">';
}
