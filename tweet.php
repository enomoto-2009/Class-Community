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
$subject_sql = "SELECT * FROM subjects";
$subjects = get_query($subject_sql,null,true);

$get_study_time_sql = "select * from study_time";
$study_time = get_query($get_study_time_sql,null,true);
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
            <!-- 写真投稿フォーム -->
            <form name="upload-form" action="./classpage_class_pictures.php" method="post" enctype="multipart/form-data" class="form">
                <input type="hidden" name="max_size" value="209751">
                <p class="mainName__h1">*クラスページに写真を投稿する</p>
                <h1 class="mainName__h2"><?php echo $login_user["name"]; ?>さん</h1>
                <h2 class="mainName__h2"><?php echo $login_user["grade_id"]; ?>年<?php echo $login_user["class_id"]; ?>組</h2>
                <p class="">写真を添付↓</p>
                    <input type="file" name="image1"><br>
                    <p class="">＊下記に写真の詳細を入力</p>
                    <div class="">
                        <textarea name="img_name" class="text" rows="2" cols="50" required></textarea>
                    </div><br>
                    <div class="upload_button">
                        <button type="submit" name="operation" value="upload" class="listMenu__button listMenu__button--introduce"><i class="fa-solid fa-upload"></i>アップロード</button>
                    </div>
            </form><br>
            <!-- 学習記録の投稿フォーム -->
            <form action="./classpage_class_study_memories.php" method="post" class="form"  enctype="multipart/form-data">
                <div class="main_title">
                    <p class="mainName__h1">*学習記録を投稿する</p>
                    <h1 class="mainName__h2"><?php echo $login_user["name"]; ?>さん</h1>
                    <h2 class="mainName__h2"><?php echo $login_user["grade_id"]; ?>年<?php echo $login_user["class_id"]; ?>組</h2>
                </div>
                <div class="select">
                    <select name="subject" class="">
                        <option disabled selected value>科目を選択</option>
                        <?php foreach($subjects as $subject): ?>
                            <option class="option" value="<?php echo $subject["subject"] ?>"><?php echo $subject["subject"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="text">
                    <textarea class="textrarea"  id="" name="text" rows="3" cols="80" required>
                    </textarea>
                </div>
                <input type="date" name = "date" class="mainName__h2" value="学習した日" required></input>
                <div class="picture">
                    <p>取り組んだ教材等の写真↓</p>
                    <input type="file" name="image"><br>
                    <select name="study_time" class="listMenu__study_time">
                        <option disabled selected value>勉強時間を選択</option>
                        <?php foreach($study_time as $study): ?>
                            <option class="" value="<?php echo $study["study_time"] ?>"><?php echo $study["study_time"]; ?></option>
                        <?php endforeach; ?>
                </select>
                    <div class="upload_button">
                        <button type="submit" name="operation" value="upload" class="listMenu__button listMenu__button--introduce"><i class="fa-solid fa-upload"></i>アップロード</button>
                    </div>
                </div>
        </form><br>
        <!-- 自己紹介変更フォーム -->
            <form class="mainTitle__textrareaForm" method="post" action="">
                <div class="mainTitle">
                    <p class="mainName__h1">自己紹介を変更する</p>
                    <h1 class="mainName__h2"><?php echo $login_user["name"]; ?>さん</h1>
                    <h2 class="mainName__h2"><?php echo $login_user["grade_id"]; ?>年<?php echo $login_user["class_id"]; ?>組</h2>
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