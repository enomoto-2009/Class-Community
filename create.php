<?php
require_once "functions.php";
$db = get_db();
try{
    $sql = "insert into login(name,email,password,grade_id,class_id) values(:name,:email,:password,:grade_number,:class_number)";
    $param = [":name"=> $_POST["name"], ":email"=> $_POST["email"], ":password"=> $_POST["password"],":grade_number"=> $_POST["grade_number"],":class_number"=> $_POST["class_number"]];
    $statement = $db->prepare($sql);
    $statement->execute($param); 
}catch (PDOException $e) {
    echo "エラーが発生しました: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include "parts/head.php"; ?>
    <link rel="stylesheet" href="<?= $url; ?>assets/css/login.css">
    <script></script>
    <title>Class Community--login</title>
</head>
<body>
<?php include "parts/header.php"; ?>
    <main class="main">
        <div class="login-page">
            <div class="login-pageTitle">
                <h2 class="login-pageTitle-h2">WELCOME TO</h2>
                <br>
                <h1 class="login-pageTitle-h1">CLASS COMMUNITY</h1>
                <br>
                <h2 class="login-pageTitleExplanation">CLASS COMMUNITYを利用することによって<br>他クラスの学習記録、SNSを見る、<br>校内で新たなコミュニティを構築することが可能です。</h2>
            </div>
            <div class="login-pageTitle-email"></div>
        </div>
        <div class="sideMenu">
            <div class="login-form">
            <div class="createMenu">
                <h2 class="login-formTitle create-formTitle">アカウント情報確認</h2>
                <div class="check_text">学年、組</div>
                <div class="login_formInput"><?php echo $_POST["grade_number"]; ?>年<?php echo $_POST["class_number"]; ?>組</div>
                <div class="check_text">ユーザー名</div>
                <div class="login_formInput create-name-formInput"><?php echo $_POST["name"]; ?></div>
                <div class="check_text">パスワード</div>
                <div name="password" type="password" class="login_formInput"><?php echo $_POST["password"]; ?></div>
                <div class="check_text">メールアドレス</div>
                <div name="email" type="text" class="login_formInput"><?php echo $_POST["email"]; ?></div>
                <a href="./index.php" class="sub_text">ログイン画面へ戻る</a>
            </div>
        </div>
        </div>      
    </main>
</body>
</html>
