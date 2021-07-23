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
    // injury1
    $sql1_1 = 'UPDATE questionnaire SET name = ?, status_code = ?, year = ?, month = ? WHERE player_code = ? AND item_code = 1 AND num = 1';
    $stmt1_1 = $dbh -> prepare($sql1_1);
    $data1_1[0] = $injury1_name;
    $data1_1[1] = $injury1_status_code;
    $data1_1[2] = $injury1_year;
    $data1_1[3] = $injury1_month;
    $data1_1[4] = $p_code;
    $stmt1_1 -> execute($data1_1);

    // injury2
    $sql1_2 = 'UPDATE questionnaire SET name = ?, status_code = ?, year = ?, month = ? WHERE player_code = ? AND item_code = 1 AND num = 2';
    $stmt1_2 = $dbh -> prepare($sql1_2);
    $data1_2[0] = $injury2_name;
    $data1_2[1] = $injury2_status_code;
    $data1_2[2] = $injury2_year;
    $data1_2[3] = $injury2_month;
    $data1_2[4] = $p_code;
    $stmt1_2 -> execute($data1_2);

    // allergies1
    $sql2_1 = 'UPDATE questionnaire SET name = ?, status_code = ?, year = ?, month = ? WHERE player_code = ? AND item_code = 2 AND num = 1';
    $stmt2_1 = $dbh -> prepare($sql2_1);
    $data2_1[0] = $allergies1_name;
    $data2_1[1] = $allergies1_status_code;
    $data2_1[2] = $allergies1_year;
    $data2_1[3] = $allergies1_month;
    $data2_1[4] = $p_code;
    $stmt2_1 -> execute($data2_1);

    // allergies2
    $sql2_2 = 'UPDATE questionnaire SET name = ?, status_code = ?, year = ?, month = ? WHERE player_code = ? AND item_code = 2 AND num = 2';
    $stmt2_2 = $dbh -> prepare($sql2_2);
    $data2_2[0] = $allergies2_name;
    $data2_2[1] = $allergies2_status_code;
    $data2_2[2] = $allergies2_year;
    $data2_2[3] = $allergies2_month;
    $data2_2[4] = $p_code;
    $stmt2_2 -> execute($data2_2);

    // sick1
    $sql3_1 = 'UPDATE questionnaire SET name = ?, status_code = ?, year = ?, month = ? WHERE player_code = ? AND item_code = 3 AND num = 1';
    $stmt3_1 = $dbh -> prepare($sql3_1);
    $data3_1[0] = $sick1_name;
    $data3_1[1] = $sick1_status_code;
    $data3_1[2] = $sick1_year;
    $data3_1[3] = $sick1_month;
    $data3_1[4] = $p_code;
    $stmt3_1 -> execute($data3_1);

    // sick2
    $sql3_2 = 'UPDATE questionnaire SET name = ?, status_code = ?, year = ?, month = ? WHERE player_code = ? AND item_code = 3 AND num = 2';
    $stmt3_2 = $dbh -> prepare($sql3_2);
    $data3_2[0] = $sick2_name;
    $data3_2[1] = $sick2_status_code;
    $data3_2[2] = $sick2_year;
    $data3_2[3] = $sick2_month;
    $data3_2[4] = $p_code;
    $stmt3_2 -> execute($data3_2);

    // player_managementデータベースから切断
    $dbh = null;

    header('Location:p_questionnaire.php');            // p_questionnaire.phpへリダイレクト
    exit();
} catch (Exception $e) {
    var_dump($e);
    exit();
}
