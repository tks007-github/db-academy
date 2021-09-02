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
    <title>p_phisical_info_graph_muscle_mass</title>

    <style>
        canvas {
            max-width: 600px;
            max-height: 400px;
            border: solid 1px #888;
        }
    </style>

</head>

<body>

    <h3>身体情報グラフ(筋量)</h3>

    <?php
    // player_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];

    try {
        date_default_timezone_set('Asia/Tokyo');
        // 現在の年(西暦)を取得
        $current_year = date('Y');
        // 現在の月を取得
        $current_month = date('m');

        if ($current_month < 4) {
            // 今年度の4月(2021年2月の場合→202004)
            $this_year_month_start1 = ($current_year - 1) . '04';
            $this_year_month_start2 = ($current_year) . '01';
            // 昨年度の4月
            $last_year_month_start1 = ($current_year - 2) . '04';
            $last_year_month_start2 = ($current_year - 1) . '01';
        } else {
            // 今年度の4月(2021年8月の場合→202104)
            $this_year_month_start1 = $current_year . '04';
            $this_year_month_start2 = ($current_year + 1) . '01';
            // 昨年度の4月
            $last_year_month_start1 = ($current_year - 1) . '04';
            $last_year_month_start2 = $current_year . '01';
        }

        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルからplayer_codeを使って過去1年間の月平均のデータを検索
        $this_year_avg_muscle_mass_arr = [];
        $last_year_avg_muscle_mass_arr = [];

        // 今年分(4月～12月)
        for ($i = 0; $i < 9; $i++) {
            $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(muscle_mass) AS grouping_muscle_mass
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ';
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $this_year_month_start1 + $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $this_year_avg_muscle_mass_arr[] = NULL;
            } else {
                $this_year_avg_muscle_mass_arr[] = $rec['grouping_muscle_mass'];
            }
        }
        // 今年分(1月～3月)
        for ($i = 0; $i < 3; $i++) {
            $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(muscle_mass) AS grouping_muscle_mass
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ';
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $this_year_month_start2 + $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $this_year_avg_muscle_mass_arr[] = NULL;
            } else {
                $this_year_avg_muscle_mass_arr[] = $rec['grouping_muscle_mass'];
            }
        }

        // 昨年分(4月～12月)
        for ($i = 0; $i < 9; $i++) {
            $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(muscle_mass) AS grouping_muscle_mass
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ';
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $last_year_month_start1 + $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $last_year_avg_muscle_mass_arr[] = NULL;
            } else {
                $last_year_avg_muscle_mass_arr[] = $rec['grouping_muscle_mass'];
            }
        }
        // 昨年分(1月～3月)
        for ($i = 0; $i < 3; $i++) {
            $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(muscle_mass) AS grouping_muscle_mass
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ';
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $last_year_month_start2 + $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $last_year_avg_muscle_mass_arr[] = NULL;
            } else {
                $last_year_avg_muscle_mass_arr[] = $rec['grouping_muscle_mass'];
            }
        }

        // db_academyデータベースから切断する
        $dbh = null;

        $json_this_year_muscle_mass = json_encode($this_year_avg_muscle_mass_arr);
        $json_last_year_muscle_mass = json_encode($last_year_avg_muscle_mass_arr);
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }
    ?>

    <canvas id="canvas"></canvas>
    <script>
        let canvas = document.getElementById("canvas");

        // phpの配列をjavascriptで受け取る
        let js_this_year_muscle_mass = <?php print $json_this_year_muscle_mass; ?>;
        let js_last_year_muscle_mass = <?php print $json_last_year_muscle_mass; ?>;

        let myLineChart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['4月', '5月', '6月', '7月', '8月', '9月', '10月',
                        '11月', '12月', '1月', '2月', '3月'
                ],
                datasets: [{
                    label: '今年度',
                    data: [js_this_year_muscle_mass[0], js_this_year_muscle_mass[1], js_this_year_muscle_mass[2],
                        js_this_year_muscle_mass[3], js_this_year_muscle_mass[4], js_this_year_muscle_mass[5],
                        js_this_year_muscle_mass[6], js_this_year_muscle_mass[7], js_this_year_muscle_mass[8],
                        js_this_year_muscle_mass[9], js_this_year_muscle_mass[10], js_this_year_muscle_mass[11]
                    ],
                    borderColor: "rgba(0,0,255,1)",
                    backgroundColor: "rgba(0,0,0,0)",
                    spanGaps: true,
                },
                {
                    label: '昨年度',
                    data: [js_last_year_muscle_mass[0], js_last_year_muscle_mass[1], js_last_year_muscle_mass[2],
                        js_last_year_muscle_mass[3], js_last_year_muscle_mass[4], js_last_year_muscle_mass[5],
                        js_last_year_muscle_mass[6], js_last_year_muscle_mass[7], js_last_year_muscle_mass[8],
                        js_last_year_muscle_mass[9], js_last_year_muscle_mass[10], js_last_year_muscle_mass[11]
                    ],
                    borderColor: "rgba(255,0,0,1)",
                    backgroundColor: "rgba(0,0,0,0)",
                    spanGaps: true,
                },
             ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: '筋量(kg)'
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
    <input type="button" onclick="location.href='p_phisical_info_top.php'" value="戻る">
    <input type="button" onclick="location.href='p_phisical_info_graph_height.php'" value="身長">
    <input type="button" onclick="location.href='p_phisical_info_graph_weight.php'" value="体重">
    <input type="button" onclick="location.href='p_phisical_info_graph_body_fat.php'" value="体脂肪率">

</body>

</html>