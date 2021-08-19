<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_phisical_test_result</title>
</head>

<body>

    B0001さんログイン中
    <br><br>

    <h3>フィジカルテスト成績表</h3>

    <script type="text/javascript">
        function printWeb() {
            print();
        }
    </script>

    <div>
        <input type="button" value="印刷" onClick="printWeb()">　　
    </div>

    <br><br><br>

    <!-- 表 -->
    <table border="1">
        <tr>
            <th>項目</th>
            <th>今回　</th>
            <th>前回　</th>
            <th>前々回</th>
        </tr>
        <tr>
            <td>10m走</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>20m走</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>30m走</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>50m走</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>1500m走</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>プロアジリティ</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>立ち幅跳び</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>メディシンボール投げ</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>垂直飛び</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>背筋力</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>握力</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
        <tr>
            <td>サイドステップ</td>
            <td>8</td>
            <td>6</td>
            <td>4</td>
        </tr>
    </table>

    <br><br>

    <!-- レーダーチャート -->
    <canvas id="myRaderChart"></canvas>
    　
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

    <script>
        let ctx1 = document.getElementById("myRaderChart");
        let myRadarChart = new Chart(ctx1, {
            type: 'radar',
            data: {
                labels: ["10m走", "20m走", "30m走", "50m走", "1500m走", "プロアジリティ", "立ち幅跳び", "メディシンボール投げ", "垂直飛び", "背筋力", "握力", "サイドステップ"],
                datasets: [{
                    label: '今回',
                    data: [8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8, 8],
                    backgroundColor: 'RGBA(225,95,150, 0.5)',
                    borderColor: 'RGBA(225,95,150, 1)',
                    borderWidth: 1,
                    pointBackgroundColor: 'RGB(46,106,177)'
                }, {
                    label: '前回',
                    data: [6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6],
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
                        callback: function (value, index, values) {
                            return value + '点'
                        }
                    }
                }
            }
        });
    </script>


    <!-- 折れ線グラフ -->
    <canvas id="myLineChart"></canvas>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

    <script>
        let ctx2 = document.getElementById("myLineChart");
        let myLineChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['前々回', '前回', '今回'],
                datasets: [
                    {
                        label: '50m走',
                        data: [4, 6, 8],
                        borderColor: "rgba(255,0,0,1)",
                        backgroundColor: "rgba(0,0,0,0)"
                    },
                    {
                        label: '10m走',
                        data: [3, 5, 7],
                        borderColor: "rgba(0,0,255,1)",
                        backgroundColor: "rgba(0,0,0,0)"
                    }
                ],
            },
            options: {
                title: {
                    display: true,
                    text: '走力'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMax: 10,
                            suggestedMin: 0,
                            stepSize: 1,
                            callback: function (value, index, values) {
                                return value
                            }
                        }
                    }]
                },
            }
        });
    </script>

    <br>
    <a href="p_phisical_test_content.html">戻る(ボタン)</a>

    <br><br><br>
    <説明><br>
        フィジカルテストの成績出力画面です。<br>

</body>

</html>