<?php require_once "functions.php"; ?>
<?php 
    $db = get_db();
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
        $get_user_sql = "select * from login inner join class on class.id = class_id inner join grade on grade.id = grade_id";
        $users_db = get_query($get_user_sql,null,true);
    }
    $users = array_column($users_db,"name","id");
    $class_users = array_column($users_db,"class_number","id");
    $grade_users = array_column($users_db,"grade_number","id");
    
    $get_grade_sql = "select * from grade";
    $grades = get_query($get_grade_sql,null,true);
    $get_class_sql = "select * from class";
    $classes = get_query($get_class_sql,null,true);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <?php include "parts/head.php"; ?>
    <link rel="stylesheet" href="<?= $url; ?>assets/css/find-students.css">
    <title>Class Community--find students</title>
</head>
<body>
<?php include "parts/header.php"; ?>
<div class="container">
    <aside>
        <?php include "parts/aside.php"; ?>
    </aside>
    <main class="main">
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
            <?php foreach($users_db as $user): ?>
            <div class="student">
                <div class="s_grade">
                    <div class="student_grade"><?php echo $user["grade_number"]; ?>年</div>
                </div>
                <div class="s_class">
                    <div class="student_class"><?php echo $user["class_number"]; ?>組</div>
                </div>
                <div class="s_name">
                    <a href="classpage_class_member.php?c=<?php echo $user["class_number"]; ?>&g=<?php echo $user["grade_number"]; ?>" class="student_name" style="text-decoration: underline"><?php echo $user["name"]; ?></a>
                </div>
                <div class="s_introduce">
                    <div class="student_introduce"><?php echo $user["profile"]; ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>
</body>
</html>