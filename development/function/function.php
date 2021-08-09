<?php

# 関数名:sanitize  引数:$_POST  戻り値:$_POSTをエスケープした値
# 説明:$_POSTで受け取ったすべての値をhtmlspecialchars関数でサニタイズする
function sanitize($before)            # 連想配列$_POSTを$beforeとして受け取る
{
    foreach ($before as $key => $value)    # $beforeの要素すべてについて繰り返し
    {
        $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');    # エスケープした値を連想配列$afterに格納、キーは$beforeと共通
    }
    return $after;                # $afterを戻り値として出力
}
