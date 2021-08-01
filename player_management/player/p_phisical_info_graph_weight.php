<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="p_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['p_code'];
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
    <title>Player</title>
    <style>
        canvas {
            max-width: 800px;
            max-height: 600px;
            border: solid 1px #888;
        }
    </style>
</head>

<body>

    <h3>体重のグラフ</h3>
    <br>

    <?php
    try {
        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルから会員コードを使って情報を検索
        $sql = '
                SELECT date, weight 
                FROM phisical_info 
                WHERE player_code = ?
                ORDER BY date
                ';
        $stmt = $dbh->prepare($sql);
        $data[0] = $_SESSION['p_code'];
        $stmt->execute($data);

        // player_managementデータベースから切断する
        $dbh = null;

        for ($i = 0; $i < 5; $i++) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $date[] = $rec['date'];
            $weight[] = $rec['weight'];
        }
        $json_date = json_encode($date);
        $json_weight = json_encode($weight);

    } catch (Exception $e) {
        exit();
    }
    ?>

    <canvas id="canvas"></canvas>
    <script>
        let canvas = document.getElementById("canvas");

        // phpの配列をjavascriptで受け取る
        let js_date = <?php print $json_date; ?>;
        let js_weight = <?php print $json_weight; ?>;

        let myLineChart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: [js_date[0], js_date[1], js_date[2], js_date[3], js_date[4]],
                datasets: [{
                        label: '体重',
                        data: [js_weight[0], js_weight[1], js_weight[2], js_weight[3], js_weight[4]],
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
                            suggestedMax: 80,
                            suggestedMin: 40,
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
    <input type="button" onclick="location.href='p_phisical_info_graph.php'" value="戻る">

</body>

</html>