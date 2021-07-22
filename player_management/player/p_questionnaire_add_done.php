<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['login'])) {
    print 'ログインされていません。<br>';
    print '<a href="p_login.html">ログイン画面へ</a>';
    exit();
} else {
    $p_code = $_SESSION['p_code'];
}
try {
    // p_questionnaire_edit_done.phpから渡された値をサニタイズ
    $injury = htmlspecialchars($_POST['injury'], ENT_QUOTES, 'UTF-8');
    $allergies = htmlspecialchars($_POST['allergies'], ENT_QUOTES, 'UTF-8');
    $sick = htmlspecialchars($_POST['sick'], ENT_QUOTES, 'UTF-8');

    // player_managementデータベースに接続
    $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // questionnaireテーブルに内容を追加
    $sql = 'INSERT INTO questionnaire(player_code, injury, allergies, sick) VALUES(?, ?, ?, ?)';
    $stmt = $dbh->prepare($sql);
    $data[0] = $p_code;
    $data[1] = $injury;
    $data[2] = $allergies;
    $data[3] = $sick;
    $stmt->execute($data);

    // player_managementデータベースから切断
    $dbh = null;

    header('Location:p_questionnaire.php');            // p_questionnaire.phpへリダイレクト
    exit();
} catch (Exception $e) {
    var_dump($e);
    exit();
}
