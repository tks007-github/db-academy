<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="../p_top/p_top_login.html">ログイン画面へ</a>';
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
    <title>p_phisical_test_result</title>
</head>

<body>

    <h3>フィジカルテスト成績表</h3>

    <?php

    // player_codeとbelong_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];
    $belong_code = $_SESSION['belong_code'];

    // p_phisical_test_topからの情報をSESSIONで受け取る
    $date = $_SESSION['date'];

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
                    SELECT phisical_test_record_code, 10m走, 20m走, 30m走, 50m走, 1500m走_min, 1500m走_sec,  
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
                if ($rec3 == '') {
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
                    $test5_value[] = $rec2['1500m走_min'] . '分' . $rec2['1500m走_sec'] . '秒';
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

        // db_academyデータベースから切断する
        $dbh = null;

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

        
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>



</body>

</html>