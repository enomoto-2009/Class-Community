<?php require_once "functions.php"; ?>
<?php
$student_id = $_SESSION["id"];
$db = get_db();
if(!empty($_POST["profile"])) {
    $sql = "UPDATE login SET profile = :profile WHERE id = :id";
    //SQLステートメントの準備
    $statement = $db->prepare($sql);
    $statement->bindValue(':id', $student_id);
    $statement->bindValue(':profile', $_POST["profile"]);
    //SQL実行
    $statement->execute();
    
    header("Location:{$url}find_students.php");
    
    exit;
    global $login_user;
}

?>
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
                <p class="mainName__h1">*クラスページに写真を投稿</p><br>
                <p>アップロード画像を選択</p>
                    <input type="file" name="image1"><br>
                    <p class="">＊下記に写真の詳細を入力↓</p>
                    <div class="">
                        <textarea name="img_name" class="text" rows="2" cols="50" required></textarea>
                    </div><br>
                    <div class="upload_button">
                        <button type="submit" name="operation" value="upload" class="listMenu__button listMenu__button--introduce"><i class="fa-solid fa-upload"></i>アップロード</button>
                    </div>
            </form><br>

            <form action="" method="post" class="form">
                <div class="main_title">
                    <h1 class="mainName__h1">*学習記録を投稿</h1>
                    <?php $now = new DateTime(); ?>
                    <h2 class="mainDate__h2"><?php echo $now->format("Y年m月d日") ?></h2>
                </div>
                <div class="subject">
                    <select name="subject" class="">
                        <option disabled selected value>科目を選択</option>
                        <?php foreach($subjects as $subject): ?>
                            <option class="option" value="<?php echo $subject["id"] ?>"><?php echo $subject["subject"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="text">
                    <textarea class="textrarea"  id="" name="profile" rows="3" cols="80" required>
                    </textarea>
                </div>
                <div class="picture">
                    <p>取り組んだ教材等の写真</p>
                    <input type="file" name="image1"><br>
                    <div class="upload_button">
                        <button type="submit" name="operation" value="upload" class="listMenu__button listMenu__button--introduce"><i class="fa-solid fa-upload"></i>アップロード</button>
                    </div>
                </div>
        </form><br>

            <form class="mainTitle__textrareaForm" method="post" action="">
                <div class="mainTitle">
                    <h1 class="mainName__h1">*自己紹介を変更</h1>
                    <p class="main__profile">プロフィール：<br>ここに自分の自己紹介を簡単に書いてください。<br>例えば、自分の趣味、SNSのアカウントなど<br>
＊このページはあなたのクラスページの中にあるクラスメンバーという項目に投稿されます。<br>
＊このページを投稿することによって学校内で新たなコミュニティを作ることができます。</p>
                        <textarea class="mainTitle__textrarea"  id="" name="profile" rows="2" cols="50" required>
                        </textarea>
                        <div class="listMenu__buttonLayout4">
                        <button type="submit" class="listMenu__button listMenu__button--class"><i class="fa-solid fa-plus"></i>クラスページに投稿</button>
                    </div>
            </form>
        </main>
    </div>
</body>
</html>