<?php require_once "functions.php"; ?>
<?php
if(empty($_SESSION["id"])) {
    header("Location:{$url}index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include "parts/head.php"; ?>
    <link rel="stylesheet" href="<?= $url; ?>assets/css/schoolPage.css">
    <title>Class Community--School Page</title>
</head>
<?php include "parts/header.php"; ?>
<div class="container">
    <aside>
        <?php include "parts/aside.php"; ?>
    </aside>
    <main class="main">
        <div class="main__contents">
            <div class="mainTitle">
                <h1 class="mainTitle__h1">桐蔭学園中等教育学校</h1>
                <ul class="mainTitle__ul">
                    <li class="mainTitle__li">場所       〒225-8502神奈川県横浜市青葉区鉄町1614番地 </li>
                    <li class="mainTitle__li">電話番号       045-971-1411</li>
                </ul>
                <a href="https://toin.ac.jp/ses/" class="mainTitle__link" style="text-decoration: underline">桐蔭学園中等教育学校のホームページはこちら</a>
            </div>
            <div class="mainMap"><iframe class="mainMap__frame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3245.4523853568967!2d139.52002462531647!3d35.56722443622909!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018f9dde300b9a3%3A0x6010bd7537604bad!2z5qGQ6JSt5a2m5ZyS5Lit562J5pWZ6IKy5a2m5qCh!5e0!3m2!1sja!2sjp!4v1693137586102!5m2!1sja!2sjp" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
        </div>
        <div class="main__image">
            <img class="mainVisual" src="<?= $url; ?>assets/img/shoolPage/toinlogo.jpg" alt="">
        </div>
    </main>
</div>
<body>
</body>
</html>