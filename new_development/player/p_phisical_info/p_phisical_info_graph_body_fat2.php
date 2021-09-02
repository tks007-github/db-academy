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
    <title>p_phisical_info_graph_body_fat</title>

    <style>
        canvas {
            max-width: 600px;
            max-height: 400px;
            border: solid 1px #888;
        }
    </style>

</head>

<body>

    <h3>身体情報グラフ(体脂肪率)</h3>

    <?php
    // player_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];

    try {
        date_default_timezone_set('Asia/Tokyo');
        // 現在の年(西暦)を取得
        $current_year = date('Y');
        // 現在の月を取得
        $current_month = date('m');
        // 現在の年と月を結合(例. 2021年08月 → 202108)
        $year_month = $current_year . $current_month;

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルからplayer_codeを使って過去1年間の月平均のデータを検索
        $year_month_arr = [];
        $avg_body_fat_arr = [];

        // 今年分
        for ($i = 0; $i < $current_month; $i++) {
            $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(body_fat) AS grouping_body_fat
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ';
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $year_month - $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $year_month_arr[] = $current_year . '/' . ($current_month - $i);
                $avg_body_fat_arr[] = 0;
            } else {
                $year_month_arr[] = $current_year . '/' . ($current_month - $i);
                $avg_body_fat_arr[] = $rec['grouping_body_fat'];
            }
        }

        // 去年分
        $year_month = ($current_year - 1) . 12;
        for ($i = 0; $i < (12 - $current_month); $i++) {
            $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(body_fat) AS grouping_body_fat
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ';
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $year_month - $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $year_month_arr[] = ($current_year - 1) . '/' . (12 - $i);
                $avg_body_fat_arr[] = 0;
            } else {
                $year_month_arr[] = ($current_year - 1) . '/' . (12 - $i);
                $avg_body_fat_arr[] = $rec['grouping_body_fat'];
            }
        }

        // db_academyデータベースから切断する
        $dbh = null;

        $json_date = json_encode($year_month_arr);
        $json_body_fat = json_encode($avg_body_fat_arr);

    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

<canvas id="canvas"></canvas>
    <script>
        let canvas = document.getElementById("canvas");

        // phpの配列をjavascriptで受け取る
        let js_date = <?php print $json_date; ?>;
        let js_body_fat = <?php print $json_body_fat; ?>;

        let myLineChart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: [js_date[11], js_date[10], js_date[9], 
                            js_date[8], js_date[7], js_date[6], 
                            js_date[5], js_date[4], js_date[3], 
                            js_date[2], js_date[1], js_date[0]],
                datasets: [{
                        label: '体脂肪率',
                        data: [js_body_fat[11], js_body_fat[10], js_body_fat[9], 
                                js_body_fat[8], js_body_fat[7], js_body_fat[6], 
                                js_body_fat[5], js_body_fat[4], js_body_fat[3], 
                                js_body_fat[2], js_body_fat[1], js_body_fat[0]],
                        borderColor: "rgba(0,0,255,1)",
                        backgroundColor: "rgba(0,0,0,0)"
                    },
                ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: '折れ線グラフ'
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMax: 50,
                            suggestedMin: 0,
                            stepSize: 5,
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
    <input type="button" onclick="location.href='p_phisical_info_top.php'" value="戻る">
    <input type="button" onclick="location.href='p_phisical_info_graph_height.php'" value="身長">
    <input type="button" onclick="location.href='p_phisical_info_graph_weight.php'" value="体重">
    <input type="button" onclick="location.href='p_phisical_info_graph_muscle_mass.php'" value="筋量">

</body>

</html>