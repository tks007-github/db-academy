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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
    <title>p_phisical_test_graph_test1</title>
</head>

<style>
    canvas {
        max-width: 600px;
        max-height: 400px;
        border: solid 1px #888;
    }
</style>

<body>

    <h3>フィジカルテスト成績表(10m走)</h3>

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
        $sql2 = '
                    SELECT 10m走
                    FROM phisical_test_record 
                    WHERE player_code = ?
                    AND date <= ?
                    AND 10m走 > 0
                ';
        $stmt2 = $dbh->prepare($sql2);
        $data2[0] = $player_code;
        $data2[1] = $date;
        $stmt2->execute($data2);
        for ($i = 0; $i < 3; $i++) {
            $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($rec2 == '') {
                $test1_value[] = NULL;
            } else {
                $test1_value[] = $rec2['10m走'];
            }
        }
        var_dump($test1_value);

        $json_test1_value = json_encode($test1_value);


        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    ?>

    <canvas id="canvas"></canvas>
    <script>
        let canvas = document.getElementById("canvas");

        // phpの配列をjavascriptで受け取る
        let js_test1_value = <?php print $json_test1_value; ?>;

        let myLineChart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['今回', '前回', '前々回'],
                datasets: [{
                    label: '',
                    data: [js_test1_value[0], js_test1_value[1], js_test1_value[2]],
                    borderColor: "rgba(0,0,255,1)",
                    backgroundColor: "rgba(0,0,0,0)",
                    spanGaps: true,
                }, ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: '10m走(秒)'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMax: 200,
                            suggestedMin: 0,
                            stepSize: 10,
                            callback: function(value, index, values) {
                                return value
                            }
                        }
                    }]
                },
            }
        });
    </script>


    <br><br>
    <input type="button" onclick="location.href='p_phisical_test_content.php'" value="戻る">
    <input type="button" onclick="location.href='p_phisical_test_graph_test1.php'" value="10m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test2.php'" value="20m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test3.php'" value="30m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test4.php'" value="50m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test5.php'" value="1500m走">
    <input type="button" onclick="location.href='p_phisical_test_graph_test6.php'" value="プロアジリティ">
    <input type="button" onclick="location.href='p_phisical_test_graph_test1.php'" value="立ち幅跳び">
    <input type="button" onclick="location.href='p_phisical_test_graph_test2.php'" value="メディシンボール投げ">
    <input type="button" onclick="location.href='p_phisical_test_graph_test3.php'" value="垂直飛び">
    <input type="button" onclick="location.href='p_phisical_test_graph_test4.php'" value="背筋力">
    <input type="button" onclick="location.href='p_phisical_test_graph_test5.php'" value="握力">
    <input type="button" onclick="location.href='p_phisical_test_graph_test6.php'" value="サイドステップ">


</body>

</html>