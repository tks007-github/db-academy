<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['m_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="m_login.html">ログイン画面へ</a>';
        exit();
    }

try {
    // m_phisical_test_item_add.phpから渡された値をサニタイズ
    $test_code = htmlspecialchars($_POST['test_code'], ENT_QUOTES, 'UTF-8');
    $test_value = htmlspecialchars($_POST['test_value'], ENT_QUOTES, 'UTF-8');
    
    // player_managementデータベースに接続
    $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // phisical_test_itemテーブルに内容を追加
    $sql = '
                UPDATE phisical_test_item
                SET test_value = ?
                WHERE test_code = ?
              ';
    $stmt = $dbh->prepare($sql);
    $data[0] = $test_value;
    $data[1] = $test_code;
    $stmt->execute($data);

    // player_managementデータベースから切断
    $dbh = null;

    header('Location:m_top.php');            // m_top.phpへリダイレクト
    exit();
} catch (Exception $e) {
    var_dump($e);
    exit();
}
