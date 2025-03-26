<?php require_once "functions.php";

$error_password_message = "";
if(!empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["school_id"])) {
    $error_message = "";
    $email = $_POST["email"];
    $password = $_POST["password"];
    $school_id = $_POST["school_id"];
    get_db();
    //SQL文の定義
    $sql = "SELECT * FROM login WHERE email = :email";
    $datas = [":email" => $_POST["email"]];
    $result = get_query($sql,$datas,false);
    $sql_school_id = "select * from school where school_id = :school_id";
    $datas_school_id = [":school_id" => $_POST["school_id"]];
    $result_school_id = get_query($sql_school_id,$datas_school_id,false);
    if( !$result ) {
        $error_message .= "無効なユーザーです";
    }
    //パスワードが一致するか
    if ( $_POST['password'] === $result['password'] && $_POST["school_id"] === $result_school_id["school_id"] ) {
        $_SESSION["id"] = $result["id"];
        $_SESSION["email"] = $result["email"];
        header("Location:{$url}schoolpage.php");
        exit;
    } else {
        $error_password_message = "パスワードまたは学校IDが一致しません";
    }
}
$get_grade_sql = "select * from grade";
$grades = get_query($get_grade_sql,null,true);
$get_class_sql = "select * from class";
$classes = get_query($get_class_sql,null,true);
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
                <div class="login-formTitle">SIGN IN</div>
                <form action="" method="post" class="login-formInputs">
                    <h2 class="passwordTitle"></h2>
                    <input name="password" type="password" id="password" class="login_formInput login-password_formInput" rows="100" placeholder="パスワードを入力"></input>
                    <p class="error_password_message delate">パスワードが間違っています</p>
                    <input name="email" type="email" id="email" class="login_formInput login-email_formInput" rows="100" placeholder="メールアドレスを入力"></input>
                    <p class="error_email_message delate">メールアドレスが間違っています</p>
                    <input name="school_id" type="text" id="school_id" class="login_formInput login-school_id-formInput" rows="100" placeholder="学校IDを入力"></input>
                    <p class="error_message_password_school_id"><?php echo $error_password_message; ?></p>
                    <button type="button" class="login-form_false_Button">ログイン</button>
                </form>
                <button type="button" class="sub_text">パスワードを忘れた場合</button>
                <button type="button" class="sub_text create_link">新規ログイン</button>
                <div class="createMenu">
                    <h2 class="login-formTitle create-formTitle delate">CREATE ACCOUNT</h2>
                    <form action="./create.php" method="post" class="create-formInputs">
                        <input name="name" type="text" class="login_formInput create-name-formInput delate" rows="100" placeholder="名前を入力"></input>
                        <input name="password" type="password" class="login_formInput create-password-formInput delate" rows="100" placeholder="パスワードを入力"></input>
                        <input name="email" type="text" class="login_formInput create-email-formInput delate" rows="100" placeholder="メールアドレスを入力"></input>
                        <select name="grade_number" class="select create-school_id-formInput delate">
                            <option disabled selected value>学年</option>
                            <?php foreach($grades as $grade): ?>
                                <option class="option" value="<?php echo $grade["id"] ?>"><?php echo $grade["grade_number"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="class_number" class="select create-class_id-formInput delate">
                            <option disabled selected value>クラス</option>
                            <?php foreach($classes as $class): ?>
                                <option class="option" value="<?php echo $class["id"] ?>"><?php echo $class["class_number"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="login-form_false_Button create-form_false_Button delate">作成</button>
                    </form>
                </div>
                <button class="sub_text create-form-new_login delate">ログイン画面へ戻る</button>
            </div>
        </div>
    </main>
</body>
<script>
let class_login_button = document.querySelector(".login-form_false_Button");
function class_login_button_click(event) {
    let password = document.querySelector("#password");
    let email = document.querySelector("#email");
    let password_message = document.querySelector(".error_password_message.delate");
    let email_message = document.querySelector(".error_email_message.delate");
    let validation_error = 0;
    if(password.value == ""){
        password_message.classList.remove("delate");
        validation_error ++;
    }
    if(email.value == ""){
        email_message.classList.remove("delate");
        validation_error ++;
    }
    if(validation_error == 0){
        document.querySelector(".login-formInputs").submit();
    }
}
class_login_button.addEventListener("click",class_login_button_click);

let create_button = document.querySelector(".create_link");
function create_button_click(event) {
    let login_formTitle = document.querySelector(".login-formTitle");
    let login_password_formInput = document.querySelector(".login-password_formInput");
    let login_email_formInput = document.querySelector(".login-email_formInput");
    let login_form_false_Button = document.querySelector(".login-form_false_Button");
    let login_school_id_formInput = document.querySelector(".login-school_id-formInput");
    let sub_text = document.querySelector(".sub_text");
    let error_message_password_school_id = document.querySelector(".error_message_password_school_id");
    let create_formTitle = document.querySelector(".create-formTitle");
    let create_name_formInput = document.querySelector(".create-name-formInput");
    let create_password_formInput = document.querySelector(".create-password-formInput");
    let create_email_formInput = document.querySelector(".create-email-formInput");
    let create_form_false_Button = document.querySelector(".create-form_false_Button");
    let create_form_new_login = document.querySelector(".create-form-new_login");
    let create_school_id_formInput = document.querySelector(".create-school_id-formInput");
    let create_class_id_formInput = document.querySelector(".create-class_id-formInput");
    login_formTitle.classList.remove("open");
    login_formTitle.classList.add("delate");
    login_password_formInput.classList.remove("open");
    login_password_formInput.classList.add("delate");
    login_email_formInput.classList.remove("open");
    login_email_formInput.classList.add("delate");
    login_form_false_Button.classList.remove("open");
    login_form_false_Button.classList.add("delate");
    login_school_id_formInput.classList.remove("open");
    login_school_id_formInput.classList.add("delate");
    create_button.classList.remove("open");
    create_button.classList.add("delate");
    sub_text.classList.remove("open");
    sub_text.classList.add("delate");
    error_message_password_school_id.classList.remove("open");
    error_message_password_school_id.classList.add("delate");
    create_formTitle.classList.remove("delate");
    create_formTitle.classList.add("open");
    create_name_formInput.classList.remove("delate");
    create_name_formInput.classList.add("open");
    create_password_formInput.classList.remove("delate");
    create_password_formInput.classList.add("open");
    create_email_formInput.classList.remove("delate");
    create_email_formInput.classList.add("open");
    create_form_false_Button.classList.remove("delate");
    create_form_false_Button.classList.add("open");
    create_form_new_login.classList.remove("delate");
    create_form_new_login.classList.add("open");
    create_school_id_formInput.classList.remove("delate");
    create_school_id_formInput.classList.add("open");
    create_class_id_formInput.classList.remove("delate");
    create_class_id_formInput.classList.add("open");
}
create_button.addEventListener("click",create_button_click);

let back_button = document.querySelector(".create-form-new_login");
function back_button_click(event) {
    let login_formTitle = document.querySelector(".login-formTitle");
    let login_password_formInput = document.querySelector(".login-password_formInput");
    let login_email_formInput = document.querySelector(".login-email_formInput");
    let login_school_id_formInput = document.querySelector(".login-school_id-formInput");
    let login_form_false_Button = document.querySelector(".login-form_false_Button");
    let sub_text = document.querySelector(".sub_text");
    let error_message_password_school_id = document.querySelector(".error_message_password_school_id");
    let create_formTitle = document.querySelector(".create-formTitle");
    let create_name_formInput = document.querySelector(".create-name-formInput");
    let create_password_formInput = document.querySelector(".create-password-formInput");
    let create_email_formInput = document.querySelector(".create-email-formInput");
    let create_form_false_Button = document.querySelector(".create-form_false_Button");
    let create_form_new_login = document.querySelector(".create-form-new_login");
    let create_school_id_formInput = document.querySelector(".create-school_id-formInput");
    let create_class_id_formInput = document.querySelector(".create-class_id-formInput");
    login_formTitle.classList.remove("delate");
    login_formTitle.classList.add("open");
    login_password_formInput.classList.remove("delate");
    login_password_formInput.classList.add("open");
    login_email_formInput.classList.remove("delate");
    login_email_formInput.classList.add("open");
    login_school_id_formInput.classList.remove("delate");
    login_school_id_formInput.classList.add("open");
    login_form_false_Button.classList.remove("delate");
    login_form_false_Button.classList.add("open");
    create_button.classList.remove("delate");
    create_button.classList.add("open");
    sub_text.classList.remove("delate");
    sub_text.classList.add("open");
    error_message_password_school_id.classList.remove("delate");
    error_message_password_school_id.classList.add("open");
    create_formTitle.classList.remove("open");
    create_formTitle.classList.add("delate");
    create_name_formInput.classList.remove("open");
    create_name_formInput.classList.add("delate");
    create_password_formInput.classList.remove("open");
    create_password_formInput.classList.add("delate");
    create_email_formInput.classList.remove("open");
    create_email_formInput.classList.add("delate");
    create_form_false_Button.classList.remove("open");
    create_form_false_Button.classList.add("delate");
    create_form_new_login.classList.remove("open");
    create_form_new_login.classList.add("delate");
    create_school_id_formInput.classList.remove("open");
    create_school_id_formInput.classList.add("delate");
    create_class_id_formInput.classList.remove("open");
    create_class_id_formInput.classList.add("delate");
}
back_button.addEventListener("click",back_button_click);
</script>
</html>
