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
        $test1_recent_score = NULL;
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
        $test2_recent_score = NULL;
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

// 関数名:test3_score(30m走)  引数:$test3_recent_value  戻り値:$test3_recent_score
function test3_score($test3_recent_value) {
    if ($test3_recent_value == '') {
        $test3_recent_score = NULL;
    } else if ($test3_recent_value >= 5.21) {
        $test3_recent_score = 1;
    } else if ($test3_recent_value >= 5.06) {
        $test3_recent_score = 2;
    } else if ($test3_recent_value >= 4.91) {
        $test3_recent_score = 3;
    } else if ($test3_recent_value >= 4.76) {
        $test3_recent_score = 4;
    } else if ($test3_recent_value >= 4.61) {
        $test3_recent_score = 5;
    } else if ($test3_recent_value >= 4.46) {
        $test3_recent_score = 6;
    } else if ($test3_recent_value >= 4.31) {
        $test3_recent_score = 7;
    } else if ($test3_recent_value >= 4.16) {
        $test3_recent_score = 8;
    } else if ($test3_recent_value >= 4.01) {
        $test3_recent_score = 9;
    } else {
        $test3_recent_score = 10;
    }
    
    return $test3_recent_score;
}

// 関数名:test4_score(50m走)  引数:$test4_recent_value  戻り値:$test4_recent_score
function test4_score($test4_recent_value) {
    if ($test4_recent_value == '') {
        $test4_recent_score = NULL;
    } else if ($test4_recent_value >= 7.5) {
        $test4_recent_score = 1;
    } else if ($test4_recent_value >= 7.3) {
        $test4_recent_score = 2;
    } else if ($test4_recent_value >= 7.1) {
        $test4_recent_score = 3;
    } else if ($test4_recent_value >= 6.9) {
        $test4_recent_score = 4;
    } else if ($test4_recent_value >= 6.7) {
        $test4_recent_score = 5;
    } else if ($test4_recent_value >= 6.5) {
        $test4_recent_score = 6;
    } else if ($test4_recent_value >= 6.4) {
        $test4_recent_score = 7;
    } else if ($test4_recent_value >= 6.2) {
        $test4_recent_score = 8;
    } else if ($test4_recent_value >= 6.0) {
        $test4_recent_score = 9;
    } else {
        $test4_recent_score = 10;
    }
    
    return $test4_recent_score;
}

// 関数名:test5_score(1500m走)  引数:$test5_recent_value  戻り値:$test5_recent_score
function test5_score($test5_recent_value) {
    if ($test5_recent_value == '') {
        $test5_recent_score = NULL;
    } else if ($test5_recent_value >= 406) {
        $test5_recent_score = 1;
    } else if ($test5_recent_value >= 391) {
        $test5_recent_score = 2;
    } else if ($test5_recent_value >= 376) {
        $test5_recent_score = 3;
    } else if ($test5_recent_value >= 361) {
        $test5_recent_score = 4;
    } else if ($test5_recent_value >= 346) {
        $test5_recent_score = 5;
    } else if ($test5_recent_value >= 331) {
        $test5_recent_score = 6;
    } else if ($test5_recent_value >= 316) {
        $test5_recent_score = 7;
    } else if ($test5_recent_value >= 301) {
        $test5_recent_score = 8;
    } else if ($test5_recent_value >= 291) {
        $test5_recent_score = 9;
    } else {
        $test5_recent_score = 10;
    }
    
    return $test5_recent_score;
}

// 関数名:test6_score(プロアジリティ)  引数:$test6_recent_value  戻り値:$test6_recent_score
function test6_score($test6_recent_value) {
    if ($test6_recent_value == '') {
        $test6_recent_score = NULL;
    } else if ($test6_recent_value >= 5.31) {
        $test6_recent_score = 1;
    } else if ($test6_recent_value >= 5.21) {
        $test6_recent_score = 2;
    } else if ($test6_recent_value >= 5.11) {
        $test6_recent_score = 3;
    } else if ($test6_recent_value >= 5.09) {
        $test6_recent_score = 4;
    } else if ($test6_recent_value >= 4.9) {
        $test6_recent_score = 5;
    } else if ($test6_recent_value >= 4.81) {
        $test6_recent_score = 6;
    } else if ($test6_recent_value >= 4.71) {
        $test6_recent_score = 7;
    } else if ($test6_recent_value >= 4.61) {
        $test6_recent_score = 8;
    } else if ($test6_recent_value >= 4.51) {
        $test6_recent_score = 9;
    } else {
        $test6_recent_score = 10;
    }
    
    return $test6_recent_score;
}

// 関数名:test7_score(立ち幅跳び)  引数:$test7_recent_value  戻り値:$test7_recent_score
function test7_score($test7_recent_value) {
    if ($test7_recent_value == '') {
        $test7_recent_score = NULL;
    } else if ($test7_recent_value <= 219) {
        $test7_recent_score = 1;
    } else if ($test7_recent_value <= 229) {
        $test7_recent_score = 2;
    } else if ($test7_recent_value <= 239) {
        $test7_recent_score = 3;
    } else if ($test7_recent_value <= 249) {
        $test7_recent_score = 4;
    } else if ($test7_recent_value <= 259) {
        $test7_recent_score = 5;
    } else if ($test7_recent_value <= 269) {
        $test7_recent_score = 6;
    } else if ($test7_recent_value <= 279) {
        $test7_recent_score = 7;
    } else if ($test7_recent_value <= 289) {
        $test7_recent_score = 8;
    } else if ($test7_recent_value <= 299) {
        $test7_recent_score = 9;
    } else {
        $test7_recent_score = 10;
    }
    
    return $test7_recent_score;
}

