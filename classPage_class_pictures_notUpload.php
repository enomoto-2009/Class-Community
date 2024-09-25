<?php require_once "functions.php";
if(empty($_SESSION["id"])) {
    header("Location:{$url}index.php");
    exit;
}
$student_id = $_SESSION["id"];
$login_id = $_SESSION["id"];
if(empty($_GET["g"]) || empty($_GET["c"])) {
    header("Location:{$url}schoolpage.php");
    exit;
}
$class = empty($_GET["c"])? "": $_GET["c"];
$grade = empty($_GET["g"])? "": $_GET["g"];
$get_user_sql = "select * from login inner join class on class.id = class_id inner join grade on grade.id = grade_id where login.id = :login_id";
    // $statement = get_db()->query($get_user_sql);
    // $users_db = $statement->fetchAll(PDO::FETCH_ASSOC);
    $datas = [":login_id" => $login_id];
    $users_db = get_query($get_user_sql,$datas,true);
    $users = array_column($users_db,"name","id");
    $grades = empty($_GET["g"])? "$users_db[0]['grade_number']": $_GET["g"];
    $classes = empty($_GET["c"])? "$users_db[0]['class_number']": $_GET["c"];
    $get_user_sql = "select * from tweet inner join class on class.id = class inner join grade on grade.id = grade where grade_number = :grades and class_number = :classes";
$datas = [":grades" => $grades,":classes" => $classes];
$users_db = get_query($get_user_sql,$datas,true);
global $login_user;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage-class-member.css">
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage-class-pictures.css">
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage_class_pictures_notUpload.css">
    <title>Class Community--classpage_class_pictures</title>
    <?php include "parts/head.php"; ?>
</head>
<body>
<?php include "parts/header.php"; ?>
    <div class="container">
        <aside>
            <?php include "parts/aside.php"; ?>
        </aside>
        <main class="main">
            <div class="class_members">
                <div class="classTitle">
                    <h2 class="classTitleName">中等<?php echo $_GET["g"]; ?>年<?php echo $_GET["c"]; ?>組</h2>
                </div>
                <div class="classWraper">
                    <div class="classMenu">
                    <div class="listClass__button1 classMember">
                        <button type="button" class="listClassMenu__button listClassMenu__button--classMember"><i class="fa-solid fa-user-group"></i><a href="./classpage_class_member.php?g=<?php echo$_GET["g"];?>&c=<?php echo $_GET["c"];?>" class="">クラスメンバー</a></button>
                    </div>
                    <div class="listClass__button1">
                        <button type="button" class="listClassMenu__button listClassMenu__button--wacthPicture"><i class="fa-regular fa-images"></i><a href="./classPage_class_pictures_notUpload.php" class="">クラスの写真</a></button>
                    </div>
                    <div class="listClass__button1">
                        <button type="button" class="listClassMenu__button listClassMenu__button--learningRecords"><i class="fa-solid fa-clipboard"></i><a href="" class="">クラスの学習記録</a></button>
                    </div>
            </div>
            <div class="classMembers">
                <?php foreach($users_db as $user): ?>
                    <div class="class_member">
                        <p class="class_member_name"><?php echo $user["user_name"]; ?></p>
                        <img src="<?=$user["image_type"] ?>" alt="" class="class_picture">
                        <div class="class_member__message">
                            <p class="class_member_introduce">タイトル:</p><?php echo $user["text"]; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
</html>