<?php
session_start();
session_regenerate_id(true);
$player_code = $_SESSION['player_code'];

try {
    // 自作の関数を呼び出す
    require_once('../../function/function.php');
    // POSTの中身をすべてサニタイズする
    $post = sanitize($_POST);

    // p_top_pass_change.htmlからplayer_passwordとnew_player_passwordとnew_player_password2を受け取る
    $player_password = $post['player_password'];
    $player_password = md5($player_password);
    $new_player_password = $post['new_player_password'];
    $new_player_password2 = $post['new_player_password2'];

    // db_academyデータベースに接続する
    $dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // playerテーブルからplayer_codeとplayer_passwordを使って情報を検索
    $sql = '
            SELECT * 
            FROM player 
            WHERE player_code = ? AND player_password = ?
            ';
    $stmt = $dbh->prepare($sql);
    $data[] = $player_code;
    $data[] = $player_password;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // db_academyデータベースから切断する
    $dbh = null;

    // 入力内容の問題の有無をflgによって判定(問題なし:true、問題あり:false)
    $flg = true;

    // player_passwordが空の場合
    if ($player_password == '') {
        print '現在のパスワードが入力されていません<br>';
        $flg = false;
    }

    // player_passwordが間違っていた場合
    if ($player_password != '' && $rec == '') {
        print '現在のパスワードが間違っています<br>';
        $flg = false;
    }

    // new_player_passwordが空の場合
    if ($new_player_password == '') {
        print '新しいパスワードが入力されていません<br>';
        $flg = false;
    }

    // new_player_passwordとnew_player_password2が一致しない場合
    if ($new_player_password != $new_player_password2) {
        print '新しいパスワードが一致しません<br>';
        $flg = false;
    }

    if ($flg) {             // 入力に問題がなかった場合
        $_SESSION['new_player_password'] = $new_player_password;    // セッション変数にnew_player_passwordを保持
        header('Location:p_top_pass_change_done.php');              // p_top_pass_change_done.phpへリダイレクト
        exit();
    } else {                // 入力に問題があった場合
        print '<br>';
        print '<input type="button" onclick="location.href=\'p_top_pass_change.php\'" value="戻る">';
    }

} catch (Exception $e) {
    var_dump($e);
    exit();
}
