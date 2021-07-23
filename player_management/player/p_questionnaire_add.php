<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['login'])) {
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

    <h3>問診表の編集</h3>
    <br>
    <form method="post" action="p_questionnaire_add_done.php">
        怪我<br>
        1.
        名称
        <input type="text" name="injury1_name" value="">
        状態
        <select name="injury1_status_code">
            <option value=""></option>
            <option value=1>治療済み</option>
            <option value=2>治療中</option>
        </select>
        時期
        <select name="injury1_year">
            <option value=""></option>
            <option value=2019>2019</option>
            <option value=2020>2020</option>
            <option value=2021>2021</option>
        </select>
        年
        <select name="injury1_month">
            <option value=""></option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
            <option value=6>6</option>
            <option value=7>7</option>
            <option value=8>8</option>
            <option value=9>9</option>
            <option value=10>10</option>
            <option value=11>11</option>
            <option value=12>12</option>
        </select>
        月
        <br><br>
        2.
        名称
        <input type="text" name="injury2_name" value="">
        状態
        <select name="injury2_status_code">
            <option value=""></option>
            <option value=1>治療済み</option>
            <option value=2>治療中</option>
        </select>
        時期
        <select name="injury2_year">
            <option value=""></option>
            <option value=2019>2019</option>
            <option value=2020>2020</option>
            <option value=2021>2021</option>
        </select>
        年
        <select name="injury2_month">
            <option value=""></option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
            <option value=6>6</option>
            <option value=7>7</option>
            <option value=8>8</option>
            <option value=9>9</option>
            <option value=10>10</option>
            <option value=11>11</option>
            <option value=12>12</option>
        </select>
        月
        <br><br>
        アレルギー<br>
        1.
        名称
        <input type="text" name="allergies1_name" value="">
        状態
        <select name="allergies1_status_code">
            <option value=""></option>
            <option value=1>治療済み</option>
            <option value=2>治療中</option>
        </select>
        時期
        <select name="allergies1_year">
            <option value=""></option>
            <option value=2019>2019</option>
            <option value=2020>2020</option>
            <option value=2021>2021</option>
        </select>
        年
        <select name="allergies1_month">
            <option value=""></option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
            <option value=6>6</option>
            <option value=7>7</option>
            <option value=8>8</option>
            <option value=9>9</option>
            <option value=10>10</option>
            <option value=11>11</option>
            <option value=12>12</option>
        </select>
        月
        <br><br>
        2.
        名称
        <input type="text" name="allergies2_name" value="">
        状態
        <select name="allergies2_status_code">
            <option value=""></option>
            <option value=1>治療済み</option>
            <option value=2>治療中</option>
        </select>
        時期
        <select name="allergies2_year">
            <option value=""></option>
            <option value=2019>2019</option>
            <option value=2020>2020</option>
            <option value=2021>2021</option>
        </select>
        年
        <select name="allergies2_month">
            <option value=""></option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
            <option value=6>6</option>
            <option value=7>7</option>
            <option value=8>8</option>
            <option value=9>9</option>
            <option value=10>10</option>
            <option value=11>11</option>
            <option value=12>12</option>
        </select>
        月
        <br><br>
        病気<br>
        1.
        名称
        <input type="text" name="sick1_name" value="">
        状態
        <select name="sick1_status_code">
            <option value=""></option>
            <option value=1>治療済み</option>
            <option value=2>治療中</option>
        </select>
        時期
        <select name="sick1_year">
            <option value=""></option>
            <option value=2019>2019</option>
            <option value=2020>2020</option>
            <option value=2021>2021</option>
        </select>
        年
        <select name="sick1_month">
            <option value=""></option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
            <option value=6>6</option>
            <option value=7>7</option>
            <option value=8>8</option>
            <option value=9>9</option>
            <option value=10>10</option>
            <option value=11>11</option>
            <option value=12>12</option>
        </select>
        月
        <br><br>
        2.
        名称
        <input type="text" name="sick2_name" value="">
        状態
        <select name="sick2_status_code">
            <option value=""></option>
            <option value=1>治療済み</option>
            <option value=2>治療中</option>
        </select>
        時期
        <select name="sick2_year">
            <option value=""></option>
            <option value=2019>2019</option>
            <option value=2020>2020</option>
            <option value=2021>2021</option>
        </select>
        年
        <select name="sick2_month">
            <option value=""></option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
            <option value=6>6</option>
            <option value=7>7</option>
            <option value=8>8</option>
            <option value=9>9</option>
            <option value=10>10</option>
            <option value=11>11</option>
            <option value=12>12</option>
        </select>
        月
        <br><br>

        <br>
        <input type="button" onclick="location.href='p_questionnaire.php'" value="戻る">
        <input type="submit" value="ＯＫ">
    </form>


</body>

</html>