<!-- 
    身体情報一覧を表示する。
    ラジオボタンで選択し、編集・削除ボタンを押すことで遷移する。
    (実際の遷移先はp_phisical_info_list_branch.phpでラジオボタンで選択された
    データがない場合はp_phisical_info_list_branch_ng.phpに遷移する。)

    編集→p_phisical_info_edit.php
    削除→p_phisical_info_delete.php
 -->

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['p_login'])) {     // 選手でログイン状態でない場合(SESSION['p_login']が未定義の場合)
    print 'ログインされていません<br>';
    print '<a href="../p_top/p_top_login.php">ログイン画面へ</a>';
    exit();
} else {                                // 選手でログイン状態の場合(SESSION['p_login']が定義されている(=1)場合)
    if (!isset($_SESSION['c_login'])) {         // コーチでログイン状態でない場合(SESSION['c_login']が未定義の場合)
        print $_SESSION['player_name'];
        print 'さんログイン中<br>';
        print '<br>';
    } else {                                    // コーチでログイン状態の場合(SESSION['c_login']が定義されている(=1)場合)
        print $_SESSION['coach_name'];
        print 'さんログイン中<br>';
        print '選手検索：' . $_SESSION['player_name'];
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>p_phisical_info_list.php</title>
</head>

<body>

    <h3>身体情報一覧</h3>

    <?php

    // SESSIONでplayer_codeを受け取る
    $player_code = $_SESSION['player_code'];

    // DB接続
    try {
        // db_academyデータベースに接続する
        $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // phisical_infoテーブルからplayer_codeを使って情報を検索
        $sql = '
                SELECT phisical_info_code, date, height, weight, body_fat, muscle_mass
                FROM phisical_info 
                WHERE player_code = ?
                ORDER BY date DESC
                ';
        $stmt = $dbh->prepare($sql);
        $data[] = $player_code;
        $stmt->execute($data);
        $rec = $stmt->fetchAll();

        // db_academyデータベースから切断する
        $dbh = null;
    } catch (Exception $e) {
        var_dump($e);
        exit();
    }

    $record_max = 3;                        // 1ページあたりの最大レコード数
    $record_num = count($rec);              // レコードの総数
    $page_max = ceil($record_num / $record_max);    // 総ページ数の計算

    if (!isset($_GET['page_id']))    // $_GET['page_id']が定義されてない場合
    {
        $page_now = 1;
    } else                           // $_GET['page_id']が定義されている場合
    {
        $page_now = $_GET['page_id'];
    }

    $record_start = ($page_now - 1) * $record_max;            // ページに表示する最初のレコード番号（1個目を0番目とする）

    print '<form method="post" action="p_phisical_info_list_branch.php">';

    // ページに表示する分のデータだけ切り取る
    $disp_data = array_slice($rec, $record_start, $record_max, true);
    foreach ($disp_data as $key => $value) {
        print '<input type="radio" name="phisical_info_code" value="' . $value['phisical_info_code'] . '">';
        print '日付：' . $value['date'] . '　';
        print '身長：' . $value['height'] . '　';
        print '体重：' . $value['weight'] . '　';
        print '体脂肪率：' . $value['body_fat'] . '　';
        print '筋量：' . $value['muscle_mass'] . '　';
        print '<br>';
    }

    print '全件数' . $record_num . '件（' . ($record_start + 1) . '件～';

    if ($record_num >= $record_start + $record_max)        // 最後のレコードが現在のページに収まらない場合
    {
        print $record_start + $record_max;
    } else                                                 // 最後のレコードが現在のページに収まる場合
    {
        print $record_num;
    }

    print '件表示中）　';

    // if文によってリンクを貼るかどうかを決定
    if ($page_now > 1)                        // 現在のページ番号が1より大きい場合
    {
        print '<a href=p_phisical_info_list.php?page_id=' . ($page_now - 1) . '>前へ</a>' . '　';
    } else                                    // 現在のページ番号が1の場合（1未満になることはないため）
    {
        print '前へ' . '　';
    }

    // if文によってリンクを貼るかどうかを決定
    if ($page_now < $page_max)                    // 現在のページ番号が最後のページ番号未満の場合
    {
        print '<a href=p_phisical_info_list.php?page_id=' . ($page_now + 1) . '>次へ</a>' . '　';
    } else                                        // 現在のページ番号と最後のページ番号が等しい場合（現在のページ番号は最後のページ番より大きくならないため）
    {
        print '次へ';
    }

    print '<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_info_top.php\'" value="戻る">';
    print '<input type="submit" name="edit" value="編集">';
    print '<input type="submit" name="delete" value="削除">';

    ?>

</body>

</html>