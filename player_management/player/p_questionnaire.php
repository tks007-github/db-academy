<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['login'])) {
    print 'ログインされていません。<br>';
    print '<a href="s_login.html">ログイン画面へ</a>';
    exit();
} else {
    $p_code = $_SESSION['p_code'];
    print $p_code;
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
    <title>Player</title>
</head>

<body>

    <h3>問診表の登録情報内容</h3>
    
    <?php
    try {
        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // questionnaireテーブルから会員コードを使って怪我の情報を検索
        $sql1 = '
                SELECT name, status_code, year, month 
                FROM questionnaire 
                WHERE player_code = ? AND item_code = 1
                ORDER BY year DESC
                ';
        $stmt1 = $dbh -> prepare($sql1);
        $data1[0] = $p_code;
        $stmt1 -> execute($data1);
        $rec1_1 = $stmt1 -> fetch(PDO::FETCH_ASSOC);
        $rec1_2 = $stmt1 -> fetch(PDO::FETCH_ASSOC);

        // questionnaireテーブルから会員コードを使ってアレルギーの情報を検索
        $sql2 = '
                SELECT name, status_code, year, month 
                FROM questionnaire 
                WHERE player_code = ? AND item_code = 2
                ORDER BY year DESC
                ';
        $stmt2 = $dbh -> prepare($sql2);
        $data2[0] = $p_code;
        $stmt2 -> execute($data1);
        $rec2_1 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
        $rec2_2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
        
        // questionnaireテーブルから会員コードを使って病気の情報を検索
        $sql3 = '
                SELECT name, status_code, year, month 
                FROM questionnaire 
                WHERE player_code = ? AND item_code = 3
                ORDER BY year DESC
                ';
        $stmt3 = $dbh -> prepare($sql3);
        $data3[0] = $p_code;
        $stmt3 -> execute($data1);
        $rec3_1 = $stmt3 -> fetch(PDO::FETCH_ASSOC);
        $rec3_2 = $stmt3 -> fetch(PDO::FETCH_ASSOC);

        // player_managementデータベースから切断する
        $dbh = null;

        // status_codeからstatus_valueを取得するための配列を用意
        $status_value = ['治療済み', '治療中'];

        if ($rec1_1 == false) {                  // データベースからの問い合わせ結果がない場合
            print '登録情報がありません。<br><br>';
            print '<input type="button" onclick="location.href=\'p_top.php\'" value="戻る">';
            print '<input type="button" onclick="location.href=\'p_questionnaire_add.php\'" value="登録">';
        } else {                              // データベースからの問い合わせ結果があった場合
            print '<form method="post" action="p_questionnaire_edit.php">';

            print '怪我<br>'; 
            if ($rec1_1['name'] == 'なし') {
                print 'なし<br>';
                print '<input type="hidden" name="injury_num" value=0>';
            } elseif ($rec1_2['name'] == 'なし') {
                print $rec1_1['name'] . '　' . $status_value[$rec1_1['status_code']-1] . '　' . $rec1_1['year'] . '年' . $rec1_1['month'] . '月<br>';
                print '<input type="hidden" name="injury_num" value=1>';
                print '<input type="hidden" name="injury1_name" value="' . $rec1_1['name'] . '">';
                print '<input type="hidden" name="injury1_status_code" value="' . $rec1_1['status_code'] . '">';
                print '<input type="hidden" name="injury1_year" value="' . $rec1_1['year'] . '">';
                print '<input type="hidden" name="injury1_month" value="' . $rec1_1['month'] . '">';
            } else {
                print $rec1_1['name'] . '　' . $status_value[$rec1_1['status_code']-1] . '　' . $rec1_1['year'] . '年' . $rec1_1['month'] . '月<br>';
                print $rec1_2['name'] . '　' . $status_value[$rec1_2['status_code']-1] . '　' . $rec1_2['year'] . '年' . $rec1_2['month'] . '月<br>';
                print '<input type="hidden" name="injury_num" value=2>';
                print '<input type="hidden" name="injury1_name" value="' . $rec1_1['name'] . '">';
                print '<input type="hidden" name="injury1_status_code" value="' . $rec1_1['status_code'] . '">';
                print '<input type="hidden" name="injury1_year" value="' . $rec1_1['year'] . '">';
                print '<input type="hidden" name="injury1_month" value="' . $rec1_1['month'] . '">';
                print '<input type="hidden" name="injury2_name" value="' . $rec1_2['name'] . '">';
                print '<input type="hidden" name="injury2_status_code" value="' . $rec1_2['status_code'] . '">';
                print '<input type="hidden" name="injury2_year" value="' . $rec1_2['year'] . '">';
                print '<input type="hidden" name="injury2_month" value="' . $rec1_2['month'] . '">';
            }
            print '<br>';

            print 'アレルギー<br>'; 
            if ($rec2_1['name'] == 'なし') {
                print 'なし<br>';
                print '<input type="hidden" name="allergies_num" value=0>';
            } elseif ($rec2_2['name'] == 'なし') {
                print $rec2_1['name'] . '　' . $status_value[$rec2_1['status_code']-1] . '　' . $rec2_1['year'] . '年' . $rec2_1['month'] . '月<br>';
                print '<input type="hidden" name="allergies_num" value=1>';
                print '<input type="hidden" name="allergies1_name" value="' . $rec2_1['name'] . '">';
                print '<input type="hidden" name="allergies1_status_code" value="' . $rec2_1['status_code'] . '">';
                print '<input type="hidden" name="allergies1_year" value="' . $rec2_1['year'] . '">';
                print '<input type="hidden" name="allergies1_month" value="' . $rec2_1['month'] . '">';
            } else {
                print $rec2_1['name'] . '　' . $status_value[$rec2_1['status_code']-1] . '　' . $rec2_1['year'] . '年' . $rec2_1['month'] . '月<br>';
                print $rec2_2['name'] . '　' . $status_value[$rec2_2['status_code']-1] . '　' . $rec2_2['year'] . '年' . $rec2_2['month'] . '月<br>';
                print '<input type="hidden" name="allergies_num" value=2>';
                print '<input type="hidden" name="allergies1_name" value="' . $rec2_1['name'] . '">';
                print '<input type="hidden" name="allergies1_status_code" value="' . $rec2_1['status_code'] . '">';
                print '<input type="hidden" name="allergies1_year" value="' . $rec2_1['year'] . '">';
                print '<input type="hidden" name="allergies1_month" value="' . $rec2_1['month'] . '">';
                print '<input type="hidden" name="allergies2_name" value="' . $rec2_2['name'] . '">';
                print '<input type="hidden" name="allergies2_status_code" value="' . $rec2_2['status_code'] . '">';
                print '<input type="hidden" name="allergies2_year" value="' . $rec2_2['year'] . '">';
                print '<input type="hidden" name="allergies2_month" value="' . $rec2_2['month'] . '">';
            }
            print '<br>';

            print '病気<br>'; 
            if ($rec3_1['name'] == 'なし') {
                print 'なし<br>';
                print '<input type="hidden" name="sick_num" value=0>';
            } elseif ($rec3_2['name'] == 'なし') {
                print $rec3_1['name'] . '　' . $status_value[$rec3_1['status_code']-1] . '　' . $rec3_1['year'] . '年' . $rec3_1['month'] . '月<br>';
                print '<input type="hidden" name="sick_num" value=1>';
                print '<input type="hidden" name="sick1_name" value="' . $rec3_1['name'] . '">';
                print '<input type="hidden" name="sick1_status_code" value="' . $rec3_1['status_code'] . '">';
                print '<input type="hidden" name="sick1_year" value="' . $rec3_1['year'] . '">';
                print '<input type="hidden" name="sick1_month" value="' . $rec3_1['month'] . '">';
            } else {
                print $rec3_1['name'] . '　' . $status_value[$rec3_1['status_code']-1] . '　' . $rec3_1['year'] . '年' . $rec3_1['month'] . '月<br>';
                print $rec3_2['name'] . '　' . $status_value[$rec3_2['status_code']-1] . '　' . $rec3_2['year'] . '年' . $rec3_2['month'] . '月<br>';
                print '<input type="hidden" name="sick_num" value=2>';
                print '<input type="hidden" name="sick1_name" value="' . $rec3_1['name'] . '">';
                print '<input type="hidden" name="sick1_status_code" value="' . $rec3_1['status_code'] . '">';
                print '<input type="hidden" name="sick1_year" value="' . $rec3_1['year'] . '">';
                print '<input type="hidden" name="sick1_month" value="' . $rec3_1['month'] . '">';
                print '<input type="hidden" name="sick2_name" value="' . $rec3_2['name'] . '">';
                print '<input type="hidden" name="sick2_status_code" value="' . $rec3_2['status_code'] . '">';
                print '<input type="hidden" name="sick2_year" value="' . $rec3_2['year'] . '">';
                print '<input type="hidden" name="sick2_month" value="' . $rec3_2['month'] . '">';
            }
            print '<br><br>';

			print '<input type="button" onclick="location.href=\'p_top.php\'" value="戻る">';
            print '<input type="submit" value="編集">';
            print '</form>';
        }
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>
    
</body>

</html>