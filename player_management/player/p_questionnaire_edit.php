<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {
    print 'ログインされていません。<br>';
    print '<a href="p_login.html">ログイン画面へ</a>';
    exit();
} else {
    $p_code = $_SESSION['p_code'];
    print $p_code;
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
    <title>Player</title>
</head>

<body>

    <?php
    // 怪我、アレルギー、病気変数の初期化
    $injury1_name = '';
    $injury1_status_code = '';
    $injury1_year = '';
    $injury1_month = '';
    $injury2_name = '';
    $injury2_status_code = '';
    $injury2_year = '';
    $injury2_month = '';

    $allergies1_name = '';
    $allergies1_status_code = '';
    $allergies1_year = '';
    $allergies1_month = '';
    $allergies2_name = '';
    $allergies2_status_code = '';
    $allergies2_year = '';
    $allergies2_month = '';

    $sick1_name = '';
    $sick1_status_code = '';
    $sick1_year = '';
    $sick1_month = '';
    $sick2_name = '';
    $sick2_status_code = '';
    $sick2_year = '';
    $sick2_month = '';

    // p_questionnaire.phpから怪我、アレルギー、病気の情報を受け取る
    $injury_num = htmlspecialchars($_POST['injury_num'], ENT_QUOTES, 'UTF-8');
    $allergies_num = htmlspecialchars($_POST['allergies_num'], ENT_QUOTES, 'UTF-8');
    $sick_num = htmlspecialchars($_POST['sick_num'], ENT_QUOTES, 'UTF-8');

    if ($injury_num == 1) {
        $injury1_name = htmlspecialchars($_POST['injury1_name'], ENT_QUOTES, 'UTF-8');
        $injury1_status_code = htmlspecialchars($_POST['injury1_status_code'], ENT_QUOTES, 'UTF-8');
        $injury1_year = htmlspecialchars($_POST['injury1_year'], ENT_QUOTES, 'UTF-8');
        $injury1_month = htmlspecialchars($_POST['injury1_month'], ENT_QUOTES, 'UTF-8');
    } elseif ($injury_num == 2) {
        $injury1_name = htmlspecialchars($_POST['injury1_name'], ENT_QUOTES, 'UTF-8');
        $injury1_status_code = htmlspecialchars($_POST['injury1_status_code'], ENT_QUOTES, 'UTF-8');
        $injury1_year = htmlspecialchars($_POST['injury1_year'], ENT_QUOTES, 'UTF-8');
        $injury1_month = htmlspecialchars($_POST['injury1_month'], ENT_QUOTES, 'UTF-8');
        $injury2_name = htmlspecialchars($_POST['injury2_name'], ENT_QUOTES, 'UTF-8');
        $injury2_status_code = htmlspecialchars($_POST['injury2_status_code'], ENT_QUOTES, 'UTF-8');
        $injury2_year = htmlspecialchars($_POST['injury2_year'], ENT_QUOTES, 'UTF-8');
        $injury2_month = htmlspecialchars($_POST['injury2_month'], ENT_QUOTES, 'UTF-8');
    }

    if ($allergies_num == 1) {
        $allergies1_name = htmlspecialchars($_POST['allergies1_name'], ENT_QUOTES, 'UTF-8');
        $allergies1_status_code = htmlspecialchars($_POST['allergies1_status_code'], ENT_QUOTES, 'UTF-8');
        $allergies1_year = htmlspecialchars($_POST['allergies1_year'], ENT_QUOTES, 'UTF-8');
        $allergies1_month = htmlspecialchars($_POST['allergies1_month'], ENT_QUOTES, 'UTF-8');
    } elseif ($allergies_num == 2) {
        $allergies1_name = htmlspecialchars($_POST['allergies1_name'], ENT_QUOTES, 'UTF-8');
        $allergies1_status_code = htmlspecialchars($_POST['allergies1_status_code'], ENT_QUOTES, 'UTF-8');
        $allergies1_year = htmlspecialchars($_POST['allergies1_year'], ENT_QUOTES, 'UTF-8');
        $allergies1_month = htmlspecialchars($_POST['allergies1_month'], ENT_QUOTES, 'UTF-8');
        $allergies2_name = htmlspecialchars($_POST['allergies2_name'], ENT_QUOTES, 'UTF-8');
        $allergies2_status_code = htmlspecialchars($_POST['allergies2_status_code'], ENT_QUOTES, 'UTF-8');
        $allergies2_year = htmlspecialchars($_POST['allergies2_year'], ENT_QUOTES, 'UTF-8');
        $allergies2_month = htmlspecialchars($_POST['allergies2_month'], ENT_QUOTES, 'UTF-8');
    }

    if ($sick_num == 1) {
        $sick1_name = htmlspecialchars($_POST['sick1_name'], ENT_QUOTES, 'UTF-8');
        $sick1_status_code = htmlspecialchars($_POST['sick1_status_code'], ENT_QUOTES, 'UTF-8');
        $sick1_year = htmlspecialchars($_POST['sick1_year'], ENT_QUOTES, 'UTF-8');
        $sick1_month = htmlspecialchars($_POST['sick1_month'], ENT_QUOTES, 'UTF-8');
    } elseif ($sick_num == 2) {
        $sick1_name = htmlspecialchars($_POST['sick1_name'], ENT_QUOTES, 'UTF-8');
        $sick1_status_code = htmlspecialchars($_POST['sick1_status_code'], ENT_QUOTES, 'UTF-8');
        $sick1_year = htmlspecialchars($_POST['sick1_year'], ENT_QUOTES, 'UTF-8');
        $sick1_month = htmlspecialchars($_POST['sick1_month'], ENT_QUOTES, 'UTF-8');
        $sick2_name = htmlspecialchars($_POST['sick2_name'], ENT_QUOTES, 'UTF-8');
        $sick2_status_code = htmlspecialchars($_POST['sick2_status_code'], ENT_QUOTES, 'UTF-8');
        $sick2_year = htmlspecialchars($_POST['sick2_year'], ENT_QUOTES, 'UTF-8');
        $sick2_month = htmlspecialchars($_POST['sick2_month'], ENT_QUOTES, 'UTF-8');
    }

    ?>

    <h3>問診表の編集</h3>
    <br>
    <form method="post" action="p_questionnaire_edit_done.php">
        怪我<br>
        1.
        名称
        <input type="text" name="injury1_name" value="<?php print $injury1_name; ?>">
        状態
        <select name="injury1_status_code">
            <option value="" <?php print($injury1_status_code == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($injury1_status_code == 1 ? 'selected' : ''); ?>>治療済み</option>
            <option value=2 <?php print($injury1_status_code == 2 ? 'selected' : ''); ?>>治療中</option>
        </select>
        時期
        <select name="injury1_year">
            <option value="" <?php print($injury1_year == 0 ? 'selected' : ''); ?>></option>
            <option value=2019 <?php print($injury1_year == 2019 ? 'selected' : ''); ?>>2019</option>
            <option value=2020 <?php print($injury1_year == 2020 ? 'selected' : ''); ?>>2020</option>
            <option value=2021 <?php print($injury1_year == 2021 ? 'selected' : ''); ?>>2021</option>
        </select>
        年
        <select name="injury1_month">
            <option value="" <?php print($injury1_month == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($injury1_month == 1 ? 'selected' : ''); ?>>1</option>
            <option value=2 <?php print($injury1_month == 2 ? 'selected' : ''); ?>>2</option>
            <option value=3 <?php print($injury1_month == 3 ? 'selected' : ''); ?>>3</option>
            <option value=4 <?php print($injury1_month == 4 ? 'selected' : ''); ?>>4</option>
            <option value=5 <?php print($injury1_month == 5 ? 'selected' : ''); ?>>5</option>
            <option value=6 <?php print($injury1_month == 6 ? 'selected' : ''); ?>>6</option>
            <option value=7 <?php print($injury1_month == 7 ? 'selected' : ''); ?>>7</option>
            <option value=8 <?php print($injury1_month == 8 ? 'selected' : ''); ?>>8</option>
            <option value=9 <?php print($injury1_month == 9 ? 'selected' : ''); ?>>9</option>
            <option value=10 <?php print($injury1_month == 10 ? 'selected' : ''); ?>>10</option>
            <option value=11 <?php print($injury1_month == 11 ? 'selected' : ''); ?>>11</option>
            <option value=12 <?php print($injury1_month == 12 ? 'selected' : ''); ?>>12</option>
        </select>
        月
        <br><br>
        2.
        名称
        <input type="text" name="injury2_name" value="<?php print $injury2_name; ?>">
        状態
        <select name="injury2_status_code">
            <option value="" <?php print($injury2_status_code == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($injury2_status_code == 1 ? 'selected' : ''); ?>>治療済み</option>
            <option value=2 <?php print($injury2_status_code == 2 ? 'selected' : ''); ?>>治療中</option>
        </select>
        時期
        <select name="injury2_year">
            <option value="" <?php print($injury2_year == 0 ? 'selected' : ''); ?>></option>
            <option value=2019 <?php print($injury2_year == 2019 ? 'selected' : ''); ?>>2019</option>
            <option value=2020 <?php print($injury2_year == 2020 ? 'selected' : ''); ?>>2020</option>
            <option value=2021 <?php print($injury2_year == 2021 ? 'selected' : ''); ?>>2021</option>
        </select>
        年
        <select name="injury2_month">
            <option value="" <?php print($injury2_month == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($injury2_month == 1 ? 'selected' : ''); ?>>1</option>
            <option value=2 <?php print($injury2_month == 2 ? 'selected' : ''); ?>>2</option>
            <option value=3 <?php print($injury2_month == 3 ? 'selected' : ''); ?>>3</option>
            <option value=4 <?php print($injury2_month == 4 ? 'selected' : ''); ?>>4</option>
            <option value=5 <?php print($injury2_month == 5 ? 'selected' : ''); ?>>5</option>
            <option value=6 <?php print($injury2_month == 6 ? 'selected' : ''); ?>>6</option>
            <option value=7 <?php print($injury2_month == 7 ? 'selected' : ''); ?>>7</option>
            <option value=8 <?php print($injury2_month == 8 ? 'selected' : ''); ?>>8</option>
            <option value=9 <?php print($injury2_month == 9 ? 'selected' : ''); ?>>9</option>
            <option value=10 <?php print($injury2_month == 10 ? 'selected' : ''); ?>>10</option>
            <option value=11 <?php print($injury2_month == 11 ? 'selected' : ''); ?>>11</option>
            <option value=12 <?php print($injury2_month == 12 ? 'selected' : ''); ?>>12</option>
        </select>
        月
        <br><br>
        アレルギー<br>
        1.
        名称
        <input type="text" name="allergies1_name" value="<?php print $allergies1_name; ?>">
        状態
        <select name="allergies1_status_code">
            <option value="" <?php print($allergies1_status_code == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($allergies1_status_code == 1 ? 'selected' : ''); ?>>治療済み</option>
            <option value=2 <?php print($allergies1_status_code == 2 ? 'selected' : ''); ?>>治療中</option>
        </select>
        時期
        <select name="allergies1_year">
            <option value="" <?php print($allergies1_year == 0 ? 'selected' : ''); ?>></option>
            <option value=2019 <?php print($allergies1_year == 2019 ? 'selected' : ''); ?>>2019</option>
            <option value=2020 <?php print($allergies1_year == 2020 ? 'selected' : ''); ?>>2020</option>
            <option value=2021 <?php print($allergies1_year== 2021 ? 'selected' : ''); ?>>2021</option>
        </select>
        年
        <select name="allergies1_month">
            <option value="" <?php print($allergies1_month == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($allergies1_month == 1 ? 'selected' : ''); ?>>1</option>
            <option value=2 <?php print($allergies1_month == 2 ? 'selected' : ''); ?>>2</option>
            <option value=3 <?php print($allergies1_month == 3 ? 'selected' : ''); ?>>3</option>
            <option value=4 <?php print($allergies1_month == 4 ? 'selected' : ''); ?>>4</option>
            <option value=5 <?php print($allergies1_month == 5 ? 'selected' : ''); ?>>5</option>
            <option value=6 <?php print($allergies1_month == 6 ? 'selected' : ''); ?>>6</option>
            <option value=7 <?php print($allergies1_month == 7 ? 'selected' : ''); ?>>7</option>
            <option value=8 <?php print($allergies1_month == 8 ? 'selected' : ''); ?>>8</option>
            <option value=9 <?php print($allergies1_month == 9 ? 'selected' : ''); ?>>9</option>
            <option value=10 <?php print($allergies1_month == 10 ? 'selected' : ''); ?>>10</option>
            <option value=11 <?php print($allergies1_month == 11 ? 'selected' : ''); ?>>11</option>
            <option value=12 <?php print($allergies1_month == 12 ? 'selected' : ''); ?>>12</option>
        </select>
        月
        <br><br>
        2.
        名称
        <input type="text" name="allergies2_name" value="<?php print $allergies2_name; ?>">
        状態
        <select name="allergies2_status_code">
            <option value="" <?php print($allergies2_status_code == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($allergies2_status_code == 1 ? 'selected' : ''); ?>>治療済み</option>
            <option value=2 <?php print($allergies2_status_code == 2 ? 'selected' : ''); ?>>治療中</option>
        </select>
        時期
        <select name="allergies2_year">
            <option value="" <?php print($allergies2_year == 0 ? 'selected' : ''); ?>></option>
            <option value=2019 <?php print($allergies2_year == 2019 ? 'selected' : ''); ?>>2019</option>
            <option value=2020 <?php print($allergies2_year == 2020 ? 'selected' : ''); ?>>2020</option>
            <option value=2021 <?php print($allergies2_year == 2021 ? 'selected' : ''); ?>>2021</option>
        </select>
        年
        <select name="allergies2_month">
            <option value="" <?php print($allergies2_month == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($allergies2_month == 1 ? 'selected' : ''); ?>>1</option>
            <option value=2 <?php print($allergies2_month == 2 ? 'selected' : ''); ?>>2</option>
            <option value=3 <?php print($allergies2_month == 3 ? 'selected' : ''); ?>>3</option>
            <option value=4 <?php print($allergies2_month == 4 ? 'selected' : ''); ?>>4</option>
            <option value=5 <?php print($allergies2_month == 5 ? 'selected' : ''); ?>>5</option>
            <option value=6 <?php print($allergies2_month == 6 ? 'selected' : ''); ?>>6</option>
            <option value=7 <?php print($allergies2_month == 7 ? 'selected' : ''); ?>>7</option>
            <option value=8 <?php print($allergies2_month == 8 ? 'selected' : ''); ?>>8</option>
            <option value=9 <?php print($allergies2_month == 9 ? 'selected' : ''); ?>>9</option>
            <option value=10 <?php print($allergies2_month == 10 ? 'selected' : ''); ?>>10</option>
            <option value=11 <?php print($allergies2_month == 11 ? 'selected' : ''); ?>>11</option>
            <option value=12 <?php print($allergies2_month == 12 ? 'selected' : ''); ?>>12</option>
        </select>
        月
        <br><br>
        病気<br>
        1.
        名称
        <input type="text" name="sick1_name" value="<?php print $sick1_name; ?>">
        状態
        <select name="sick1_status_code">
            <option value="" <?php print($sick1_status_code == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($sick1_status_code == 1 ? 'selected' : ''); ?>>治療済み</option>
            <option value=2 <?php print($sick1_status_code == 2 ? 'selected' : ''); ?>>治療中</option>
        </select>
        時期
        <select name="sick1_year">
            <option value="" <?php print($sick1_year == 0 ? 'selected' : ''); ?>></option>
            <option value=2019 <?php print($sick1_year == 2019 ? 'selected' : ''); ?>>2019</option>
            <option value=2020 <?php print($sick1_year == 2020 ? 'selected' : ''); ?>>2020</option>
            <option value=2021 <?php print($sick1_year == 2021 ? 'selected' : ''); ?>>2021</option>
        </select>
        年
        <select name="sick1_month">
            <option value="" <?php print($sick1_month == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($sick1_month == 1 ? 'selected' : ''); ?>>1</option>
            <option value=2 <?php print($sick1_month == 2 ? 'selected' : ''); ?>>2</option>
            <option value=3 <?php print($sick1_month == 3 ? 'selected' : ''); ?>>3</option>
            <option value=4 <?php print($sick1_month == 4 ? 'selected' : ''); ?>>4</option>
            <option value=5 <?php print($sick1_month == 5 ? 'selected' : ''); ?>>5</option>
            <option value=6 <?php print($sick1_month == 6 ? 'selected' : ''); ?>>6</option>
            <option value=7 <?php print($sick1_month == 7 ? 'selected' : ''); ?>>7</option>
            <option value=8 <?php print($sick1_month == 8 ? 'selected' : ''); ?>>8</option>
            <option value=9 <?php print($sick1_month == 9 ? 'selected' : ''); ?>>9</option>
            <option value=10 <?php print($sick1_month == 10 ? 'selected' : ''); ?>>10</option>
            <option value=11 <?php print($sick1_month == 11 ? 'selected' : ''); ?>>11</option>
            <option value=12 <?php print($sick1_month == 12 ? 'selected' : ''); ?>>12</option>
        </select>
        月
        <br><br>
        2.
        名称
        <input type="text" name="sick2_name" value="<?php print $sick2_name; ?>">
        状態
        <select name="sick2_status_code">
            <option value="" <?php print($sick2_status_code == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($sick2_status_code == 1 ? 'selected' : ''); ?>>治療済み</option>
            <option value=2 <?php print($sick2_status_code == 2 ? 'selected' : ''); ?>>治療中</option>
        </select>
        時期
        <select name="sick2_year">
            <option value="" <?php print($sick2_year == 0 ? 'selected' : ''); ?>></option>
            <option value=2019 <?php print($sick2_year == 2019 ? 'selected' : ''); ?>>2019</option>
            <option value=2020 <?php print($sick2_year == 2020 ? 'selected' : ''); ?>>2020</option>
            <option value=2021 <?php print($sick2_year == 2021 ? 'selected' : ''); ?>>2021</option>
        </select>
        年
        <select name="sick2_month">
            <option value="" <?php print($sick2_month == 0 ? 'selected' : ''); ?>></option>
            <option value=1 <?php print($sick2_month == 1 ? 'selected' : ''); ?>>1</option>
            <option value=2 <?php print($sick2_month == 2 ? 'selected' : ''); ?>>2</option>
            <option value=3 <?php print($sick2_month == 3 ? 'selected' : ''); ?>>3</option>
            <option value=4 <?php print($sick2_month == 4 ? 'selected' : ''); ?>>4</option>
            <option value=5 <?php print($sick2_month == 5 ? 'selected' : ''); ?>>5</option>
            <option value=6 <?php print($sick2_month == 6 ? 'selected' : ''); ?>>6</option>
            <option value=7 <?php print($sick2_month == 7 ? 'selected' : ''); ?>>7</option>
            <option value=8 <?php print($sick2_month == 8 ? 'selected' : ''); ?>>8</option>
            <option value=9 <?php print($sick2_month == 9 ? 'selected' : ''); ?>>9</option>
            <option value=10 <?php print($sick2_month == 10 ? 'selected' : ''); ?>>10</option>
            <option value=11 <?php print($sick2_month == 11 ? 'selected' : ''); ?>>11</option>
            <option value=12 <?php print($sick2_month == 12 ? 'selected' : ''); ?>>12</option>
        </select>
        月
        <br><br>

        <br>
        <input type="button" onclick="location.href='p_questionnaire.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>

</body>

</html>