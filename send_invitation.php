<?php
require_once "./functions.php";
$db = get_db();
global $login_user;

if(empty($_SESSION["id"])) {
    header("Location:{$url}index.php");
    exit;
}
$db = get_db();

$selected_users = isset($_POST['selected_users']) ? $_POST['selected_users'] : [];
$group_name = isset($_POST['group_name']) ? $_POST['group_name'] : '';
$creater_id = $login_user["id"];
$reaction = "pending";


if(empty($group_name) || empty($creater_id)) {
    header("Location:{$url}group.php");
    exit;
}

foreach($selected_users as $selected_user) {
    $insert_sql = "insert into invitation (group_name, sender_id, receiver_id, reaction) values(:group_name, :sender_id, :receiver_id, :reaction)";
    $parm = [":group_name" => $group_name, ":sender_id" => $creater_id, ":receiver_id" => $selected_user, ":reaction" => $reaction];
    $statement = $db->prepare($insert_sql);
    $statement->execute($parm);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<p class=""><?php echo $group_name; ?>のメンバーを招待しました。</p>
<button type="button"><a href="./group.php" class="">戻る</a></button>
</body>
</html>