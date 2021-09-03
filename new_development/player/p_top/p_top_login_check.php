<!-- 
	p_top_login.phpから会員コード(player_code)とパスワード(player_password)を受け取って、
	正しい情報が入力されたかの確認を行います。
	会員コード(player_code)とパスワード(mst_password)が正しい場合→p_top.phpへリダイレクト
	会員コード(player_code)とパスワード(mst_password)が正しくない場合→p_top_login.phpへリダイレクト
 -->

<?php

// 自作のsanitize関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);

// p_top_login.phpからplayer_codeとplayer_passwordを受け取る
$player_code = $post['player_code'];
$player_password = $post['player_password'];
// player_passwordをmd5で暗号化
$player_password = md5($player_password);

// DB接続
try {
	// db_academyデータベースに接続する
	$dsn = 'mysql:dbname=db_academy;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';
	$dbh = new PDO($dsn, $user, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// playerテーブルからplayer_codeとplayer_passwordを使ってplayer_nameとbelong_codeを検索
	$sql = '
            SELECT player_name, belong_code 
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
} catch (Exception $e) {
	var_dump($e);
	exit();
}

// セッションを開始
session_start();
if ($rec != '') {					            // データベースからの問い合わせ結果があった場合(player_codeとplayer_passwordの組み合わせが正しかった場合)
	$_SESSION['p_login'] = 1;			        		// SESSION['p_login']に1をセット(ログイン状態を表す)
	unset($_SESSION['p_login_ng']);						// SESSION['p_login_ng']を削除(初期化)
	$_SESSION['player_code'] = $player_code;			// SESSION['player_code']をセット
	$_SESSION['player_name'] = $rec['player_name'];		// SESSION['player_name']をセット
	$_SESSION['belong_code'] = $rec['belong_code'];		// SESSION['belong_code']をセット
	header('Location:p_top.php');		        		// p_top.phpへリダイレクト
	exit();
} else {										// データベースからの問い合わせ結果がない場合(player_codeとplayer_passwordの組み合わせが正しくなかった場合)
	$_SESSION['p_login_ng'] = 1;						// SESSION['p_login_ng']に1をセット(ログインの失敗を表す)
	header('Location:p_top_login.php');		    		// p_top_login.phpへリダイレクト
	exit();
}
