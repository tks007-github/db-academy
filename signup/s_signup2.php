<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>

<body>
    <?php
        # s_signup1.htmlから氏名を受け取る
	    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        # s_signup1.htmlからパスワードを受け取る
	    $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');
    ?>

    <h2>アンケート</h2>
    <br>
    <form method="post" action="s_signup_check.php">
        身長を入力してください。<br>
        <input type="text" name="height">cm<br>
        <br>
        体重を入力してください。<br>
        <input type="text" name="weight">kg<br>
        <br>
        <input type="hidden" name="name" value=<?php print $name; ?>>
        <input type="hidden" name="pass" value=<?php print $pass; ?>>
        <input type="submit" value="登録">
    </form>
</body>

</html>