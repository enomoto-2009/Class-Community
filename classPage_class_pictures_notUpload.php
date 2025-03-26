<?php require_once "functions.php";
$db = get_db();
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

$get_user_sql = "select login.id, name, class_number,grade_number from login inner join class on class.id = class_id inner join grade on grade.id = grade_id";
$statement = $db->query($get_user_sql);
$users_db = $statement->fetchAll(PDO::FETCH_ASSOC);
$users = array_column($users_db,"name","id");
$class_users = array_column($users_db,"class_number","id");
$grade_users = array_column($users_db,"grade_number","id");

$get_post_sql = "select * from tweet inner join class on class.id = class inner join grade on grade.id = grade where grade_number = :grades and class_number = :classes";
$datas = [":grades" => $grades,":classes" => $classes];
$posts_db = get_query($get_post_sql,$datas,true);
global $login_user;
// 返信
if(!empty($_POST["replay_message"])){
    $set_replay_sql = "insert into tweet_picture_replays(post_id,user_name,text,create_date) values (:post_id, :user_name, :text, now())";
    $param = [":post_id" => $_POST["post_id"], ":user_name" => $login_user["name"], ":text" => $_POST["replay_message"]];
    $statement = $db->prepare($set_replay_sql);
    $statement->execute($param);
}
function get_replay($post_id) {
    $db = get_db();
    $get_replay_sql = "select * from tweet_picture_replays where post_id = :post_id order by create_date desc";
    $statement = $db->prepare($get_replay_sql);
    $statement->bindValue(":post_id",$post_id);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage_class.css">
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage_class_pictures.css">
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
            <?php include "parts/classpage.php"; ?>
            <div class="classMembers">
                <?php foreach($posts_db as $post): ?>
                    <div class="class_member">
                        <p style="color:white;">ユーザー</p>
                        <a class="class_member_name" href="find_students.php?search_keyword=<?php echo $users[$post['user_name']]; ?>" style="text-decoration: underline"><?php echo $users[$post["user_name"]]; ?></a>
                        <p class="class_member_introduce">title:    <?php echo $post["img_text"]; ?></p>
                        <img src="<?=$post["image_type"] ?>" alt="" class="class_picture">
                    <div class="replay_wrapper">
                        <form action="" method="post" class="replay_form">
                            <p class="comment_message">コメントを書く：</p>
                            <textarea name="replay_message" class="replay_message" id="" cols="70" rows="2" required></textarea>
                            <input type="hidden" class="" name="post_id" value="<?php echo $post["post_id"]; ?>">
                            <button type="submit" class="listMenu__button_replay send_message_button">コメントを送信</button>
                        </form>
                        <div class="replay_comments">
                            <div class="replay_comments_display_button">
                                <button type="button" class="listMenu__button_replay display_message_button"><i class="fa-solid fa-arrow-down"></i>コメントを表示</button>
                            </div>
                            <div class="replay_comments_delate_button delate">
                                <button type="button" class="listMenu__button_replay delate_message_button delate"><i class="fa-solid fa-arrow-down"></i>コメントを非表示にする</button>
                            </div>
                            <?php $replays = get_replay($post["post_id"]); ?>
                            <div class="replay_comments_hide delate">
                                <?php foreach($replays as $replay): ?>
                                    <div class="replay_comment">
                                        <p class="replay_comment_date"><?php echo $replay["create_date"]; ?></p>
                                        <a href="find_students.php" class="replay_comment_name" style="text-decoration: underline"><?php echo $replay["user_name"]; ?></a>
                                        <p class="replay_comment_text"><?php echo $replay["text"]; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
<script>
    nextbutton.addEventListener("click",next_button_click);
    let replay_button = document.querySelectorAll(".display_message_button");
    function replay_button_click(event) {
        let replay_message_hide = event.target.closest(".replay_comments").querySelector(".replay_comments_hide");
        let replay_delate_button = event.target.closest(".replay_comments").querySelector(".delate_message_button.delate");
        replay_delate_button.classList.remove("delate");
        replay_delate_button.classList.add("open");
        event.target.classList.remove("open");
        event.target.classList.add("delate");
        replay_message_hide.classList.remove("delate");
        replay_message_hide.classList.add("open");
    }
    nextbutton.addEventListener("click",next_button_click);
    function replay_comments_delate_click(event) {
        let replay_comments_open = event.target.closest(".replay_comments").querySelector(".replay_comments_hide");
        let replay_open_button = event.target.closest(".replay_comments").querySelector(".display_message_button");
        replay_comments_open.classList.remove("open");
        replay_comments_open.classList.add("delate");
        event.target.classList.remove("open");
        event.target.classList.add("delate");
        replay_open_button.classList.remove("delate");
        replay_open_button.classList.add("open");
    }
    replay_button.forEach(function(element){
        element.addEventListener("click",replay_button_click);
    }); 
    replay_comments_delate.forEach(function(element){
        element.addEventListener("click",replay_comments_delate_click);
    }); 
</script>
</html>