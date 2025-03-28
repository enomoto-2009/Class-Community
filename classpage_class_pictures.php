<?php
require_once("./functions.php");
// if(empty($_POST['img_name']) || ($_POST['user_name'])) {
//     echo "ユーザー名またはファイルを選択してください";
// }
if(empty($_SESSION["id"])) {
    header("Location:{$url}index.php");
}
$db = get_db();
function getExtension(string $file): string
{
    return pathinfo($file,PATHINFO_EXTENSION);
}
function validate(): array
{
    if($_FILES["image1"]["error"] !== UPLOAD_ERR_OK) {
        return [false,"アップロードエラーを検出しました"];
    }
    if(!in_array(getExtension($_FILES["image1"]["name"]),["jpg","jpeg","png","gif"])) {
        return [false,"画像ファイルのみアップデート可能です"];
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo,$_FILES["image1"]["tmp_name"]);
    finfo_close($finfo);
    if(!in_array($mimeType,["image/jpeg","image/png","image/gif"])) {
        return [false,"不正な画像ファイル形式です"];
    }
    if(filesize($_FILES["image1"]["tmp_name"]) > 1024 * 1024 *2) {
        return [false,"ファイルサイズは2mbまでとしてください"];
    }
    return[true,null];
}
function generateDestinationPath(): string
{
    return "uploaded/" . date("Ymd-His-") . rand(10000,99999) . "." .
    basename($_FILES["image1"]["name"]);
}
function escape(string $value): string
{
    return htmlspecialchars($value,ENT_QUOTES | ENT_HTML5,"UTF-8");
}
list($result,$message) = validate();
if($result !== true) {
    echo "[Error]",$message;
    return;
}
$destinationPath = generateDestinationPath();
$file_name = basename($_FILES["image1"]["name"]);
$moved = move_uploaded_file($_FILES["image1"]["tmp_name"],$file_name);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imgName = $_POST['img_name'];
    $userName = $login_user["id"];
    $user_grade = $login_user["grade_id"];
    $user_class = $login_user["class_id"];
}
// sql処理
try {
$sql = "INSERT INTO tweet (image_type, img_text, user_name,grade,class) VALUES (:image_type, :img_text, :user_name,:grade,:class)";
$param = [":image_type" => $file_name, ":img_text" => $_POST['img_name'], ":user_name" => $login_user["name"], ":grade" => $login_user["grade_id"], ":class" => $login_user["class_id"]];
$statement = $db->prepare($sql);
$statement->execute($param);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if($moved !== true) {
    echo "アップロード処理中にエラーが発生しました";
    return;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage-class-member.css">
    <link rel="stylesheet" href="<?= $url; ?>assets/css/classPage-class-pictures.css">
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
            <div class="picture">
                <p class="check_text">投稿内容確認</p>
                <p class="picture_name">投稿先:<?php echo $login_user["grade_id"]; ?>年<?php echo $login_user["class_id"]; ?>組</p>
                <p class="picture_name">投稿者:<?=$login_user["name"]?></p>
                <p class="picture_text">概要:<?=$imgName?></p>
                <img src="<?=basename($_FILES["image1"]["name"])?>" alt="" class="class_picture"><br>
            </div>
            <form action="./classPage_class_pictures_notUpload.php" method="get">
                    <select name="g" class="listMenu__classSelect">
                        <option class="option" value="<?=$user_grade ?>">学年：<?php echo $user_grade; ?>年</option>
                    </select>
                    <select name="c" class="listMenu__classSelect">
                        <option class="" value="<?=$user_class ?>">クラス：<?php echo $user_class; ?>組</option>
                    </select>
                <div class="listMenu__item button_back">
                    <button type="submit" class="listMenu__button listMenu__button--class"><i class="fa-solid fa-backward"></i>クラスページへ</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>