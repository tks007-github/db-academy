<html lang="ja">

<head>
  <meta charset="utf-8">
　<title>グラフ</title> 
</head>
<body>
  <h1>レーダーチャート</h1>
  <canvas id="myRaderChart"></canvas>
  <!-- CDN -->
　<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

  <script>
    var ctx = document.getElementById("myRaderChart");
    var myRadarChart = new Chart(ctx, {
        type: 'radar', 
        data: { 
            labels: ["英語", "数学"],
            datasets: [{
                label: 'Aさん',
                data: [92, 72],
                backgroundColor: 'RGBA(225,95,150, 0.5)',
                borderColor: 'RGBA(225,95,150, 1)',
                borderWidth: 1,
                pointBackgroundColor: 'RGB(46,106,177)'
            }]
        },
        options: {
            title: {
                display: true,
                text: '試験成績'
            },
            scale:{
                ticks:{
                    suggestedMin: 0,
                    suggestedMax: 100,
                    stepSize: 10,
                    callback: function(value, index, values){
                        return  value +  '点'
                    }
                }
            }
        }
    });
    </script>
</body>
</html>