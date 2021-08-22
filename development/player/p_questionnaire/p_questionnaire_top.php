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
    <title>p_questionaire_top.php</title>
</head>

<body>

    <h3>問診表の登録情報内容</h3>
    
    <?php
    try {
        // player_codeをセッションで受け取る
        $player_code = $_SESSION['player_code'];

        // db_academyデータベースに接続する
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
        $stmt = $dbh -> prepare($sql);
        $data[] = $player_code;
        $stmt -> execute($data);
        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

        // player_managementデータベースから切断する
        $dbh = null;

        if ($rec == '') {                     // データベースからの問い合わせ結果がない場合
            print '登録情報がありません。<br><br>';
            print '<input type="button" onclick="location.href=\'../p_top.php\'" value="戻る">';
            print '<input type="button" onclick="location.href=\'p_questionnaire_add.php\'" value="登録">';
        } else {                              // データベースからの問い合わせ結果があった場合
            
            // 怪我の情報
            print '怪我<br>';
            $injury_flg = true;
            for ($i = 1; $i <= 10; $i++) {
                $injury_name = 'injury' . (string)$i . '_name';
                $injury_status = 'injury' . (string)$i . '_status';
                $injury_year = 'injury' . (string)$i . '_year';
                $injury_month = 'injury' . (string)$i . '_month';

                if ($rec[$injury_name] != '') {             // $rec[$injury_name]が空でない場合
                    print $i . '.　';
                    print $rec[$injury_name] . '　';
                    print $rec[$injury_status] . '　';
                    print $rec[$injury_year] . '年　';
                    print $rec[$injury_month] . '月<br>';
                    $injury_flg = false;
                }
            }
            if ($injury_flg) {
                print 'なし<br>';
            }
            print '<br>';

            // アレルギーの情報
            print 'アレルギー<br>';
            $allergy_flg = true;
            for ($i = 1; $i <= 5; $i++) {
                $allergy_name = 'allergy' . (string)$i . '_name';
                $allergy_status = 'allergy' . (string)$i . '_status';
                $allergy_year = 'allergy' . (string)$i . '_year';
                $allergy_month = 'allergy' . (string)$i . '_month';

                if ($rec[$allergy_name] != '') {             // $rec[$allergy_name]が空でない場合
                    print $i . '.　';
                    print $rec[$allergy_name] . '　';
                    print $rec[$allergy_status] . '　';
                    print $rec[$allergy_year] . '年　';
                    print $rec[$allergy_month] . '月<br>';
                    $allergy_flg = false;
                }
            }
            if ($allergy_flg) {
                print 'なし<br>';
            }
            print '<br>';

            // 病気の情報
            print '病気<br>';
            $sick_flg = true;
            for ($i = 1; $i <= 5; $i++) {
                $sick_name = 'sick' . (string)$i . '_name';
                $sick_status = 'sick' . (string)$i . '_status';
                $sick_year = 'sick' . (string)$i . '_year';
                $sick_month = 'sick' . (string)$i . '_month';

                if ($rec[$sick_name] != '') {                // $rec[$sick_name]が空でない場合
                    print $i . '.　';
                    print $rec[$sick_name] . '　';
                    print $rec[$sick_status] . '　';
                    print $rec[$sick_year] . '年　';
                    print $rec[$sick_month] . '月<br>';
                    $sick_flg = false;
                }
            }
            if ($sick_flg) {
                print 'なし<br>';
            }
            print '<br>';

            // メモの情報
            print 'メモ<br>';
            $note_flg = true;
            if ($rec['note'] != '') {
                print $rec['note'] . '<br>';
                $note_flg = false;
            }
            if ($note_flg) {
                print 'なし<br>';
            }
            print '<br>';
            
            print '<br><br>';

			print '<input type="button" onclick="location.href=\'../p_top/p_top.php\'" value="戻る">';
            print '<input type="button" onclick="location.href=\'p_questionnaire_edit.php\'" value="編集">';
            
        }
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>
    
</body>

</html>