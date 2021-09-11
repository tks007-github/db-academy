<!-- 
    c_top_msater_password_change.phpから現在のパスワード(mst_password)と
    新しいパスワード(new_mst_password)、新しいパスワード確認(new_mst_password2)を
    受け取り、現在のパスワードが正しいか検証をします。

    問題なし→c_top_master_password_change_done.phpへリダイレクト
    問題あり→c_top_master_password_change.phpへリダイレクト
 -->

<?php
session_start();
session_regenerate_id(true);


// 自作の関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);

// c_top_master_password_change.phpからmst_passwordとnew_mst_passwordとnew_mst_password2を受け取る
$mst_password = $post['mst_password'];
// mst_passwordをmd5で暗号化
$mst_password = md5($mst_password);
$new_mst_password = $post['new_mst_password'];
$new_mst_password2 = $post['new_mst_password2'];

$mst_code = 1;

// DB接続
try {
    // db_academyデータベースに接続する
    $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // mst_passwordテーブルからmst_codeとmst_passwordを使って情報を検索
    $sql = '
            SELECT * 
            FROM mst_password 
            WHERE mst_code = ? AND mst_password = ?
            ';
    $stmt = $dbh->prepare($sql);
    $data[] = $mst_code;
    $data[] = $mst_password;
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

// mst_passwordが空の場合
if ($mst_password == '') {
    print '現在のマスターパスワードが入力されていません<br>';
    $flg = false;
}

// mst_passwordが間違っていた場合
if ($mst_password != '' && $rec == '') {
    print '現在のマスターパスワードが間違っています<br>';
    $flg = false;
}

// new_mst_passwordが空の場合
if ($new_mst_password == '') {
    print '新しいマスターパスワードが入力されていません<br>';
    $flg = false;
}

// new_mst_passwordとnew_mst_password2が一致しない場合
if ($new_mst_password != $new_mst_password2) {
    print '新しいパスワードが一致しません<br>';
    $flg = false;
}

if ($flg) {             // 入力に問題がなかった場合
    $_SESSION['new_mst_password'] = $new_mst_password;          // SESSION変数にnew_mst_passwordを保持
    header('Location:c_top_master_password_change_done.php');       // c_top_master_pass_change_done.phpへリダイレクト
    exit();
} else {                // 入力に問題があった場合
    print '<br>';
    print '<input type="button" onclick="location.href=\'c_top_master_password_change.php\'" value="戻る">';
}
