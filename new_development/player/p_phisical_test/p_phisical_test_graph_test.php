<!-- 
    10m走、20m走、30m走、50m走、1500m走、プロアジリティ、立ち幅跳び、メディシンボール投げ、
    垂直飛び、背筋力、握力、サイドステップのグラフを表示する。
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
    <title>p_phisical_test_graph_test.php</title>
</head>

<style>
    canvas {
        max-width: 600px;
        max-height: 400px;
        border: solid 1px #888;
    }
</style>

<body>

    <h3>フィジカルテストグラフ</h3>

    <?php

    // player_codeとbelong_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];
    $belong_code = $_SESSION['belong_code'];

    // p_phisical_test_topからの情報をSESSIONで受け取る
    $date = $_SESSION['date'];

    // 自作の関数を呼び出す
    require_once('../../function/function.php');

    // テストコードを受け取る
    // getの中身をすべてサニタイズする
    $get = sanitize($_GET);
    // p_phisical_test_resultからtestをGETで受け取る
    $test = $get['test'];

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
        if ($test != '1500m走') {       // 1500m走以外の場合
            $sql2 = '
                    SELECT ' . $test . '
                    FROM phisical_test_record 
                    WHERE player_code = ?
                    AND date <= ?
                    AND ' . $test . ' > 0
                ';
            $stmt2 = $dbh->prepare($sql2);
            $data2[0] = $player_code;
            $data2[1] = $date;
            $stmt2->execute($data2);
            for ($i = 0; $i < 3; $i++) {
                $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($rec2 == '') {
                    $test_value[] = NULL;
                } else {
                    $test_value[] = $rec2[$test];
                }
            }
        } else {                        // 1500m走の場合
            $sql2 = '
                    SELECT 1500m走_min, 1500m走_sec 
                    FROM phisical_test_record 
                    WHERE player_code = ?
                    AND date <= ?
                    AND 1500m走_min > 0
                    AND 1500m走_sec > 0
                ';
            $stmt2 = $dbh->prepare($sql2);
            $data2[0] = $player_code;
            $data2[1] = $date;
            $stmt2->execute($data2);
            for ($i = 0; $i < 3; $i++) {
                $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($rec2 == '') {
                    $test_value[] = NULL;
                } else {
                    $test_value[] = $rec2['1500m走_min'] * 60 + $rec2['1500m走_sec'];
                }
            }
        }

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    $json_test = json_encode($test);
    $json_test_value = json_encode($test_value);

    ?>

    <canvas id="canvas"></canvas>
    <script>
        let canvas = document.getElementById("canvas");

        // phpの変数をjavascriptで受け取る
        let js_test = <?php print $json_test; ?>;
        // phpの配列をjavascriptで受け取る
        let js_test_value = <?php print $json_test_value; ?>;

        // 連想配列を用意(グラフの名前)
        let graph_name = {"10m走": "10m走(秒)", "20m走": "20m走(秒)", "30m走": "30m走(秒)", "50m走": "50m走(秒)",
                          "1500m走": "1500m走(秒)", "プロアジリティ": "プロアジリティ(秒)", "立ち幅跳び": "立ち幅跳び(cm)",
                          "メディシンボール投げ": "メディシンボール投げ(m)", "垂直飛び": "垂直飛び(cm)", "背筋力": "背筋力(kg)",
                          "握力": "握力(kg)", "サイドステップ": "サイドステップ(回)"};

        let myLineChart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['前々回', '前回', '今回'],
                datasets: [{
                    label: '',
                    data: [js_test_value[2], js_test_value[1], js_test_value[0]],
                    borderColor: "rgba(255,0,0,1)",
                    backgroundColor: "rgba(0,0,0,0)",
                    spanGaps: true,
                }, ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: graph_name[js_test],
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
    <input type="button" onclick="location.href='p_phisical_test_result.php'" value="戻る">
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