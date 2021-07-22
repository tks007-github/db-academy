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

    // questionnaireテーブルの内容を更新
    $sql = 'UPDATE questionnaire SET injury = ?, allergies = ?, sick = ? WHERE player_code = ?';
    $stmt = $dbh->prepare($sql);
    $data[0] = $injury;
    $data[1] = $allergies;
    $data[2] = $sick;
    $data[3] = $p_code;
    $stmt->execute($data);

    // player_managementデータベースから切断
    $dbh = null;

    header('Location:p_questionnaire.php');            // p_questionnaire.phpへリダイレクト
    exit();
} catch (Exception $e) {
    var_dump($e);
    exit();
}
