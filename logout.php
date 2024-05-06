<?php require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include "parts/head.php"; ?>
    <link rel="stylesheet" href="<?= $url; ?>assets/css/logout.css">
    <title>Class Community--logout</title>
</head>
<body>
<?php include "parts/header.php"; ?>
<main class="main">
    <p class="logout_message">ログアウトしました。</p>
</main>
    <div class="login_button">
        <button type="button" class="back_button"><a href="index.php" class="">戻る(ログイン画面へ)</a></button>
    </div>
</body>
</html>
<?php
if(empty($_SESSION["id"])) {
    header("Location:{$url}index.php");
    exit;
}
$_SESSION = [];
session_destroy();
?>