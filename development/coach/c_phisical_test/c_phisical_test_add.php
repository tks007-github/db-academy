<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['c_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="../c_top/c_top_login.html">ログイン画面へ</a>';
} else {
    print $_SESSION['coach_name'];
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
    <title>c_phisical_test_add</title>
</head>

<body>

    <h3>フィジカルテスト登録</h3>

    <?php

    // SESSION変数の初期化
    $_SESSION['belong_code'] = '';
    $_SESSION['date'] = '';
    $_SESSION['10m走_boolean'] = '';
    $_SESSION['20m走_boolean'] = '';
    $_SESSION['30m走_boolean'] = '';
    $_SESSION['50m走_boolean'] = '';
    $_SESSION['1500m走_boolean'] = '';
    $_SESSION['プロアジリティ_boolean'] = '';
    $_SESSION['立ち幅跳び_boolean'] = '';
    $_SESSION['メディシンボール投げ_boolean'] = '';
    $_SESSION['垂直飛び_boolean'] = '';
    $_SESSION['背筋力_boolean'] = '';
    $_SESSION['握力_boolean'] = '';
    $_SESSION['サイドステップ_boolean'] = '';

    ?>

    <form method="post" action="c_phisical_test_add_check.php">
    日付<br>
    <input type="date" name="date">
    <br>
    所属<br>
    <select name="belong_code">
            <option value=""></option>
            <option value="A">新川高校</option>
            <option value="B">D.B.アカデミー</option>
    </select>
    <br><br>

    項目<br>
    <input type="checkbox" name="10m走_boolean" value=1>
    test1：10m走
    <br>
    <input type="checkbox" name="20m走_boolean" value=1>
    test2：20m走
    <br>
    <input type="checkbox" name="30m走_boolean" value=1>
    test3：30m走
    <br>
    <input type="checkbox" name="50m走_boolean" value=1>
    test4：50m走
    <br>
    <input type="checkbox" name="1500m走_boolean" value=1>
    test5：1500m走
    <br>
    <input type="checkbox" name="プロアジリティ_boolean" value=1>
    test6：プロアジリティ
    <br>
    <input type="checkbox" name="立ち幅跳び_boolean" value=1>
    test7：立ち幅跳び
    <br>
    <input type="checkbox" name="メディシンボール投げ_boolean" value=1>
    test8：メディシンボール投げ
    <br>
    <input type="checkbox" name="垂直飛び_boolean" value=1>
    test9：垂直飛び
    <br>
    <input type="checkbox" name="背筋力_boolean" value=1>
    test10：背筋力
    <br>
    <input type="checkbox" name="握力_boolean" value=1>
    test11：握力
    <br>
    <input type="checkbox" name="サイドステップ_boolean" value=1>
    test12：サイドステップ
    <br>
    
    <br><br>
    <input type="button" onclick="location.href='c_phisical_test_top.php'" value="戻る">
    <input type="submit" value="登録">
    </form>

</body>

</html>