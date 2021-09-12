<!-- 
    c_phisical_test_delete.phpからの入力情報をチェックし、遷移先を決定する。
    問題なし→c_phisical_test_delete_done.phpへリダイレクト
    問題あり→エラーメッセージを出力し、戻るボタンでc_phisical_test_content.phpへ遷移
 -->

<?php
session_start();
session_regenerate_id(true);

// c_phisical_test_content.phpからの情報をSESSIONで受け取る
$date = $_SESSION['date'];
$belong_code = $_SESSION['belong_code'];

// DB接続
try {
    // db_academyデータベースに接続する
    $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // phisical_test_recordテーブルからplayer_codeとdateを使って情報を検索
    if ($belong_code == 'A') {
        $sql = "
                SELECT * FROM phisical_test_record
                WHERE player_code LIKE 'A%' AND date = ?
                ";
    } else if ($belong_code == 'B') {
        $sql = "
                SELECT * FROM phisical_test_record
                WHERE player_code LIKE 'B%' AND date = ?
                ";
    }
    $stmt = $dbh->prepare($sql);
    $data[] = $date;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // db_academyデータベースから切断する
    $dbh = null;
} catch (Exception $e) {
    var_dump($e);
    exit();
}

if ($rec == '') {       // 選手の記録が登録されていない場合
    header('Location:c_phisical_test_delete_done.php');    // c_phisical_test_delete_done.phpへリダイレクト
    exit();
} else {                // すでに選手の記録が登録されている場合
    print '選手の記録が登録されているので削除できません<br><br>';
    print '<input type="button" onclick="location.href=\'c_phisical_test_content.php\'" value="戻る">';
}
