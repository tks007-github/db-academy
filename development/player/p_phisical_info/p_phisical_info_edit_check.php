<?php
session_start();
session_regenerate_id(true);
$player_code = $_SESSION['player_code'];

// 自作の関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);

// p_phisical_info_edit.phpから身体情報を受け取る
$date = $post['date'];
$height = $post['height'];
$weight = $post['weight'];
$body_fat = $post['body_fat'];
$muscle_mass = $post['muscle_mass'];


// 入力内容の問題の有無をflgによって判定(問題なし:true、問題あり:false)
$flg = true;

if ($date == '') {
    $flg = false;
}

if ($height == '') {
    $flg = false;
}

if ($weight == '') {
    $flg = false;
}

if ($body_fat == '') {
    $flg = false;
}

if ($muscle_mass == '') {
    $flg = false;
}

// db_academyデータベースから切断する
$dbh = null;

if ($flg) {             // 入力に問題がなかった場合
    $_SESSION['date'] = $date;                          // セッション変数にdateを保持
    $_SESSION['height'] = $height;                      // セッション変数にheightを保持
    $_SESSION['weight'] = $weight;                      // セッション変数にweightを保持
    $_SESSION['body_fat'] = $body_fat;                  // セッション変数にbody_fatを保持
    $_SESSION['muscle_mass'] = $muscle_mass;            // セッション変数にmuscle_massを保持
    header('Location:p_phisical_info_edit_done.php');   // p_phisical_info_edit_done.phpへリダイレクト
    exit();
} else {                // 入力に問題があった場合
    print '入力に誤りがあります<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_info_edit.php\'" value="戻る">';
}
