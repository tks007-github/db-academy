<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="p_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['player_name'];
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
    <title>p_phisical_test_add</title>
</head>

<body>

    <h3>フィジカルテスト登録</h3>

    <?php

    // SESSION変数の初期化
    $_SESSION['test1_value'] = '';
    $_SESSION['test2_value'] = '';
    $_SESSION['test3_value'] = '';
    $_SESSION['test4_value'] = '';
    $_SESSION['test5_1_value'] = '';
    $_SESSION['test5_2_value'] = '';
    $_SESSION['test6_value'] = '';
    $_SESSION['test7_value'] = '';
    $_SESSION['test8_value'] = '';
    $_SESSION['test9_value'] = '';
    $_SESSION['test10_value'] = '';
    $_SESSION['test11_value'] = '';
    $_SESSION['test12_value'] = '';

    // player_codeをSESSIONで受け取る
    $player_code = $_SESSION['player_code'];
    // p_phisical_test_topからの情報をSESSIONで受け取る
    $date = $_SESSION['date'];
    $test1_boolean = $_SESSION['10m走_boolean'];
    $test2_boolean = $_SESSION['20m走_boolean'];
    $test3_boolean = $_SESSION['30m走_boolean'];
    $test4_boolean = $_SESSION['50m走_boolean'];
    $test5_boolean = $_SESSION['1500m走_boolean'];
    $test6_boolean = $_SESSION['プロアジリティ_boolean'];
    $test7_boolean = $_SESSION['立ち幅跳び_boolean'];
    $test8_boolean = $_SESSION['メディシンボール投げ_boolean'];
    $test9_boolean = $_SESSION['垂直飛び_boolean'];
    $test10_boolean = $_SESSION['背筋力_boolean'];
    $test11_boolean = $_SESSION['握力_boolean'];
    $test12_boolean = $_SESSION['サイドステップ_boolean'];


    print 'フィジカルテスト結果(' . $date . ')<br><br>';
    print '<form method="post" action="p_phisical_test_add_check.php">';
    if ($test1_boolean) {
        print '10m走 <input type="text" name="10m走_value" value=""> 秒<br>';
    }
    if ($test2_boolean) {
        print '20m走 <input type="text" name="20m走_value" value=""> 秒<br>';
    }
    if ($test3_boolean) {
        print '30m走 <input type="text" name="30m走_value" value=""> 秒<br>';
    }
    if ($test4_boolean) {
        print '50m走 <input type="text" name="50m走_value" value=""> 秒<br>';
    }
    if ($test5_boolean) {
        print '1500m走 <input type="text" name="1500m走_min_value" value=""> 分 <input type="text" name="1500m走_sec_value" value=""> 秒<br>';
    }
    if ($test6_boolean) {
        print 'プロアジリティ <input type="text" name="プロアジリティ_value" value=""> 秒<br>';
    }
    if ($test7_boolean) {
        print '立ち幅跳び <input type="text" name="立ち幅跳び_value" value=""> cm<br>';
    }
    if ($test8_boolean) {
        print 'メディシンボール投げ <input type="text" name="メディシンボール投げ_value" value=""> m<br>';
    }
    if ($test9_boolean) {
        print '垂直飛び <input type="text" name="垂直飛び_value" vlaue=""> cm<br>';
    }
    if ($test10_boolean) {
        print '背筋力 <input type="text" name="背筋力_value" value=""> kg<br>';
    }
    if ($test11_boolean) {
        print '握力 <input type="text" name="握力_value" value=""> kg<br>';
    }
    if ($test12_boolean) {
        print 'サイドステップ <input type="text" name="サイドステップ_value" value=""> 回<br>';
    }
    print '<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_test_content.php\'" value="戻る">';
    print '<input type="submit" value="登録">';


    ?>

</body>

</html>