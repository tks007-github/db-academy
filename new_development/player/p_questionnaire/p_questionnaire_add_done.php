<!-- 
    p_questionnaire_add_check.phpから受け取った問診表の情報をquestionnaireテーブルに
    インサートする。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません<br>';
    print '<a href="p_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)場合)
    if (!isset($_SESSION['c_login'])) {         // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
        print $_SESSION['player_name'];
        print 'さんログイン中<br>';
        print '<br>';
    } else {                                    // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
        print $_SESSION['coach_name'];
        print 'さんログイン中<br>';
        print '選手検索：' . $_SESSION['player_name'];
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_questionaire_add_done.php</title>
</head>

<body>

    <h3>問診表の登録完了</h3>

    <?php

    // p_questionnaire_add_check.phpから怪我(injury)、アレルギー(allergy)、病気(sick)の情報を受け取る

    // 怪我の情報
    for ($i = 1; $i <= 10; $i++) {
        $injury_name = 'injury' . (string)$i . '_name';
        $injury_status = 'injury' . (string)$i . '_status';
        $injury_year = 'injury' . (string)$i . '_year';
        $injury_month = 'injury' . (string)$i . '_month';

        $injury_name_array[$i] = $_SESSION[$injury_name];
        $injury_status_array[$i] = $_SESSION[$injury_status];
        $injury_year_array[$i] = $_SESSION[$injury_year];
        $injury_month_array[$i] = $_SESSION[$injury_month];
    }

    // アレルギーの情報
    for ($i = 1; $i <= 5; $i++) {
        $allergy_name = 'allergy' . (string)$i . '_name';
        $allergy_status = 'allergy' . (string)$i . '_status';
        $allergy_year = 'allergy' . (string)$i . '_year';
        $allergy_month = 'allergy' . (string)$i . '_month';

        $allergy_name_array[$i] = $_SESSION[$allergy_name];
        $allergy_status_array[$i] = $_SESSION[$allergy_status];
        $allergy_year_array[$i] = $_SESSION[$allergy_year];
        $allergy_month_array[$i] = $_SESSION[$allergy_month];
    }

    // 病気の情報
    for ($i = 1; $i <= 5; $i++) {
        $sick_name = 'sick' . (string)$i . '_name';
        $sick_status = 'sick' . (string)$i . '_status';
        $sick_year = 'sick' . (string)$i . '_year';
        $sick_month = 'sick' . (string)$i . '_month';

        $sick_name_array[$i] = $_SESSION[$sick_name];
        $sick_status_array[$i] = $_SESSION[$sick_status];
        $sick_year_array[$i] = $_SESSION[$sick_year];
        $sick_month_array[$i] = $_SESSION[$sick_month];
    }

    // メモの情報
    $note = $_SESSION['note'];

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // questionnaireテーブルの情報を更新
        $sql1 = 'INSERT INTO ';
        $sql2 = 'questionnaire(player_code, ';
        $sql3 = 'VALUES(?, ';
        $data[] = $_SESSION['player_code'];

        // 怪我の情報をsql文に追加
        for ($i = 1; $i <= 10; $i++) {
            $injury_name = 'injury' . (string)$i . '_name';
            $injury_status = 'injury' . (string)$i . '_status';
            $injury_year = 'injury' . (string)$i . '_year';
            $injury_month = 'injury' . (string)$i . '_month';

            $sql2 .= $injury_name . ', ';
            $sql3 .= '?, ';
            $data[] = $injury_name_array[$i];
            $sql2 .= $injury_status . ', ';
            $sql3 .= '?, ';
            $data[] = $injury_status_array[$i];
            $sql2 .= $injury_year . ', ';
            $sql3 .= '?, ';
            $data[] = $injury_year_array[$i];
            $sql2 .= $injury_month . ', ';
            $sql3 .= '?, ';
            $data[] = $injury_month_array[$i];
        }

        // アレルギーの情報をsql文に追加
        for ($i = 1; $i <= 5; $i++) {
            $allergy_name = 'allergy' . (string)$i . '_name';
            $allergy_status = 'allergy' . (string)$i . '_status';
            $allergy_year = 'allergy' . (string)$i . '_year';
            $allergy_month = 'allergy' . (string)$i . '_month';

            $sql2 .= $allergy_name . ', ';
            $sql3 .= '?, ';
            $data[] = $allergy_name_array[$i];
            $sql2 .= $allergy_status . ', ';
            $sql3 .= '?, ';
            $data[] = $allergy_status_array[$i];
            $sql2 .= $allergy_year . ', ';
            $sql3 .= '?, ';
            $data[] = $allergy_year_array[$i];
            $sql2 .= $allergy_month . ', ';
            $sql3 .= '?, ';
            $data[] = $allergy_month_array[$i];
        }

        // 病気の情報をsql文に追加
        for ($i = 1; $i <= 5; $i++) {
            $sick_name = 'sick' . (string)$i . '_name';
            $sick_status = 'sick' . (string)$i . '_status';
            $sick_year = 'sick' . (string)$i . '_year';
            $sick_month = 'sick' . (string)$i . '_month';

            $sql2 .= $sick_name . ', ';
            $sql3 .= '?, ';
            $data[] = $sick_name_array[$i];
            $sql2 .= $sick_status . ', ';
            $sql3 .= '?, ';
            $data[] = $sick_status_array[$i];
            $sql2 .= $sick_year . ', ';
            $sql3 .= '?, ';
            $data[] = $sick_year_array[$i];
            $sql2 .= $sick_month . ', ';
            $sql3 .= '?, ';
            $data[] = $sick_month_array[$i];
        }

        // メモの情報をsql文に追加
        $sql2 .= 'note)';
        $sql3 .= '?)';
        $data[] = $note;

        $sql = $sql1 . $sql2 . $sql3;

        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // player_managementデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    print '登録が完了しました<br><br>';
    print '<input type="button" onclick="location.href=\'p_questionnaire_top_branch.php\'" value="戻る">';

    ?>

</body>

</html>