<?php

// 関数名:sanitize  引数:$_POST  戻り値:$_POSTをエスケープした値
// 説明:$_POSTで受け取ったすべての値をhtmlspecialchars関数でサニタイズする
function sanitize($before) {                 // 連想配列$_POSTを$beforeとして受け取る
    foreach ($before as $key => $value) {    // $beforeの要素すべてについて繰り返し
        $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');    // エスケープした値を連想配列$afterに格納、キーは$beforeと共通
    }
    return $after;                // $afterを戻り値として出力
}


// 関数名:edit_select_status　引数:$status_index、$status_value　戻り値:$select_status_line
function select_status($status_index, $status_value) {
    $select_status_line = '<select name=' . $status_index . '>';
    if ($status_value == '') {
        $select_status_line .= '<option value="" selected></option>';
    } else {
        $select_status_line .= '<option value=""></option>';
    }
    if ($status_value == '治療済') {
        $select_status_line .= '<option value="治療済" selected>治療済</option>';
    } else {
        $select_status_line .= '<option value="治療済">治療済</option>';
    }
    if ($status_value == '治療中') {
        $select_status_line .= '<option value="治療中" selected>治療中</option>';
    } else {
        $select_status_line .= '<option value="治療中">治療中</option>';
    }
    $select_status_line .= '</select>';
    return $select_status_line;
}


// 関数名:select_year　引数:$year_index、$year_value　戻り値:$select_year_line
function select_year($year_index, $year_value) {
    // 現在の年(西暦)を取得
    date_default_timezone_set('Asia/Tokyo');
    $current_year = date('Y');

    $select_year_line = '<select name=' . $year_index . '>';
    $select_year_line .= '<option value=""></option>';
    for ($i = 2000; $i <= $current_year; $i++) {
        if ($year_value == $i) {
            $select_year_line .= '<option value=' . $i . ' selected>' . $i . '</option>';
        } else {    
            $select_year_line .= '<option value=' . $i . '>' . $i . '</option>';
        }
    }
    $select_year_line .= '</select>';
    return $select_year_line;
}


// 関数名:select_month　引数:$month_index、$month_value　戻り値:$select_month_line
function select_month($month_index, $month_value) {
    $select_month_line = '<select name=' . $month_index . '>';
    $select_month_line .= '<option value=""></option>';
    for ($i = 1; $i <= 12; $i++) {
        if ($month_value == $i) {
            $select_month_line .= '<option value=' . $i . ' selected>' . $i . '</option>';    
        } else {
            $select_month_line .= '<option value=' . $i . '>' . $i . '</option>';
        }
    }
    $select_month_line .= '</select>';
    return $select_month_line;
}

// 関数名:test1_score(10m走)  引数:$test1_recent_value  戻り値:$test1_recent_score
function test1_score($test1_recent_value) {
    if ($test1_recent_value == '') {
        $test1_recent_value = NULL;
    } else if ($test1_recent_value >= 2.05) {
        $test1_recent_score = 1;
    } else if ($test1_recent_value >= 2.0) {
        $test1_recent_score = 2;
    } else if ($test1_recent_value >= 1.95) {
        $test1_recent_score = 3;
    } else if ($test1_recent_value >= 1.9) {
        $test1_recent_score = 4;
    } else if ($test1_recent_value >= 1.85) {
        $test1_recent_score = 5;
    } else if ($test1_recent_value >= 1.8) {
        $test1_recent_score = 6;
    } else if ($test1_recent_value >= 1.75) {
        $test1_recent_score = 7;
    } else if ($test1_recent_value >= 1.7) {
        $test1_recent_score = 8;
    } else if ($test1_recent_value >= 1.66) {
        $test1_recent_score = 9;
    } else {
        $test1_recent_score = 10;
    }
    
    return $test1_recent_score;
}

// 関数名:test2_score(20m走)  引数:$test2_recent_value  戻り値:$test2_recent_score
function test2_score($test2_recent_value) {
    if ($test2_recent_value == '') {
        $test2_recent_value = NULL;
    } else if ($test2_recent_value >= 3.26) {
        $test2_recent_score = 1;
    } else if ($test2_recent_value >= 3.2) {
        $test2_recent_score = 2;
    } else if ($test2_recent_value >= 3.16) {
        $test2_recent_score = 3;
    } else if ($test2_recent_value >= 3.1) {
        $test2_recent_score = 4;
    } else if ($test2_recent_value >= 3.05) {
        $test2_recent_score = 5;
    } else if ($test2_recent_value >= 3.01) {
        $test2_recent_score = 6;
    } else if ($test2_recent_value >= 2.95) {
        $test2_recent_score = 7;
    } else if ($test2_recent_value >= 2.9) {
        $test2_recent_score = 8;
    } else if ($test2_recent_value >= 2.81) {
        $test2_recent_score = 9;
    } else {
        $test2_recent_score = 10;
    }
    
    return $test2_recent_score;
}
