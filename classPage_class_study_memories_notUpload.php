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

$get_username_sql = "select * from login inner join class on class.id = class_id inner join grade on grade.id = grade_id where grade_number = :grades and class_number = :classes";
$username_datas = [":grades" => $grades,":classes" => $classes];
$usernames_db = get_query($get_username_sql,$username_datas,true);

// $get_tweets_sql = "select * from tweet_study inner join class on class.id = class_id inner join grade on grade.id = grade_id where grade_number = :grades and class_number = :classes and name = '$sql_username'";
//     $datas = [":grades" => $grades,":classes" => $classes];
//     $tweets_db = get_query($get_tweets_sql,$datas,true);

global $login_user;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage_class.css">
    <link rel="stylesheet" href="<?=$url;?>assets/css/class_study_notUpload.css" class=""> 
    <title>Class Community--classpage_class_study</title>
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
            <?php include "parts/classpage.php"; ?>
            <?php foreach($usernames_db as $username): ?>
                <div class="username">
                <p class="" style="color:rgb(187 181 181 / 20%);">user</p>
                <a class="class_member_name" href="find_students.php?search_keyword=<?php echo $username['name']; ?>" style="text-decoration: underline"><?php echo $username["name"]; ?></a>
                <?php
                $grades = empty($_GET["g"])? "$users_db[0]['grade_number']": $_GET["g"];
                $classes = empty($_GET["c"])? "$users_db[0]['class_number']": $_GET["c"];
                $sql_username = $username["name"];
                $get_tweets_sql = "select * from tweet_study inner join class on class.id = class inner join grade on grade.id = grade where grade_number = :grades and class_number = :classes and user_name = '$sql_username'";
                $datas = [":grades" => $grades,":classes" => $classes];
                $sql_datas = array_filter($datas, function ($e) { return !is_array($e); });
                $tweets_db = get_query($get_tweets_sql,$sql_datas,true);
                ?>
                <div class="class_member_wrap">
                    <?php foreach($tweets_db as $tweet): ?>
                        <div class="class_member">
                        <p class="class_member_date"><?php echo $tweet["date"]; ?></p>
                            <img src="<?=$tweet["img_type"] ?>" alt="" class="class_picture">
                            <div class="class_member__message">
                                <p class="class_member_introduce">詳細:<?php echo $tweet["img_text"]; ?></p>
                                <p class="class_member_introduce">科目:<?php echo $tweet["subject"]; ?></p>
                                <p class="class_member_introduce">学習時間:<?php echo $tweet["study_time"]; ?></p>
                                <a class="class_details_link" style="text-decoration: underline">詳細を見る</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
                </div>
        </main>
    </div>
</body>
</html>