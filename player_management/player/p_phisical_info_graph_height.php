<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['login'])) {
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
            max-width: 400px;
            max-height: 300px;
            border: solid 1px #888;
        }
    </style>
</head>

<body>

    <h3>グラフ</h3>
    <br>

    <canvas id="canvas"></canvas>
    <script>
        let canvas = document.getElementById("canvas");

        let myLineChart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G'],
                datasets: [{
                        label: '系列1',
                        data: [1, 2, 3, 4, 5, 6, 7],
                        borderColor: "rgba(255,0,0,1)",
                        backgroundColor: "rgba(0,0,0,0)"
                    },
                    {
                        label: '系列2',
                        data: [1, 2, 4, 8, 16, 32, 64],
                        borderColor: "rgba(0,0,255,1)",
                        backgroundColor: "rgba(0,0,0,0)"
                    }
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
    <input type="button" onclick="location.href='p_phisical_info_graph.php'" value="戻る">

</body>

</html>