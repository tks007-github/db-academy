<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="../p_top/p_top_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['player_name'];
    print 'さんログイン中<br>';
    print '<br>';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_questionaire_edit_done.php</title>
</head>

<body>

    <h3>問診表の編集完了</h3>

    <?php
    try {
        // 自作の関数を呼び出す
        require_once('../../function/function.php');
        // POSTの中身をすべてサニタイズする
        $post = sanitize($_POST);

        // p_questionnaire_edit.phpから怪我(injury)、アレルギー(allergy)、病気(sick)の情報を受け取る
        // 怪我の情報
        for ($i = 1; $i <= 10; $i++) {
            $injury_name = 'injury' . (string)$i . '_name';
            $injury_status = 'injury' . (string)$i . '_status';
            $injury_year = 'injury' . (string)$i . '_year';
            $injury_month = 'injury' . (string)$i . '_month';

            $injury_name_array[$i] = $post[$injury_name];
            $injury_status_array[$i] = $post[$injury_status];
            $injury_year_array[$i] = $post[$injury_year];
            $injury_month_array[$i] = $post[$injury_month];
        }

        // アレルギーの情報
        for ($i = 1; $i <= 5; $i++) {
            $allergy_name = 'allergy' . (string)$i . '_name';
            $allergy_status = 'allergy' . (string)$i . '_status';
            $allergy_year = 'allergy' . (string)$i . '_year';
            $allergy_month = 'allergy' . (string)$i . '_month';

            $allergy_name_array[$i] = $post[$allergy_name];
            $allergy_status_array[$i] = $post[$allergy_status];
            $allergy_year_array[$i] = $post[$allergy_year];
            $allergy_month_array[$i] = $post[$allergy_month];
        }

        // 病気の情報
        for ($i = 1; $i <= 5; $i++) {
            $sick_name = 'sick' . (string)$i . '_name';
            $sick_status = 'sick' . (string)$i . '_status';
            $sick_year = 'sick' . (string)$i . '_year';
            $sick_month = 'sick' . (string)$i . '_month';

            $sick_name_array[$i] = $post[$sick_name];
            $sick_status_array[$i] = $post[$sick_status];
            $sick_year_array[$i] = $post[$sick_year];
            $sick_month_array[$i] = $post[$sick_month];
        }

        // メモの情報
        $note = $post['note'];


        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // questionnaireテーブルの情報を更新
        $sql = 'UPDATE questionnaire SET ';

        // 怪我の情報をsql文に追加
        for ($i = 1; $i <= 10; $i++) {
            $injury_name = 'injury' . (string)$i . '_name';
            $injury_status = 'injury' . (string)$i . '_status';
            $injury_year = 'injury' . (string)$i . '_year';
            $injury_month = 'injury' . (string)$i . '_month';

            $sql .= $injury_name . ' = ?, ';
            $data[] = $injury_name_array[$i];
            $sql .= $injury_status . ' = ?, ';
            $data[] = $injury_status_array[$i];
            $sql .= $injury_year . ' = ?, ';
            $data[] = $injury_year_array[$i];
            $sql .= $injury_month . ' = ?, ';
            $data[] = $injury_month_array[$i];
        }

        // アレルギーの情報をsql文に追加
        for ($i = 1; $i <= 5; $i++) {
            $allergy_name = 'allergy' . (string)$i . '_name';
            $allergy_status = 'allergy' . (string)$i . '_status';
            $allergy_year = 'allergy' . (string)$i . '_year';
            $allergy_month = 'allergy' . (string)$i . '_month';

            $sql .= $allergy_name . ' = ?, ';
            $data[] = $allergy_name_array[$i];
            $sql .= $allergy_status . ' = ?, ';
            $data[] = $allergy_status_array[$i];
            $sql .= $allergy_year . ' = ?, ';
            $data[] = $allergy_year_array[$i];
            $sql .= $allergy_month . ' = ?, ';
            $data[] = $allergy_month_array[$i];
        }

        // 病気の情報をsql文に追加
        for ($i = 1; $i <= 5; $i++) {
            $sick_name = 'sick' . (string)$i . '_name';
            $sick_status = 'sick' . (string)$i . '_status';
            $sick_year = 'sick' . (string)$i . '_year';
            $sick_month = 'sick' . (string)$i . '_month';

            $sql .= $sick_name . ' = ?, ';
            $data[] = $sick_name_array[$i];
            $sql .= $sick_status . ' = ?, ';
            $data[] = $sick_status_array[$i];
            $sql .= $sick_year . ' = ?, ';
            $data[] = $sick_year_array[$i];
            $sql .= $sick_month . ' = ?, ';
            $data[] = $sick_month_array[$i];
        }

        // メモの情報をsql文に追加
        $sql .= 'note = ?';
        $data[] = $note;

        $sql .= 'WHERE player_code = ?';
        $data[] = $_SESSION['player_code'];

        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // player_managementデータベースから切断する
        $dbh = null;

        print '編集が完了しました<br><br>';
        print '<input type="button" onclick="location.href=\'p_questionnaire_top.php\'" value="戻る">';
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>