<!-- 
    身長(height)、体重(weight)、体脂肪率(body_fat)、筋量(muscle_mass)のグラフを表示する。
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません<br>';
    print '<a href="../p_top/p_top_login.php">ログイン画面へ</a>';
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
    <title>p_phisical_info_graph.php</title>

    <style>
        canvas {
            max-width: 600px;
            max-height: 400px;
            border: solid 1px #888;
        }
    </style>

</head>

<body>

    <h3>身体情報グラフ</h3>

    <?php
    // player_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];

    // 自作の関数を呼び出す
    require_once('../../function/function.php');

    // グラフコードを受け取る
    // getの中身をすべてサニタイズする
    $get = sanitize($_GET);
    // p_phisical_info_topからgraphをGETで受け取る
    $graph = $get['graph'];

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

    // phisical_infoテーブルからplayer_codeを使って過去1年間の月平均のデータを検索
    $this_year_avg_arr = [];
    $last_year_avg_arr = [];


    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL文は共通なのでここで準備
        $sql = '
                SELECT DATE_FORMAT(date, \'%Y%m\') AS grouping_date, 
                AVG(' . $graph . ') AS grouping_' . $graph .'
                FROM phisical_info
                WHERE player_code = ?
                GROUP BY grouping_date
                HAVING grouping_date = ?
                ';

        // 今年分(4月～12月)
        for ($i = 0; $i < 9; $i++) {
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $this_year_month_start1 + $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $this_year_avg_arr[] = NULL;
            } else {
                $this_year_avg_arr[] = $rec['grouping_' . $graph];
            }
        }
        // 今年分(1月～3月)
        for ($i = 0; $i < 3; $i++) {
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $this_year_month_start2 + $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $this_year_avg_arr[] = NULL;
            } else {
                $this_year_avg_arr[] = $rec['grouping_' . $graph];
            }
        }

        // 昨年分(4月～12月)
        for ($i = 0; $i < 9; $i++) {
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $last_year_month_start1 + $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $last_year_avg_arr[] = NULL;
            } else {
                $last_year_avg_arr[] = $rec['grouping_' . $graph];
            }
        }
        // 昨年分(1月～3月)
        for ($i = 0; $i < 3; $i++) {
            $stmt = $dbh->prepare($sql);
            $data[0] = $player_code;
            $data[1] = $last_year_month_start2 + $i;
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec == '') {
                $last_year_avg_arr[] = NULL;
            } else {
                $last_year_avg_arr[] = $rec['grouping_' . $graph];
            }
        }

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }


    $json_graph = json_encode($graph);
    $json_this_year = json_encode($this_year_avg_arr);
    $json_last_year = json_encode($last_year_avg_arr);

    ?>

    <canvas id="canvas"></canvas>
    <script>
        let canvas = document.getElementById("canvas");

        // phpの変数をjavascriptで受け取る
        let js_graph = <?php print $json_graph; ?>;
        // phpの配列をjavascriptで受け取る
        let js_this_year = <?php print $json_this_year; ?>;
        let js_last_year = <?php print $json_last_year; ?>;

        // 連想配列を用意(グラフの名前)
        let graph_name = {height: "身長(cm)", weight: "体重(kg)", body_fat: "体脂肪率(%)", muscle_mass: "筋量(kg)"};

        let myLineChart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['4月', '5月', '6月', '7月', '8月', '9月', '10月',
                    '11月', '12月', '1月', '2月', '3月'
                ],
                datasets: [{
                        label: '今年度',
                        data: [js_this_year[0], js_this_year[1], js_this_year[2],
                            js_this_year[3], js_this_year[4], js_this_year[5],
                            js_this_year[6], js_this_year[7], js_this_year[8],
                            js_this_year[9], js_this_year[10], js_this_year[11]
                        ],
                        borderColor: "rgba(0,0,255,1)",
                        backgroundColor: "rgba(0,0,0,0)",
                        spanGaps: true,
                    },
                    {
                        label: '昨年度',
                        data: [js_last_year[0], js_last_year[1], js_last_year[2],
                            js_last_year[3], js_last_year[4], js_last_year[5],
                            js_last_year[6], js_last_year[7], js_last_year[8],
                            js_last_year[9], js_last_year[10], js_last_year[11]
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
                        text: graph_name[js_graph],
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            max: 180,
                            min: 170,
                            stepSize: 1,
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
    <input type="button" onclick="location.href='p_phisical_info_graph.php?graph=height'" value="身長">
    <input type="button" onclick="location.href='p_phisical_info_graph.php?graph=weight'" value="体重">
    <input type="button" onclick="location.href='p_phisical_info_graph.php?graph=body_fat'" value="体脂肪率">
    <input type="button" onclick="location.href='p_phisical_info_graph.php?graph=muscle_mass'" value="筋量">

</body>

</html>