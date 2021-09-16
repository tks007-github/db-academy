# db-academy

【取組中】

【未完成】

【説明】
new_developmentディレクトリ

パスワード
→マスターパスワード:xxx、管理者パスワード:ccc

選手
→signup/p_signup/p_signup_login.htmlからマスターパスワードを使ってサインアップ

コーチ(管理者のアカウントは作成済み)
→coach/c_top/c_top.phpからログイン
→signup/c_signup/c_signup_login.htmlからマスターパスワードを使ってサインアップ(他のコーチを登録する場合)

パスワード(p_signup_top.php, p_signup_top_check.php, c_signup_top.php, c_signup_top_check.php, p_top_password_change.php, p_top_password_change_check.php, c_top_password_change.php, c_top_password_change_check.php, c_top_master_password_change.php, c_top_master_password_change_check.php)
半角英数字6文字以上14文字以内

【変更点】
1. パスワードについて半角英数字6文字以上14文字以内に制限
2. 管理者(coach)のフィジカルテスト画面から選手の記録情報の登録・編集が可能
3. 身体情報のグラフ、フィジカルテスト結果のグラフ、フィジカルテストの成績表を追加
※全体に対してリファクタリングを行ったので、変数名やアルゴリズムは大幅な変更あり

【技術的問題点】
1. 管理者(coach)のフィジカルテスト画面から選手の記録情報の登録・編集を一括で行うこと
   (入力済み選手一覧・未入力選手一覧から選手を選択してもらってから登録・編集画面に遷移する形で対応)
2. 成績表を1ページで収めることができない
   (折れ線グラフについては各項目毎にページ移動してグラフを表示する形で対応)