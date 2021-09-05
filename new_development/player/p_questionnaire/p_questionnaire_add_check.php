<!-- 
    p_questionnaire_add.phpからの入力情報をチェックし、遷移先を決定する。
    問題なし→p_questionnaire_add_done.phpへリダイレクト
    問題あり→エラーメッセージを出力し、戻るボタンでp_questionnaire_add.phpへ遷移
 -->

<?php
session_start();
session_regenerate_id(true);

// 自作の関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);

// 入力データのチェック(true:問題なし、false:問題あり)
$flg = true;

// p_questionnaire_add.phpから怪我(injury)、アレルギー(allergy)、病気(sick)の情報を受け取る
// 怪我の情報
for ($i = 1; $i <= 10; $i++) {
    $injury_name = 'injury' . (string)$i . '_name';
    $injury_status = 'injury' . (string)$i . '_status';
    $injury_year = 'injury' . (string)$i . '_year';
    $injury_month = 'injury' . (string)$i . '_month';

    $injury_name_array[$i] = $post[$injury_name];
    $injury_status_array[$i] = $post[$injury_status];
    $injury_year_array[$i] = $post[$injury_year];
    $injury_month_array[$i] = $post[$injury_month];

    // 入力漏れチェック(if:入力漏れなし、else:入力漏れあり)
    if (($injury_name_array[$i] == '' && $injury_status_array[$i] == ''
            && $injury_year_array[$i] == '' && $injury_month_array[$i] == '')
        ||
        ($injury_name_array[$i] != '' && $injury_status_array[$i] != ''
            && $injury_year_array[$i] != '' && $injury_month_array[$i] != '')
    ) {
        // 何もしない
    } else {
        print '怪我の情報について入力漏れがあります<br>';
        // flgにfalseを代入
        $flg = false;
    }
}

// アレルギーの情報
for ($i = 1; $i <= 5; $i++) {
    $allergy_name = 'allergy' . (string)$i . '_name';
    $allergy_status = 'allergy' . (string)$i . '_status';
    $allergy_year = 'allergy' . (string)$i . '_year';
    $allergy_month = 'allergy' . (string)$i . '_month';

    $allergy_name_array[$i] = $post[$allergy_name];
    $allergy_status_array[$i] = $post[$allergy_status];
    $allergy_year_array[$i] = $post[$allergy_year];
    $allergy_month_array[$i] = $post[$allergy_month];

    // 入力漏れチェック(if:入力漏れなし、else:入力漏れあり)
    if (($allergy_name_array[$i] == '' && $allergy_status_array[$i] == ''
            && $allergy_year_array[$i] == '' && $allergy_month_array[$i] == '')
        ||
        ($allergy_name_array[$i] != '' && $allergy_status_array[$i] != ''
            && $allergy_year_array[$i] != '' && $allergy_month_array[$i] != '')
    ) {
        // 何もしない
    } else {
        print 'アレルギーの情報について入力漏れがあります<br>';
        // flgにfalseを代入
        $flg = false;
    }
}

// 病気の情報
for ($i = 1; $i <= 5; $i++) {
    $sick_name = 'sick' . (string)$i . '_name';
    $sick_status = 'sick' . (string)$i . '_status';
    $sick_year = 'sick' . (string)$i . '_year';
    $sick_month = 'sick' . (string)$i . '_month';

    $sick_name_array[$i] = $post[$sick_name];
    $sick_status_array[$i] = $post[$sick_status];
    $sick_year_array[$i] = $post[$sick_year];
    $sick_month_array[$i] = $post[$sick_month];

    // 入力漏れチェック(if:入力漏れなし、else:入力漏れあり)
    if (($sick_name_array[$i] == '' && $sick_status_array[$i] == ''
            && $sick_year_array[$i] == '' && $sick_month_array[$i] == '')
        ||
        ($sick_name_array[$i] != '' && $sick_status_array[$i] != ''
            && $sick_year_array[$i] != '' && $sick_month_array[$i] != '')
    ) {
        // 何もしない
    } else {
        print '病気の情報について入力漏れがあります<br>';
        // flgにfalseを代入
        $flg = false;
    }
}

// メモの情報
$note = $post['note'];

if ($flg) {             // 入力に問題がなかった場合
    // SESSION変数に怪我の情報を保持
    for ($i = 1; $i <= 10; $i++) {
        $injury_name = 'injury' . (string)$i . '_name';
        $injury_status = 'injury' . (string)$i . '_status';
        $injury_year = 'injury' . (string)$i . '_year';
        $injury_month = 'injury' . (string)$i . '_month';

        $_SESSION[$injury_name] = $injury_name_array[$i];
        $_SESSION[$injury_status] = $injury_status_array[$i];
        $_SESSION[$injury_year] = $injury_year_array[$i];
        $_SESSION[$injury_month] = $injury_month_array[$i];
    }

    // SESSION変数にアレルギーの情報を保持
    for ($i = 1; $i <= 5; $i++) {
        $allergy_name = 'allergy' . (string)$i . '_name';
        $allergy_status = 'allergy' . (string)$i . '_status';
        $allergy_year = 'allergy' . (string)$i . '_year';
        $allergy_month = 'allergy' . (string)$i . '_month';

        $_SESSION[$allergy_name] = $allergy_name_array[$i];
        $_SESSION[$allergy_status] = $allergy_status_array[$i];
        $_SESSION[$allergy_year] = $allergy_year_array[$i];
        $_SESSION[$allergy_month] = $allergy_month_array[$i];
    }

    // SESSION変数にアレルギーの情報を保持
    for ($i = 1; $i <= 5; $i++) {
        $sick_name = 'sick' . (string)$i . '_name';
        $sick_status = 'sick' . (string)$i . '_status';
        $sick_year = 'sick' . (string)$i . '_year';
        $sick_month = 'sick' . (string)$i . '_month';

        $_SESSION[$sick_name] = $sick_name_array[$i];
        $_SESSION[$sick_status] = $sick_status_array[$i];
        $_SESSION[$sick_year] = $sick_year_array[$i];
        $_SESSION[$sick_month] = $sick_month_array[$i];
    }

    // SESSION変数にメモの情報を保持
    $_SESSION['note'] = $note; 
    
    header('Location:p_questionnaire_add_done.php');    // p_questionnaire_add_done.phpへリダイレクト
    exit();
} else {                // 入力に問題があった場合
    print '<br><br>';
    print '<input type="button" onclick="location.href=\'p_questionnaire_add.php\'" value="戻る">';
}