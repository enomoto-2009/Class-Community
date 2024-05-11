<?php require_once "functions.php"; 
$student_id = $_SESSION["id"];
// //db接続情報
$db_name = "mysql:host=localhost; dbname=class_community;";
$db_username = "root";
$db_password = "";
if(empty($_SESSION["id"])) {
    header("Location:{$url}index.php");
    exit;
}
//db接続
try {
    $db = new PDO($db_name, $db_username, $db_password);
} catch ( PDOException $e) {
    //エラー処理
    $msg = $e->getMessage();
    echo "DB接続エラー__Error";
    echo $msg;
    exit;
}
//SQL文の定義
if(!empty($_POST["profile"])) {
    $sql = "UPDATE login SET profile = :profile WHERE id = :id";
    //SQLステートメントの準備
    $statement = $db->prepare($sql);
    $statement->bindValue(':id', $student_id);
    $statement->bindValue(':profile', $_POST["profile"]);
    //SQL実行
    $statement->execute();
    header("Location:{$url}schoolpage.php");
    
    exit;
    global $login_user;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php include "parts/head.php"; ?>
    <link rel="stylesheet" href="<?= $url; ?>assets/css/self-introduction.css">
    <title>Class Community--Self-Introduction</title>
</head>
<body>
<?php include "parts/header.php"; ?>
    <div class="container">
        <aside>
            <?php include "parts/aside.php"; ?>
        </aside>
        <main class="main">
            <div class="mainTitle">
                <h1 class="mainName__h1"><?php echo $login_user["name"]; ?>さん</h1>
                <br>
                <h2 class="mainName__h2"><?php echo $login_user["grade_id"]; ?>年<?php echo $login_user["class_id"]; ?>組</h2>
                <p class="main__profile">プロフィール：<br>ここに自分の自己紹介を簡単に書いてください。<br>例えば、自分の趣味、SNSのアカウントなど<br>
＊このページはあなたのクラスページの中にあるクラスメンバーという項目に投稿されます。<br>
＊このページを投稿することによって学校内で新たなコミュニティを作ることができます。</p>
                    <form class="mainTitle__textrareaForm" method="post" action="">
                    <textarea class="mainTitle__textrarea"  id="" name="profile" rows="12" cols="50" required>
                    </textarea>
                    <div class="listMenu__buttonLayout4">
                    <button type="submit" class="listMenu__button listMenu__button--class"><i class="fa-solid fa-plus"></i>クラスページに投稿</button>
                </div>
                    </form>
            </div>
        </main>
</body>
</html>