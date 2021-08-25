<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['p_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="p_top_login.html">ログイン画面へ</a>';
        exit();
    } else {
        if (!isset($_SESSION['c_login'])) {
            print $_SESSION['player_name'];
            print 'さんログイン中<br>';
            print '<br>';
        } else {
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
    <title>p_questionaire_edit.php</title>
</head>

<body>

    <h3>問診表の編集</h3>

    <?php
    try {
        // 自作の関数を呼び出す
	    require_once('../../function/function.php');

        // player_codeをセッションで受け取る
        $player_code = $_SESSION['player_code'];

        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // questionnaireテーブルから会員コードを使って情報を検索
        $sql = '
                SELECT *
                FROM questionnaire 
                WHERE player_code = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $player_code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // player_managementデータベースから切断する
        $dbh = null;

        print '<form method="post" action="p_questionnaire_edit_check.php">';

        // 怪我の情報
        print '怪我<br>';
        for ($i = 1; $i <= 10; $i++) {
            $injury_name = 'injury' . (string)$i . '_name';
            $injury_status = 'injury' . (string)$i . '_status';
            $injury_year = 'injury' . (string)$i . '_year';
            $injury_month = 'injury' . (string)$i . '_month';

            print $i . '.　';
            print '<input type="text" name="' . $injury_name . '" value="' . $rec[$injury_name] . '">　';
            print select_status($injury_status, $rec[$injury_status]) . '　';
            print select_year($injury_year, $rec[$injury_year]) . '年　';
            print select_month($injury_month, $rec[$injury_month]) . '月<br>';
        }
        print '<br>';

        // アレルギーの情報
        print 'アレルギー<br>';
        for ($i = 1; $i <= 5; $i++) {
            $allergy_name = 'allergy' . (string)$i . '_name';
            $allergy_status = 'allergy' . (string)$i . '_status';
            $allergy_year = 'allergy' . (string)$i . '_year';
            $allergy_month = 'allergy' . (string)$i . '_month';

            print $i . '.　';
            print '<input type="text" name="' . $allergy_name . '" value="' . $rec[$allergy_name] . '">　';
            print select_status($allergy_status, $rec[$allergy_status]) . '　';
            print select_year($allergy_year, $rec[$allergy_year]) . '年　';
            print select_month($allergy_month, $rec[$allergy_month]) . '月<br>';
        }
        print '<br>';

        // 病気の情報
        print '病気<br>';
        for ($i = 1; $i <= 5; $i++) {
            $sick_name = 'sick' . (string)$i . '_name';
            $sick_status = 'sick' . (string)$i . '_status';
            $sick_year = 'sick' . (string)$i . '_year';
            $sick_month = 'sick' . (string)$i . '_month';

            print $i . '.　';
            print '<input type="text" name="' . $sick_name . '" value="' . $rec[$sick_name] . '">　';
            print select_status($sick_status, $rec[$sick_status]) . '　';
            print select_year($sick_year, $rec[$sick_year]) . '年　';
            print select_month($sick_month, $rec[$sick_month]) . '月<br>';
        }
        print '<br>';

        // メモの情報
        print 'メモ<br>';
        print '<textarea name="note" rows="4" cols="40">' . $rec['note'] . '</textarea><br>';

        print '<br><br>';

        print '<input type="button" onclick="location.href=\'p_questionnaire_top.php\'" value="戻る">';
        print '<input type="submit" value="編集">';
        print '</form>';

    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

</body>

</html>