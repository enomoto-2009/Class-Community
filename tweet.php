<?php require_once "functions.php"; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include "parts/head.php"; ?>
    <link rel="stylesheet" href="<?= $url; ?>assets/css/tweet.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Class Community--tweet-page</title>
</head>
<body>
    <?php include "parts/header.php"; ?>
    <div class="container">
        <aside>
            <?php include "parts/aside.php"; ?>
        </aside>
        <main class="main">
            <form name="upload-form" action="./classpage_class_pictures.php" method="post" enctype="multipart/form-data" class="">
                <input type="hidden" name="max_size" value="209751">
                <p>アップロード画像を選択<br>
                    <input type="file" name="image1">
                    <p class=""><?php echo $login_user["grade_id"]; ?>年<?php echo $login_user["class_id"]; ?>組</p>
                    <p class=""><?=$login_user["name"]?>さん</p>
                    <input type="text" name="img_name" placeholder="text">
                    <button type="submit" name="operation" value="upload">アップロード</button>
                </p>
            </form>
        </main>
    </div>
</body>
</html>