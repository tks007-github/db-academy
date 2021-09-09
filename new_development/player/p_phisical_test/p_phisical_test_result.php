<!-- 
    フィジカルテストのグラフを表示する。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません。<br>';
    print '<a href="p_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)の場合)
    if (!isset($_SESSION['c_login'])) {         // 管理者でログイン状態の場合(SESSION[''])
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
    <title>p_phisical_test_result.php</title>
</head>

<body>

    <h3>フィジカルテスト成績表</h3>

    <?php

    // 自作の関数を呼び出す
    require_once('../../function/function.php');

    // player_codeとbelong_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];
    $belong_code = $_SESSION['belong_code'];

    // p_phisical_test_topからの情報をSESSIONで受け取る
    $date = $_SESSION['date'];

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_testテーブルからbelong_codeとdateを使って直近3回分の情報を検索
        $sql = '
                SELECT phisical_test_code, date, 10m走, 20m走, 30m走, 50m走, 1500m走,  
                プロアジリティ, 立ち幅跳び, メディシンボール投げ, 
                垂直飛び, 背筋力, 握力, サイドステップ 
                FROM phisical_test 
                WHERE belong_code = ?
                AND date <= ?
                ORDER BY date DESC
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $belong_code;
        $data[] = $date;
        $stmt->execute($data);

        // 過去3回分のフィジカルテストの項目の登録の有無を変数に保持
        for ($i = 0; $i < 3; $i++) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec == '') {
                $date_arr[] = '―';
                $test1_boolean[] = 0;
                $test2_boolean[] = 0;
                $test3_boolean[] = 0;
                $test4_boolean[] = 0;
                $test5_boolean[] = 0;
                $test6_boolean[] = 0;
                $test7_boolean[] = 0;
                $test8_boolean[] = 0;
                $test9_boolean[] = 0;
                $test10_boolean[] = 0;
                $test11_boolean[] = 0;
                $test12_boolean[] = 0;
            } else {
                $date_arr[] = $rec['date'];
                $test1_boolean[] = $rec['10m走'];
                $test2_boolean[] = $rec['20m走'];
                $test3_boolean[] = $rec['30m走'];
                $test4_boolean[] = $rec['50m走'];
                $test5_boolean[] = $rec['1500m走'];
                $test6_boolean[] = $rec['プロアジリティ'];
                $test7_boolean[] = $rec['立ち幅跳び'];
                $test8_boolean[] = $rec['メディシンボール投げ'];
                $test9_boolean[] = $rec['垂直飛び'];
                $test10_boolean[] = $rec['背筋力'];
                $test11_boolean[] = $rec['握力'];
                $test12_boolean[] = $rec['サイドステップ'];
            }
        }

        // phisical_test_recordテーブルからplayer_codeとdateを使って直近3回分の情報を検索
        for ($i = 0; $i < 3; $i++) {
            $sql2 = '
                    SELECT phisical_test_record_code, 10m走, 20m走, 30m走, 50m走, 1500m走,  
                    プロアジリティ, 立ち幅跳び, メディシンボール投げ, 
                    垂直飛び, 背筋力, 握力, サイドステップ 
                    FROM phisical_test_record 
                    WHERE player_code = ?
                    AND date = ?
                ';
            $stmt2 = $dbh->prepare($sql2);
            $data2[0] = $player_code;
            $data2[1] = $date_arr[$i];
            $stmt2->execute($data2);
            $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($test1_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test1_value[] = '未入力';
                } else {
                    $test1_value[] = $rec2['10m走'] . '秒';
                }
            } else {
                $test1_value[] = '―';
            }

            if ($test2_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test2_value[] = '未入力';
                } else {
                    $test2_value[] = $rec2['20m走'] . '秒';
                }
            } else {
                $test2_value[] = '―';
            }

            if ($test3_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test3_value[] = '未入力';
                } else {
                    $test3_value[] = $rec2['30m走'] . '秒';
                }
            } else {
                $test3_value[] = '―';
            }

            if ($test4_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test4_value[] = '未入力';
                } else {
                    $test4_value[] = $rec2['50m走']  . '秒';
                }
            } else {
                $test4_value[] = '―';
            }

            if ($test5_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test5_value[] = '未入力';
                } else {
                    $test5_value[] = floor($rec2['1500m走'] / 60) . '分' . $rec2['1500m走'] % 60 . '秒';
                }
            } else {
                $test5_value[] = '―';
            }

            if ($test6_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test6_value[] = '未入力';
                } else {
                    $test6_value[] = $rec2['プロアジリティ'] . '秒';
                }
            } else {
                $test6_value[] = '―';
            }

            if ($test7_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test7_value[] = '未入力';
                } else {
                    $test7_value[] = $rec2['立ち幅跳び'] . 'cm';
                }
            } else {
                $test7_value[] = '―';
            }

            if ($test8_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test8_value[] = '未入力';
                } else {
                    $test8_value[] = $rec2['メディシンボール投げ'] . 'm';
                }
            } else {
                $test8_value[] = '―';
            }

            if ($test9_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test9_value[] = '未入力';
                } else {
                    $test9_value[] = $rec2['垂直飛び'] . 'cm';
                }
            } else {
                $test9_value[] = '―';
            }

            if ($test10_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test10_value[] = '未入力';
                } else {
                    $test10_value[] = $rec2['背筋力'] . 'kg';
                }
            } else {
                $test10_value[] = '―';
            }

            if ($test11_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test11_value[] = '未入力';
                } else {
                    $test11_value[] = $rec2['握力'] . 'kg';
                }
            } else {
                $test11_value[] = '―';
            }

            if ($test12_boolean[$i] == 1) {
                if ($rec2 == '') {
                    $test12_value[] = '未入力';
                } else {
                    $test12_value[] = $rec2['サイドステップ'] . '回';
                }
            } else {
                $test12_value[] = '―';
            }
        }


        // 以下、レーダーチャート用の結果を保持
        $sql3_1 = '
                    SELECT date, 10m走  
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND 10m走 > 0
                    ORDER BY date DESC
                ';
        $stmt3_1 = $dbh->prepare($sql3_1);
        $data3_1[] = $player_code;
        $data3_1[] = $date;
        $stmt3_1->execute($data3_1);
        $rec3_1 = $stmt3_1->fetch(PDO::FETCH_ASSOC);
        $test1_recent_value[] = $rec3_1['10m走'];
        if ($rec3_1['date'] != $date) {
            $test1_recent_value[] = $rec3_1['10m走'];
        } else {
            $rec3_1 = $stmt3_1->fetch(PDO::FETCH_ASSOC);
            $test1_recent_value[] = $rec3_1['10m走'];
        }

        // 過去3回分の10m走の点数の決定
        for ($i = 0; $i < 2; $i++) {
            $test1_recent_score[] = test1_score($test1_recent_value[$i]);
        }
        

        $sql3_2 = '
                    SELECT date, 20m走  
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND 20m走 > 0
                    ORDER BY date DESC
                ';
        $stmt3_2 = $dbh->prepare($sql3_2);
        $data3_2[] = $player_code;
        $data3_2[] = $date;
        $stmt3_2->execute($data3_2);
        $rec3_2 = $stmt3_2->fetch(PDO::FETCH_ASSOC);
        $test2_recent_value[] = $rec3_2['20m走'];
        if ($rec3_2['date'] != $date) {
            $test2_recent_value[] = $rec3_2['20m走'];
        } else {
            $rec3_2 = $stmt3_2->fetch(PDO::FETCH_ASSOC);
            $test2_recent_value[] = $rec3_2['20m走'];
        }

        // 過去3回分の20m走の点数の決定
        // for ($i = 0; $i < 2; $i++) {
        //     $test2_recent_score[] = test2_score($test2_recent_value[$i]);
        // }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test2_recent_value[$i] >= 3.25 - (0.05 * $j)) {
                    $test2_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test2_recent_value[$i] < 2.85 && $test2_recent_value[$i] != '') {
                $test2_recent_score[] = 10;
            } else if ($test2_recent_value[$i] == '') {
                $test2_recent_score[] = NULL;
            }
        }


        $sql3_3 = '
                    SELECT date, 30m走  
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND 30m走 > 0
                    ORDER BY date DESC
                ';
        $stmt3_3 = $dbh->prepare($sql3_3);
        $data3_3[] = $player_code;
        $data3_3[] = $date;
        $stmt3_3->execute($data3_3);
        $rec3_3 = $stmt3_3->fetch(PDO::FETCH_ASSOC);
        $test3_recent_value[] = $rec3_3['30m走'];
        if ($rec3_3['date'] != $date) {
            $test3_recent_value[] = $rec3_3['30m走'];
        } else {
            $rec3_3 = $stmt3_3->fetch(PDO::FETCH_ASSOC);
            $test3_recent_value[] = $rec3_3['30m走'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test3_recent_value[$i] >= 5.2 - (0.15 * $j)) {
                    $test3_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test3_recent_value[$i] < 4 && $test3_recent_value[$i] != '') {
                $test3_recent_score[] = 10;
            } else if ($test3_recent_value[$i] == '') {
                $test3_recent_score[] = NULL;
            }
        }

        $sql3_4 = '
                    SELECT date, 50m走  
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND 50m走 > 0
                    ORDER BY date DESC
                ';
        $stmt3_4 = $dbh->prepare($sql3_4);
        $data3_4[] = $player_code;
        $data3_4[] = $date;
        $stmt3_4->execute($data3_4);
        $rec3_4 = $stmt3_4->fetch(PDO::FETCH_ASSOC);
        $test4_recent_value[] = $rec3_4['50m走'];
        if ($rec3_4['date'] != $date) {
            $test4_recent_value[] = $rec3_4['50m走'];
        } else {
            $rec3_4 = $stmt3_4->fetch(PDO::FETCH_ASSOC);
            $test4_recent_value[] = $rec3_4['50m走'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test4_recent_value[$i] >= 7.5 - (0.2 * $j)) {
                    $test4_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test4_recent_value[$i] < 5.9 && $test4_recent_value[$i] != '') {
                $test4_recent_score[] = 10;
            } else if ($test4_recent_value[$i] == '') {
                $test4_recent_score[] = NULL;
            }
        }

        $sql3_5 = '
                    SELECT date, 1500m走
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND 1500m走 > 0
                    ORDER BY date DESC
                ';
        $stmt3_5 = $dbh->prepare($sql3_5);
        $data3_5[] = $player_code;
        $data3_5[] = $date;
        $stmt3_5->execute($data3_5);
        $rec3_5 = $stmt3_5->fetch(PDO::FETCH_ASSOC);
        $test5_recent_value[] = $rec3_5['1500m走'];
        if ($rec3_5['date'] != $date) {
            $test5_recent_value[] = $rec3_5['1500m走'];
        } else {
            $rec3_5 = $stmt3_5->fetch(PDO::FETCH_ASSOC);
            $test5_recent_value[] = $rec3_5['1500m走'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 9; $j++) {
                if ($test5_recent_value[$i] >= 405 - (15 * $j)) {
                    $test5_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test5_recent_value[$i] < 285 && $test5_recent_value[$i] != '') {
                $test5_recent_score[] = 10;
            } else if ($test5_recent_value[$i] == '') {
                $test5_recent_score[] = NULL;
            }
        }

        $sql3_6 = '
                    SELECT date, プロアジリティ
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND プロアジリティ > 0
                    ORDER BY date DESC
                ';
        $stmt3_6 = $dbh->prepare($sql3_6);
        $data3_6[] = $player_code;
        $data3_6[] = $date;
        $stmt3_6->execute($data3_6);
        $rec3_6 = $stmt3_6->fetch(PDO::FETCH_ASSOC);
        $test6_recent_value[] = $rec3_6['プロアジリティ'];
        if ($rec3_6['date'] != $date) {
            $test6_recent_value[] = $rec3_6['プロアジリティ'];
        } else {
            $rec3_6 = $stmt3_6->fetch(PDO::FETCH_ASSOC);
            $test6_recent_value[] = $rec3_6['プロアジリティ'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test6_recent_value[$i] >= 5.3 - (0.1 * $j)) {
                    $test6_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test6_recent_value[$i] < 4.5 && $test6_recent_value[$i] != '') {
                $test6_recent_score[] = 10;
            } else if ($test6_recent_value[$i] == '') {
                $test6_recent_score[] = NULL;
            }
        }

        $sql3_7 = '
                    SELECT date, 立ち幅跳び
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND 立ち幅跳び > 0
                    ORDER BY date DESC
                ';
        $stmt3_7 = $dbh->prepare($sql3_7);
        $data3_7[] = $player_code;
        $data3_7[] = $date;
        $stmt3_7->execute($data3_7);
        $rec3_7 = $stmt3_7->fetch(PDO::FETCH_ASSOC);
        $test7_recent_value[] = $rec3_7['立ち幅跳び'];
        if ($rec3_7['date'] != $date) {
            $test7_recent_value[] = $rec3_7['立ち幅跳び'];
        } else {
            $rec3_7 = $stmt3_7->fetch(PDO::FETCH_ASSOC);
            $test7_recent_value[] = $rec3_7['立ち幅跳び'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test7_recent_value[$i] == '') {
                    $test7_recent_score[] = NULL;
                    break;
                }
                if ($test7_recent_value[$i] <= 220 + (10 * $j)) {
                    $test7_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test7_recent_value[$i] > 300) {
                $test7_recent_score[] = 10;
            }
        }

        $sql3_8 = '
                    SELECT date, メディシンボール投げ
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND メディシンボール投げ > 0
                    ORDER BY date DESC
                ';
        $stmt3_8 = $dbh->prepare($sql3_8);
        $data3_8[] = $player_code;
        $data3_8[] = $date;
        $stmt3_8->execute($data3_8);
        $rec3_8 = $stmt3_8->fetch(PDO::FETCH_ASSOC);
        $test8_recent_value[] = $rec3_8['メディシンボール投げ'];
        if ($rec3_8['date'] != $date) {
            $test8_recent_value[] = $rec3_8['メディシンボール投げ'];
        } else {
            $rec3_8 = $stmt3_8->fetch(PDO::FETCH_ASSOC);
            $test8_recent_value[] = $rec3_8['メディシンボール投げ'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test8_recent_value[$i] == '') {
                    $test8_recent_score[] = NULL;
                    break;
                }
                if ($test8_recent_value[$i] <= 12 + (1 * $j)) {
                    $test8_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test8_recent_value[$i] > 20) {
                $test8_recent_score[] = 10;
            }
        }

        $sql3_9 = '
                    SELECT date, 垂直飛び
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND 垂直飛び > 0
                    ORDER BY date DESC
                ';
        $stmt3_9 = $dbh->prepare($sql3_9);
        $data3_9[] = $player_code;
        $data3_9[] = $date;
        $stmt3_9->execute($data3_9);
        $rec3_9 = $stmt3_9->fetch(PDO::FETCH_ASSOC);
        $test9_recent_value[] = $rec3_9['垂直飛び'];
        if ($rec3_9['date'] != $date) {
            $test9_recent_value[] = $rec3_9['垂直飛び'];
        } else {
            $rec3_9 = $stmt3_9->fetch(PDO::FETCH_ASSOC);
            $test9_recent_value[] = $rec3_9['垂直飛び'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test9_recent_value[$i] == '') {
                    $test9_recent_score[] = NULL;
                    break;
                }
                if ($test9_recent_value[$i] <= 45 + (5 * $j)) {
                    $test9_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test9_recent_value[$i] > 85) {
                $test9_recent_score[] = 10;
            }
        }

        $sql3_10 = '
                    SELECT date, 背筋力
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND 背筋力 > 0
                    ORDER BY date DESC
                ';
        $stmt3_10 = $dbh->prepare($sql3_10);
        $data3_10[] = $player_code;
        $data3_10[] = $date;
        $stmt3_10->execute($data3_10);
        $rec3_10 = $stmt3_10->fetch(PDO::FETCH_ASSOC);
        $test10_recent_value[] = $rec3_10['背筋力'];
        if ($rec3_10['date'] != $date) {
            $test10_recent_value[] = $rec3_10['背筋力'];
        } else {
            $rec3_10 = $stmt3_10->fetch(PDO::FETCH_ASSOC);
            $test10_recent_value[] = $rec3_10['背筋力'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test10_recent_value[$i] == '') {
                    $test10_recent_score[] = NULL;
                    break;
                }
                if ($test10_recent_value[$i] <= 110 + (10 * $j)) {
                    $test10_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test10_recent_value[$i] > 190) {
                $test10_recent_score[] = 10;
            }
        }

        $sql3_11 = '
                    SELECT date, 握力
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND 握力 > 0
                    ORDER BY date DESC
                ';
        $stmt3_11 = $dbh->prepare($sql3_11);
        $data3_11[] = $player_code;
        $data3_11[] = $date;
        $stmt3_11->execute($data3_11);
        $rec3_11 = $stmt3_11->fetch(PDO::FETCH_ASSOC);
        $test11_recent_value[] = $rec3_11['握力'];
        if ($rec3_11['date'] != $date) {
            $test11_recent_value[] = $rec3_11['握力'];
        } else {
            $rec3_11 = $stmt3_11->fetch(PDO::FETCH_ASSOC);
            $test11_recent_value[] = $rec3_11['握力'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test11_recent_value[$i] == '') {
                    $test11_recent_score[] = NULL;
                    break;
                }
                if ($test11_recent_value[$i] <= 30 + (5 * $j)) {
                    $test11_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test11_recent_value[$i] > 70) {
                $test11_recent_score[] = 10;
            }
        }

        $sql3_12 = '
                    SELECT date, サイドステップ
                    FROM phisical_test_record 
                    WHERE player_code = ? AND date <= ? AND サイドステップ > 0
                    ORDER BY date DESC
                ';
        $stmt3_12 = $dbh->prepare($sql3_12);
        $data3_12[] = $player_code;
        $data3_12[] = $date;
        $stmt3_12->execute($data3_12);
        $rec3_12 = $stmt3_12->fetch(PDO::FETCH_ASSOC);
        $test12_recent_value[] = $rec3_12['サイドステップ'];
        if ($rec3_12['date'] != $date) {
            $test12_recent_value[] = $rec3_12['サイドステップ'];
        } else {
            $rec3_12 = $stmt3_12->fetch(PDO::FETCH_ASSOC);
            $test12_recent_value[] = $rec3_12['サイドステップ'];
        }

        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($test12_recent_value[$i] == '') {
                    $test12_recent_score[] = NULL;
                    break;
                }
                if ($test12_recent_value[$i] <= 30 + (5 * $j)) {
                    $test12_recent_score[] = $j + 1;
                    break;
                }
            }
            if ($test12_recent_value[$i] > 70) {
                $test12_recent_score[] = 10;
            }
        }

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }


    $json_test1_recent_score = json_encode($test1_recent_score);
    $json_test2_recent_score = json_encode($test2_recent_score);
    $json_test3_recent_score = json_encode($test3_recent_score);
    $json_test4_recent_score = json_encode($test4_recent_score);
    $json_test5_recent_score = json_encode($test5_recent_score);
    $json_test6_recent_score = json_encode($test6_recent_score);
    $json_test7_recent_score = json_encode($test7_recent_score);
    $json_test8_recent_score = json_encode($test8_recent_score);
    $json_test9_recent_score = json_encode($test9_recent_score);
    $json_test10_recent_score = json_encode($test10_recent_score);
    $json_test11_recent_score = json_encode($test11_recent_score);
    $json_test12_recent_score = json_encode($test12_recent_score);


    print '<table border=1>';
    print '<tr><th>日付</th> <th>10m走</th> <th>20m走</th> <th>30m走</th>';
    print '<th>50m走</th> <th>1500m走</th> <th>プロアジリティ</th>';
    print '<th>立ち幅跳び</th> <th>メディシンボール投げ</th> <th>垂直飛び</th>';
    print '<th>背筋力</th> <th>握力</th> <th>サイドステップ</th></tr>';

    for ($i = 0; $i < 3; $i++) {
        print '<tr><th>' . $date_arr[$i] . '</th> <th>' . $test1_value[$i] . '</th>';
        print '<th>' . $test2_value[$i] . '</th>';
        print '<th>' . $test3_value[$i] . '</th> <th>' . $test4_value[$i] . '</th>';
        print '<th>' . $test5_value[$i] . '</th>';
        print '<th>' . $test6_value[$i] . '</th> <th>' . $test7_value[$i] . '</th>';
        print '<th>' . $test8_value[$i] . '</th> <th>' . $test9_value[$i] . '</th>';
        print '<th>' . $test10_value[$i] . '</th> <th>' . $test11_value[$i] . '</th>';
        print '<th>' . $test12_value[$i] . '</th></tr>';
    }

    print '</table>';


    ?>

    <!-- レーダーチャート -->
    <canvas id="myRaderChart"></canvas>
    　
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

    <script>
        let ctx1 = document.getElementById("myRaderChart");

        // phpの配列をjavascriptで受け取る
        let js_test1_recent_score = <?php print $json_test1_recent_score; ?>;
        let js_test2_recent_score = <?php print $json_test2_recent_score; ?>;
        let js_test3_recent_score = <?php print $json_test3_recent_score; ?>;
        let js_test4_recent_score = <?php print $json_test4_recent_score; ?>;
        let js_test5_recent_score = <?php print $json_test5_recent_score; ?>;
        let js_test6_recent_score = <?php print $json_test6_recent_score; ?>;
        let js_test7_recent_score = <?php print $json_test7_recent_score; ?>;
        let js_test8_recent_score = <?php print $json_test8_recent_score; ?>;
        let js_test9_recent_score = <?php print $json_test9_recent_score; ?>;
        let js_test10_recent_score = <?php print $json_test10_recent_score; ?>;
        let js_test11_recent_score = <?php print $json_test11_recent_score; ?>;
        let js_test12_recent_score = <?php print $json_test12_recent_score; ?>;

        let myRadarChart = new Chart(ctx1, {
            type: 'radar',
            data: {
                labels: ["10m走", "20m走", "30m走", "50m走", "1500m走", "プロアジリティ", "立ち幅跳び", "メディシンボール投げ", "垂直飛び", "背筋力", "握力", "サイドステップ"],
                datasets: [{
                    label: '今回',
                    data: [js_test1_recent_score[0], js_test2_recent_score[0], js_test3_recent_score[0],
                        js_test4_recent_score[0], js_test5_recent_score[0], js_test6_recent_score[0],
                        js_test7_recent_score[0], js_test8_recent_score[0], js_test9_recent_score[0],
                        js_test10_recent_score[0], js_test11_recent_score[0], js_test12_recent_score[0]
                    ],
                    backgroundColor: 'RGBA(225,95,150, 0.5)',
                    borderColor: 'RGBA(225,95,150, 1)',
                    borderWidth: 1,
                    pointBackgroundColor: 'RGB(46,106,177)'
                }, {
                    label: '前回',
                    data: [js_test1_recent_score[1], js_test2_recent_score[1], js_test3_recent_score[1],
                        js_test4_recent_score[1], js_test5_recent_score[1], js_test6_recent_score[1],
                        js_test7_recent_score[1], js_test8_recent_score[1], js_test9_recent_score[1],
                        js_test11_recent_score[1], js_test11_recent_score[1], js_test12_recent_score[1]
                    ],
                    backgroundColor: 'RGBA(115,255,25, 0.5)',
                    borderColor: 'RGBA(115,255,25, 1)',
                    borderWidth: 1,
                    pointBackgroundColor: 'RGB(46,106,177)'
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'フィジカルテスト'
                },
                scale: {
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 10,
                        stepSize: 1,
                        callback: function(value, index, values) {
                            return value + '点'
                        }
                    }
                }
            }
        });
    </script>

    <br><br>
    <input type="button" onclick="location.href='p_phisical_test_content.php'" value="戻る">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=10m走'" value="10m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=20m走'" value="20m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=30m走'" value="30m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=50m走'" value="50m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=1500m走'" value="1500m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=プロアジリティ'" value="プロアジリティ">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=立ち幅跳び'" value="立ち幅跳び">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=メディシンボール投げ'" value="メディシンボール投げ">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=垂直飛び'" value="垂直飛び">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=背筋力'" value="背筋力">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=握力'" value="握力">
    <input type="button" onclick="location.href='p_phisical_test_graph_test.php?test=サイドステップ'" value="サイドステップ">


</body>

</html>