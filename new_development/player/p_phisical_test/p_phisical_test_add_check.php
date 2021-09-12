<!-- 
    p_phisical_test_add.phpからの入力情報をチェックし、遷移先を決定する。
    問題なし→p_phisical_test_add_done.phpへリダイレクト
    問題あり→エラーメッセージを出力し、戻るボタンでp_phisical_test_add.phpへ遷移
 -->

<?php
session_start();
session_regenerate_id(true);

// p_phisical_test_topからの情報をSESSIONで受け取る
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

// 自作の関数を呼び出す
require_once('../../function/function.php');
// POSTの中身をすべてサニタイズする
$post = sanitize($_POST);

// 入力内容の問題の有無をflgによって判定(問題なし:true、問題あり:false)
$flg = true;

// 10m走
if ($test1_boolean) {
    if ($post['10m走_value'] == '') {
        $flg = false;
    } else {
        $test1_value = $post['10m走_value'];
    }
} else {
    $test1_value = 0;
}

// 20m走
if ($test2_boolean) {
    if ($post['20m走_value'] == '') {
        $flg = false;
    } else {
        $test2_value = $post['20m走_value'];
    }
} else {
    $test2_value = 0;
}

// 30m走
if ($test3_boolean) {
    if ($post['30m走_value'] == '') {
        $flg = false;
    } else {
        $test3_value = $post['30m走_value'];
    }
} else {
    $test3_value = 0;
}

// 50m走
if ($test4_boolean) {
    if ($post['50m走_value'] == '') {
        $flg = false;
    } else {
        $test4_value = $post['50m走_value'];
    }
} else {
    $test4_value = 0;
}

// 1500m走
if ($test5_boolean) {
    if ($post['1500m走_min_value'] == '' || $post['1500m走_sec_value'] == '') {
        $flg = false;
    } else {
        $test5_value = $post['1500m走_min_value'] * 60 + $post['1500m走_sec_value'];
    }
} else {
    $test5_value = 0;
}

// プロアジリティ
if ($test6_boolean) {
    if ($post['プロアジリティ_value'] == '') {
        $flg = false;
    } else {
        $test6_value = $post['プロアジリティ_value'];
    }
} else {
    $test6_value = 0;
}

// 立ち幅跳び
if ($test7_boolean) {
    if ($post['立ち幅跳び_value'] == '') {
        $flg = false;
    } else {
        $test7_value = $post['立ち幅跳び_value'];
    }
} else {
    $test7_value = 0;
}

// メディシンボール投げ
if ($test8_boolean) {
    if ($post['メディシンボール投げ_value'] == '') {
        $flg = false;
    } else {
        $test8_value = $post['メディシンボール投げ_value'];
    }
} else {
    $test8_value = 0;
}

// 垂直飛び
if ($test9_boolean) {
    if ($post['垂直飛び_value'] == '') {
        $flg = false;
    } else {
        $test9_value = $post['垂直飛び_value'];
    }
} else {
    $test9_value = 0;
}

// 背筋力
if ($test10_boolean) {
    if ($post['背筋力_value'] == '') {
        $flg = false;
    } else {
        $test10_value = $post['背筋力_value'];
    }
} else {
    $test10_value = 0;
}

// 握力
if ($test11_boolean) {
    if ($post['握力_value'] == '') {
        $flg = false;
    } else {
        $test11_value = $post['握力_value'];
    }
} else {
    $test11_value = 0;
}

// サイドステップ
if ($test12_boolean) {
    if ($post['サイドステップ_value'] == '') {
        $flg = false;
    } else {
        $test12_value = $post['サイドステップ_value'];
    }
} else {
    $test12_value = 0;
}


if ($flg) {             // 入力に問題がなかった場合
    $_SESSION['test1_value'] = $test1_value;            // セッション変数に10m走の記録を保持
    $_SESSION['test2_value'] = $test2_value;            // セッション変数に20m走の記録を保持
    $_SESSION['test3_value'] = $test3_value;            // セッション変数に30m走の記録を保持
    $_SESSION['test4_value'] = $test4_value;            // セッション変数に50m走の記録を保持
    $_SESSION['test5_value'] = $test5_value;            // セッション変数に1500m走の記録を保持
    $_SESSION['test6_value'] = $test6_value;            // セッション変数にプロアジリティの記録を保持
    $_SESSION['test7_value'] = $test7_value;            // セッション変数に立ち幅跳びの記録を保持
    $_SESSION['test8_value'] = $test8_value;            // セッション変数にメディシンボール投げの記録を保持
    $_SESSION['test9_value'] = $test9_value;            // セッション変数に垂直飛びの記録を保持
    $_SESSION['test10_value'] = $test10_value;          // セッション変数に背筋力の記録を保持
    $_SESSION['test11_value'] = $test11_value;          // セッション変数に握力の記録を保持
    $_SESSION['test12_value'] = $test12_value;          // セッション変数にサイドステップの記録を保持
    header('Location:p_phisical_test_add_done.php');    // p_phisical_test_add_done.phpへリダイレクト
    exit();
} else {                // 入力に問題があった場合
    print 'フィジカルテストの記録について入力漏れがあります<br><br>';
    print '<input type="button" onclick="location.href=\'p_phisical_test_add.php\'" value="戻る">';
}
