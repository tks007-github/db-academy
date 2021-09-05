<!-- 
    身体情報の入力データがあるかないかで遷移先を決定する。
    入力データあり→p_questionnaire_add.php
    入力データなし→p_questionnaire_edit.php
 -->

<?php
session_start();
session_regenerate_id(true);


// p_phisical_infoディレクトリで使うSESSIONを初期化
$_SESSION['phisical_info_flg'] = '';
$_SESSION['date'] = '';
$_SESSION['height'] = '';
$_SESSION['weight'] = '';
$_SESSION['body_fat'] = '';
$_SESSION['muscle_mass'] = '';

// SESSION変数からplayer_codeを受け取る
$player_code = $_SESSION['player_code'];

// DB接続
try {
    // db_academyデータベースに接続する
    $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // phisical_infoテーブルから選手コード(player_code)を使って最新の情報を検索
    $sql = '
            SELECT date, height, weight, body_fat, muscle_mass 
            FROM phisical_info 
            WHERE player_code = ?
            AND date = (
            SELECT MAX(date)
            FROM phisical_info
            WHERE player_code = ?
            )
            ';
    $stmt = $dbh->prepare($sql);
    $data[] = $player_code;
    $data[] = $player_code;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // db_academyデータベースから切断する
    $dbh = null;
} catch (Exception $e) {
    var_dump($e);
    exit();
}

if ($rec == '') {                     // データベースからの問い合わせ結果がない場合
    header('Location: p_phisical_info_first_add.php');
    exit();
} else {                              // データベースからの問い合わせ結果があった場合
    header('Location: p_phisical_info_top.php');
    exit();
}
