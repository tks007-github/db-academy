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

    <h3>フィジカルテストのグラフ</h3>
    <br>

    <?php

    // p_phisical_test_content.phpから渡された値をサニタイズ
    $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
    $test_id = htmlspecialchars($_GET['test_id'], ENT_QUOTES, 'UTF-8');

    try {
        // player_managementデータベースに接続する
        $dsn = 'mysql:dbname=player_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_test_recordテーブルからIDを使って情報を検索
        $sql = '
                SELECT *
                FROM phisical_test_record
                WHERE id = ?
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $id;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        // 取得した内容を変数で保持
        $date = $rec['date'];
        $test_value[] = $rec['test1'];
        $test_value[] = $rec['test2'];
        $test_value[] = $rec['test3'];

        // phisical_test_itemテーブルから項目名を検索
        $sql2 = '
                SELECT test_value 
                FROM phisical_test_item 
                ORDER BY test_code
                ';
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->execute();

        // phisical_testテーブルからIDを使って情報を検索
        $sql3 = '
                SELECT test1, test2, test3
                FROM phisical_test
                WHERE id = ?
                ';
        $stmt3 = $dbh->prepare($sql3);
        $data3[] = $test_id;
        $stmt3->execute($data3);
        $rec3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        // 取得した内容を変数で保持
        $test_result[] = $rec3['test1'];
        $test_result[] = $rec3['test2'];
        $test_result[] = $rec3['test3'];

        // player_managementデータベースから切断する
        $dbh = null;

        $labels_js = '[';
        $data_js = '[';
        for ($i = 0; $i < 3; $i++) {
            if ($test_value[$i]) {
                $rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                $labels_js = $labels_js . '"' . $rec2["test_value"] . '",';
                $data_js = $data_js . '"' . $test_result[$i] . '",';
            }
        }
        $labels_js = $labels_js . ']';
        $data_js = $data_js . ']';

    } catch (Exception $e) {
        exit();
    }
    ?>

<canvas id="myRaderChart"></canvas>
  <!-- CDN -->
　<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

  <script>
    var ctx = document.getElementById("myRaderChart");
    var myRadarChart = new Chart(ctx, {
        type: 'radar', 
        data: { 
            labels: <?php print $labels_js; ?>,
            datasets: [{
                label: '結果',
                data: <?php print $data_js; ?>,
                backgroundColor: 'RGBA(225,95,150, 0.5)',
                borderColor: 'RGBA(225,95,150, 1)',
                borderWidth: 1,
                pointBackgroundColor: 'RGB(46,106,177)'
            }]
        },
        options: {
            title: {
                display: true,
                text: 'フィジカルテスト'
            },
            scale:{
                ticks:{
                    suggestedMin: 0,
                    suggestedMax: 10,
                    stepSize: 1,
                    // callback: function(value, index, values){
                    //     return  value +  '点'
                    // }
                }
            }
        }
    });
    </script>

    <br><br>
    <input type="button" onclick="location.href='p_phisical_test.php'" value="戻る">

</body>

</html>