<?php require_once "functions.php"; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include "parts/head.php"; ?>
    <link rel="stylesheet" href="<?= $url; ?>assets/css/new_login.css">
    <script></script>
    <title>Class Community--create_account</title>
</head>
<body>
<?php include "parts/header.php"; ?>
<main class="main">
<div class="sideMenu">
    <div class="login-form">
        <h2 class="login-formTitle">CREATE ACCOUNT</h2>
        <form action="" method="post" class="login-formInputs">
        <h2 class="passwordTitle"></h2>
        <input name="password" type="password" id="password" class="login-formInput" rows="100" placeholder="パスワードを入力"></input>
        <input name="email" type="text" id="email" class="login-formInput" rows="100" placeholder="メールアドレスを入力"></input>
        <button type="button" class="login-form_false_Button">アカウントを作成</button>
        </form>
        <div class="login-form-subText"><a href="./index.php" class="">ログイン画面へ戻る</a></div>
    </div>
</div>
</main>
</body>
</html>