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
    // p_questionnaire_edit.phpから渡された値をサニタイズ
    $injury1_name = htmlspecialchars($_POST['injury1_name'], ENT_QUOTES, 'UTF-8');
    $injury1_status_code = htmlspecialchars($_POST['injury1_status_code'], ENT_QUOTES, 'UTF-8');
    $injury1_year = htmlspecialchars($_POST['injury1_year'], ENT_QUOTES, 'UTF-8');
    $injury1_month = htmlspecialchars($_POST['injury1_month'], ENT_QUOTES, 'UTF-8');
    $injury2_name = htmlspecialchars($_POST['injury2_name'], ENT_QUOTES, 'UTF-8');
    $injury2_status_code = htmlspecialchars($_POST['injury2_status_code'], ENT_QUOTES, 'UTF-8');
    $injury2_year = htmlspecialchars($_POST['injury2_year'], ENT_QUOTES, 'UTF-8');
    $injury2_month = htmlspecialchars($_POST['injury2_month'], ENT_QUOTES, 'UTF-8');

    $allergies1_name = htmlspecialchars($_POST['allergies1_name'], ENT_QUOTES, 'UTF-8');
    $allergies1_status_code = htmlspecialchars($_POST['allergies1_status_code'], ENT_QUOTES, 'UTF-8');
    $allergies1_year = htmlspecialchars($_POST['allergies1_year'], ENT_QUOTES, 'UTF-8');
    $allergies1_month = htmlspecialchars($_POST['allergies1_month'], ENT_QUOTES, 'UTF-8');
    $allergies2_name = htmlspecialchars($_POST['allergies2_name'], ENT_QUOTES, 'UTF-8');
    $allergies2_status_code = htmlspecialchars($_POST['allergies2_status_code'], ENT_QUOTES, 'UTF-8');
    $allergies2_year = htmlspecialchars($_POST['allergies2_year'], ENT_QUOTES, 'UTF-8');
    $allergies2_month = htmlspecialchars($_POST['allergies2_month'], ENT_QUOTES, 'UTF-8');
    
    $sick1_name = htmlspecialchars($_POST['sick1_name'], ENT_QUOTES, 'UTF-8');
    $sick1_status_code = htmlspecialchars($_POST['sick1_status_code'], ENT_QUOTES, 'UTF-8');
    $sick1_year = htmlspecialchars($_POST['sick1_year'], ENT_QUOTES, 'UTF-8');
    $sick1_month = htmlspecialchars($_POST['sick1_month'], ENT_QUOTES, 'UTF-8');
    $sick2_name = htmlspecialchars($_POST['sick2_name'], ENT_QUOTES, 'UTF-8');
    $sick2_status_code = htmlspecialchars($_POST['sick2_status_code'], ENT_QUOTES, 'UTF-8');
    $sick2_year = htmlspecialchars($_POST['sick2_year'], ENT_QUOTES, 'UTF-8');
    $sick2_month = htmlspecialchars($_POST['sick2_month'], ENT_QUOTES, 'UTF-8');
    
    // player_managementデータベースに接続
    $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8mb4';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($injury1_name == '') {
        $injury1_name = 'なし';
    }
    if ($injury2_name == '') {
        $injury2_name = 'なし';
    }
    if ($allergies1_name == '') {
        $allergies1_name = 'なし';
    }
    if ($allergies2_name == '') {
        $allergies2_name = 'なし';
    }
    if ($sick1_name == '') {
        $sick1_name = 'なし';
    }
    if ($sick2_name == '') {
        $sick2_name = 'なし';
    }
    
    
    // questionnaireテーブルの内容を更新
    $sql = 'UPDATE questionnaire SET name = ?, status_code = ?, year = ?, month = ? WHERE player_code = ? AND item_code = 1';
    $stmt = $dbh->prepare($sql);
    $data[0] = $injury1_name;
    $data[1] = $injury1_status_code;
    $data[2] = $injury1_year;
    $data[3] = $injury1_month;
    $data[4] = $p_code;
    $stmt->execute($data);

    // player_managementデータベースから切断
    $dbh = null;

    header('Location:p_questionnaire.php');            // p_questionnaire.phpへリダイレクト
    exit();
} catch (Exception $e) {
    var_dump($e);
    exit();
}