// 関数名:test8_score(メディシンボール投げ)  引数:$test8_recent_value  戻り値:$test8_recent_score
function test8_score($test8_recent_value) {
    if ($test8_recent_value == '') {
        $test8_recent_score = NULL;
    } else if ($test8_recent_value <= 11.99) {
        $test8_recent_score = 1;
    } else if ($test8_recent_value <= 12.99) {
        $test8_recent_score = 2;
    } else if ($test8_recent_value <= 13.99) {
        $test8_recent_score = 3;
    } else if ($test8_recent_value <= 14.99) {
        $test8_recent_score = 4;
    } else if ($test8_recent_value <= 15.99) {
        $test8_recent_score = 5;
    } else if ($test8_recent_value <= 16.99) {
        $test8_recent_score = 6;
    } else if ($test8_recent_value <= 17.99) {
        $test8_recent_score = 7;
    } else if ($test8_recent_value <= 18.99) {
        $test8_recent_score = 8;
    } else if ($test8_recent_value <= 19.99) {
        $test8_recent_score = 9;
    } else {
        $test8_recent_score = 10;
    }
    
    return $test8_recent_score;
}

// 関数名:test9_score(垂直飛び)  引数:$test9_recent_value  戻り値:$test9_recent_score
function test9_score($test9_recent_value) {
    if ($test9_recent_value == '') {
        $test9_recent_score = NULL;
    } else if ($test9_recent_value <= 44) {
        $test9_recent_score = 1;
    } else if ($test9_recent_value <= 49) {
        $test9_recent_score = 2;
    } else if ($test9_recent_value <= 54) {
        $test9_recent_score = 3;
    } else if ($test9_recent_value <= 59) {
        $test9_recent_score = 4;
    } else if ($test9_recent_value <= 64) {
        $test9_recent_score = 5;
    } else if ($test9_recent_value <= 69) {
        $test9_recent_score = 6;
    } else if ($test9_recent_value <= 74) {
        $test9_recent_score = 7;
    } else if ($test9_recent_value <= 79) {
        $test9_recent_score = 8;
    } else if ($test9_recent_value <= 84) {
        $test9_recent_score = 9;
    } else {
        $test9_recent_score = 10;
    }
    
    return $test9_recent_score;
}

// 関数名:test10_score(背筋力)  引数:$test10_recent_value  戻り値:$test10_recent_score
function test10_score($test10_recent_value) {
    if ($test10_recent_value == '') {
        $test10_recent_score = NULL;
    } else if ($test10_recent_value <= 109) {
        $test10_recent_score = 1;
    } else if ($test10_recent_value <= 119) {
        $test10_recent_score = 2;
    } else if ($test10_recent_value <= 129) {
        $test10_recent_score = 3;
    } else if ($test10_recent_value <= 149) {
        $test10_recent_score = 4;
    } else if ($test10_recent_value <= 169) {
        $test10_recent_score = 5;
    } else if ($test10_recent_value <= 189) {
        $test10_recent_score = 6;
    } else if ($test10_recent_value <= 209) {
        $test10_recent_score = 7;
    } else if ($test10_recent_value <= 229) {
        $test10_recent_score = 8;
    } else if ($test10_recent_value <= 250) {
        $test10_recent_score = 9;
    } else {
        $test10_recent_score = 10;
    }
    
    return $test10_recent_score;
}

// 関数名:test11_score(握力)  引数:$test11_recent_value  戻り値:$test11_recent_score
function test11_score($test11_recent_value) {
    if ($test11_recent_value == '') {
        $test11_recent_score = NULL;
    } else if ($test11_recent_value <= 29) {
        $test11_recent_score = 1;
    } else if ($test11_recent_value <= 34) {
        $test11_recent_score = 2;
    } else if ($test11_recent_value <= 39) {
        $test11_recent_score = 3;
    } else if ($test11_recent_value <= 44) {
        $test11_recent_score = 4;
    } else if ($test11_recent_value <= 49) {
        $test11_recent_score = 5;
    } else if ($test11_recent_value <= 54) {
        $test11_recent_score = 6;
    } else if ($test11_recent_value <= 59) {
        $test11_recent_score = 7;
    } else if ($test11_recent_value <= 65) {
        $test11_recent_score = 8;
    } else if ($test11_recent_value <= 70) {
        $test11_recent_score = 9;
    } else {
        $test11_recent_score = 10;
    }
    
    return $test11_recent_score;
}

// 関数名:test12_score(サイドステップ)  引数:$test12_recent_value  戻り値:$test12_recent_score
function test12_score($test12_recent_value) {
    if ($test12_recent_value == '') {
        $test12_recent_score = NULL;
    } else if ($test12_recent_value <= 29) {
        $test12_recent_score = 1;
    } else if ($test12_recent_value <= 36) {
        $test12_recent_score = 2;
    } else if ($test12_recent_value <= 40) {
        $test12_recent_score = 3;
    } else if ($test12_recent_value <= 44) {
        $test12_recent_score = 4;
    } else if ($test12_recent_value <= 48) {
        $test12_recent_score = 5;
    } else if ($test12_recent_value <= 52) {
        $test12_recent_score = 6;
    } else if ($test12_recent_value <= 55) {
        $test12_recent_score = 7;
    } else if ($test12_recent_value <= 59) {
        $test12_recent_score = 8;
    } else if ($test12_recent_value <= 62) {
        $test12_recent_score = 9;
    } else {
        $test12_recent_score = 10;
    }
    
    return $test12_recent_score;
}

