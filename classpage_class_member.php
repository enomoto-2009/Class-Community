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
    $get_user_sql = "select * from login inner join class on class.id = class_id inner join grade on grade.id = grade_id where grade_number = :grades and class_number = :classes";
$datas = [":grades" => $grades,":classes" => $classes];
$users_db = get_query($get_user_sql,$datas,true);
global $login_user;
$c = $_GET["c"];
$g = $_GET["g"];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php include "parts/head.php"; ?>
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage_class.css">
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage_class_member.css">
</head>
<body>
<?php include "parts/header.php"; ?>
<div class="container">
    <aside>
        <?php include "parts/aside.php"; ?>
    </aside>
    <main class="main">
        <?php include "parts/classpage.php"; ?>
            <?php foreach($users_db as $user): ?>
            <div class="class_member">
                <p class="" style="color:rgb(187 181 181 / 20%);">user</p>
                <a class="class_member_name" href="./find_students.php" style="text-decoration: underline"><?php echo $user["name"]; ?></a>
                <p class=""style="color:rgb(187 181 181 / 20%);">text</p>
                <div class="class_member__message">
                    <p class="class_member_introduce">自己紹介:</p><?php echo $user["profile"]; ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </main>
</div>
</body>
</html>