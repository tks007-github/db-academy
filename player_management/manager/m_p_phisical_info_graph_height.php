<?php
    session_start();
    session_regenerate_id(true);
    if (!isset($_SESSION['m_login'])) {
        print 'ログインされていません。<br>';
        print '<a href="m_login.html">ログイン画面へ</a>';
        exit();
    } else {
        $p_code = $_SESSION['p_code'];
        print $_SESSION['m_code'];
        print 'さんログイン中<br>';
        print '（検索条件：' . $_SESSION['p_code'] . '）';
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
    <title>Manager</title>
    <style>
        canvas {
            max-width: 400px;
            max-height: 300px;
            border: solid 1px #888;
        }
    </style>
</head>

<body>

    <h3>身長のグラフ</h3>
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
                SELECT date, height 
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
            $height[] = $rec['height'];
        }
        $json_date = json_encode($date);
        $json_height = json_encode($height);

    } catch (Exception $e) {
        exit();
    }
    ?>

    <canvas id="canvas"></canvas>
    <script>
        let canvas = document.getElementById("canvas");

        // phpの配列をjavascriptで受け取る
        let js_date = <?php print $json_date; ?>;
        let js_height = <?php print $json_height; ?>;

        let myLineChart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: [js_date[0], js_date[1], js_date[2], js_date[3], js_date[4]],
                datasets: [{
                        label: '身長',
                        data: [js_height[0], js_height[1], js_height[2], js_height[3], js_height[4]],
                        borderColor: "rgba(255,0,0,1)",
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
                            suggestedMax: 70,
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
    <input type="button" onclick="location.href='m_p_phisical_info_graph.php'" value="戻る">

</body>

</html>