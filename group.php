<?php require_once "functions.php"; ?>
<?php
if(empty($_SESSION["id"])) {
        header("Location:{$url}index.php");
        exit;
    }
    $db = get_db();
    global $login_user;
    if(empty($_GET["search_keyword"])) {
        $_GET["search_keyword"] = "";
    }
    if(!empty($_GET["search_keyword"] || !empty($_GET["grade_select"]) || !empty($_GET["class_select"]))) {
        $datas = [];
        $search_grade_sql = "";
        $search_class_sql = "";
        $search_keyword_sql = "";
        if(!empty($_GET["grade_select"])){
            $search_grade = $_GET["grade_select"];
            $search_grade_sql = " and grade_id = :grade";
            $datas[":grade"] = $search_grade;
        }
        if(!empty($_GET["class_select"])){
            $search_class = $_GET["class_select"];
            $search_class_sql = " and class_id = :class";
            $datas[":class"] = $search_class;
        }
        if(!empty($_GET["search_keyword"])){
            $keyword = $_GET["search_keyword"];
            $search_keyword_sql = " and (name LIKE :name or profile LIKE :profile)";
            $datas[":name"] = "%{$keyword}%";
            $datas[":profile"] = "%{$keyword}%";
        }
        $get_user_sql = "select * from login inner join class on class.id = class_id inner join grade on grade.id = grade_id where 1";
        // $datas = [":name" => "%".$_GET['search_keyword']."%",":profile" => "%".$_GET['search_keyword']."%"];
        if($search_grade_sql !== "") {
            $get_user_sql .= $search_grade_sql;
        }
        if($search_class_sql !== "") {
            $get_user_sql .= $search_class_sql;
        }
        if($search_keyword_sql !== "") {
            $get_user_sql .= $search_keyword_sql;
        }
        $users_db = get_query($get_user_sql,$datas,true);
        // $users = array_column($users_db,"name","id");
    }else{
        $get_user_sql = "select * from login";
        $users_db = get_query($get_user_sql,null,true);
    }
    $users = array_column($users_db,"name","id");
    
    $get_grade_sql = "select * from grade";
    $grades = get_query($get_grade_sql,null,true);
    $get_class_sql = "select * from class";
    $classes = get_query($get_class_sql,null,true);

    $login_user_id = $login_user["id"];
    $select_sql = "select group_name,sender_id from invitation where receiver_id = $login_user_id";
    $selecters = get_query($select_sql,null,true);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- <?php include "parts/head.php"; ?> -->
    <!-- <link rel="stylesheet" href="<?= $url; ?>assets/css/group.css"> -->
    <title>Class Community--create groups</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .hobby {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<?php include "parts/header.php"; ?>
<div class="container">
    <aside>
        <?php include "parts/aside.php"; ?>
    </aside>
    <main class="main">
        <p class="">コミュニティを作る</p>
        <form action="" method="get">
            <div class="find-student">
            <div class="select">
                <div class="grades">
                    <select name="grade_select">
                        <option disabled selected value>学年</option>
                        <?php foreach($grades as $grade): ?>
                            <option value="<?php echo $grade["id"] ?>"><?php echo $grade["grade_number"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="classes">
                    <select name="class_select">
                        <option disabled selected value>クラス</option>
                        <?php foreach($classes as $class): ?>
                            <option value="<?php echo $class["id"] ?>"><?php echo $class["class_number"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
                <div class="find-student-input">
                    <input name="search_keyword" type="text" size="85" class="searchBox" placeholder="キーワードを入力"></input>
                </div>
                <div class="find-student-box">
                    <button type="submit" class="listMenu__button listMenu__button--find-student"><i class="fa-solid fa-magnifying-glass"></i>探す</button>
                </div>
            </div>
        </form>
        <div class="menu_wraper">
            <div class="menu">
                <div class="grade">
                    <div class="top menu_grade">学年</div>
                </div>
                <div class="class">
                    <div class="top menu_class">クラス</div>
                </div>
                <div class="name">
                    <div class="top menu_name">名前</div>
                </div>
                <div class="introduce">
                    <div class="top menu_introduce">自己紹介</div>
                </div>
            </div>
            <form action="./send_invitation.php" method="post">
                <?php foreach($users_db as $user): ?>
                <div class="student"> 
                    <div class="s_grade">
                        <div class="student_grade"><?php echo $user["grade_id"]; ?>年</div>
                    </div>
                    <div class="s_class">
                        <div class="student_class"><?php echo $user["class_id"]; ?>組</div>
                    </div>
                    <div class="s_name">
                        <input type="checkbox" name="selected_users[]" value="<?php echo $user['id']; ?>" id="user_<?php echo $user['id']; ?>">
                        <label for="user_<?php echo $user['id']; ?>" class="student_name" style="text-decoration: underline"><?php echo $user["name"]; ?></label>
                    </div>
                    <div class="s_introduce">
                        <div class="student_introduce"><?php echo $user["profile"]; ?></div>
                    </div> 
                </div>
                <?php endforeach; ?>
                <input type="text" name="group_name" placeholder="グループ名">
                <button type="submit"class="submit_button">送信</button>
            </form>
        </div>
        <div class="invitation_wraper">
            <p class="">あなたを招待しているグループ</p>
            <table class="">
                <tr>
                    <th class="">グループ</th><th class="">招待者</th>
                </tr>
            <?php foreach($users_db as $user): ?>
                <?php foreach($selecters as $selecter): ?>
                    <tr class="">
                        <th class=""><?php echo $selecter["group_name"]; ?></th><th class=""><?php echo $selecter["sender_id"]; ?></th>
                    </tr>
                </table>
                <?php endforeach; ?>
            <?php endforeach; ?>    
        </div>
    </main>
    </div>
</body>
</html>
