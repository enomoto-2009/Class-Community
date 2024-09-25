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
            <form name="upload-form" action="./classpage_class_pictures.php" method="post" enctype="multipart/form-data" class="form">
                <input type="hidden" name="max_size" value="209751">
                <p class="name"><?=$login_user["name"]?>さん</p>
                <p class="class"><?php echo $login_user["grade_id"]; ?>年<?php echo $login_user["class_id"]; ?>組</p><br>
                <p>アップロード画像を選択</p>
                    <input type="file" name="image1"><br>
                    <p class="">＊下記に写真の詳細を入力↓</p>
                    <div class="">
                        <textarea name="img_name" class="text" rows="7" cols="50" required></textarea>
                    </div><br>
                    <div class="upload_button">
                        <button type="submit" name="operation" value="upload" class="listMenu__button listMenu__button--introduce"><i class="fa-solid fa-upload"></i>アップロード</button>
                    </div>
            </form><br><br><br>
            <form class="mainTitle__textrareaForm" method="post" action="">
                <div class="mainTitle">
                    <h1 class="mainName__h1"><?php echo $login_user["name"]; ?>さん</h1>
                    <br>
                    <h2 class="mainName__h2"><?php echo $login_user["grade_id"]; ?>年<?php echo $login_user["class_id"]; ?>組</h2>
                    <p class="main__profile">プロフィール：<br>ここに自分の自己紹介を簡単に書いてください。<br>例えば、自分の趣味、SNSのアカウントなど<br>
＊このページはあなたのクラスページの中にあるクラスメンバーという項目に投稿されます。<br>
＊このページを投稿することによって学校内で新たなコミュニティを作ることができます。</p>
                        <textarea class="mainTitle__textrarea"  id="" name="profile" rows="7" cols="50" required>
                        </textarea>
                        <div class="listMenu__buttonLayout4">
                        <button type="submit" class="listMenu__button listMenu__button--class"><i class="fa-solid fa-plus"></i>クラスページに投稿</button>
                    </div>
            </form>
        </main>
    </div>
</body>
</html>