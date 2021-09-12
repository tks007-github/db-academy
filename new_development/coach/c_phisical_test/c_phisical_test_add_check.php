<!-- 
    c_phisical_test_add.phpからの入力情報をチェックし、遷移先を決定する。
    問題なし→c_phisical_test_add_done.phpへリダイレクト
    問題あり→エラーメッセージを出力し、戻るボタンでc_phisical_test_add.phpへ遷移
 -->

<?php
session_start();
session_regenerate_id(true);

// 自作の関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);

// c_phisical_test_topからの情報をPOSTで受け取る
if (!isset($post['date'])) {
    $date = '';
} else {
    $date = $post['date'];
}

if (!isset($post['belong_code'])) {
    $belong_code = '';
} else {
    $belong_code = $post['belong_code'];
}

if (!isset($post['10m走_boolean'])) {
    $test1_boolean = '';
} else {
    $test1_boolean = $post['10m走_boolean'];
}

if (!isset($post['20m走_boolean'])) {
    $test2_boolean = '';
} else {
    $test2_boolean = $post['20m走_boolean'];
}

if (!isset($post['30m走_boolean'])) {
    $test3_boolean = '';
} else {
    $test3_boolean = $post['30m走_boolean'];
}

if (!isset($post['50m走_boolean'])) {
    $test4_boolean = '';
} else {
    $test4_boolean = $post['50m走_boolean'];
}

if (!isset($post['1500m走_boolean'])) {
    $test5_boolean = '';
} else {
    $test5_boolean = $post['1500m走_boolean'];
}

if (!isset($post['プロアジリティ_boolean'])) {
    $test6_boolean = '';
} else {
    $test6_boolean = $post['プロアジリティ_boolean'];
}

if (!isset($post['立ち幅跳び_boolean'])) {
    $test7_boolean = '';
} else {
    $test7_boolean = $post['立ち幅跳び_boolean'];
}

if (!isset($post['メディシンボール投げ_boolean'])) {
    $test8_boolean = '';
} else {
    $test8_boolean = $post['メディシンボール投げ_boolean'];
}

if (!isset($post['垂直飛び_boolean'])) {
    $test9_boolean = '';
} else {
    $test9_boolean = $post['垂直飛び_boolean'];
}

if (!isset($post['背筋力_boolean'])) {
    $test10_boolean = '';
} else {
    $test10_boolean = $post['背筋力_boolean'];
}

if (!isset($post['握力_boolean'])) {
    $test11_boolean = '';
} else {
    $test11_boolean = $post['握力_boolean'];
}

if (!isset($post['サイドステップ_boolean'])) {
    $test12_boolean = '';
} else {
    $test12_boolean = $post['サイドステップ_boolean'];
}

// DB接続
try {
    // db_academyデータベースに接続する
    $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // phisical_testテーブルからbelong_codeとdateを使って情報を検索
    $sql = '
            SELECT * FROM phisical_test
            WHERE belong_code = ? AND date = ?
            ';
    $stmt = $dbh->prepare($sql);
    $data[] = $belong_code;
    $data[] = $date;
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

// dateの入力がない場合
if ($date == '') {
    print '日付の情報について入力漏れがあります<br>';
    $flg = false;
}

// belong_codeの選択がない場合
if ($belong_code == '') {
    print '所属の情報について入力漏れがあります<br>';
    $flg = false;
}

// すでに同じ日付、同じ所属のフィジカルテストが存在する場合
if ($rec != '') {
    print 'すでに同じ日付、同じ所属のフィジカルテストが存在します<br>';
    $flg = false;
}


// checkが一項目もない場合
if (
    $test1_boolean == '' && $test2_boolean == '' && $test3_boolean == '' &&
    $test4_boolean == '' && $test5_boolean == '' && $test6_boolean == '' &&
    $test7_boolean == '' && $test8_boolean == '' && $test9_boolean == '' &&
    $test10_boolean == '' && $test11_boolean == '' && $test12_boolean == ''
) {
    print 'フィジカルテストの項目が一つも選択されていません<br>';
    $flg = false;
}


if ($flg) {             // 入力に問題がない場合
    $_SESSION['date'] = $date;
    $_SESSION['belong_code'] = $belong_code;
    $_SESSION['10m走_boolean'] = $test1_boolean;
    $_SESSION['20m走_boolean'] = $test2_boolean;
    $_SESSION['30m走_boolean'] = $test3_boolean;
    $_SESSION['50m走_boolean'] = $test4_boolean;
    $_SESSION['1500m走_boolean'] = $test5_boolean;
    $_SESSION['プロアジリティ_boolean'] = $test6_boolean;
    $_SESSION['立ち幅跳び_boolean'] = $test7_boolean;
    $_SESSION['メディシンボール投げ_boolean'] = $test8_boolean;
    $_SESSION['垂直飛び_boolean'] = $test9_boolean;
    $_SESSION['背筋力_boolean'] = $test10_boolean;
    $_SESSION['握力_boolean'] = $test11_boolean;
    $_SESSION['サイドステップ_boolean'] = $test12_boolean;
    header('Location:c_phisical_test_add_done.php');    // c_phisical_test_add_done.phpへリダイレクト
    exit();
} else {                // 入力に問題があった場合
    print '<input type="button" onclick="location.href=\'c_phisical_test_add.php\'" value="戻る">';
}
