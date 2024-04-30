<?php
$name = $_GET["name"];
$email = $_GET["email"];
$password = $_GET["password"];
$sql = "insert into login(name,email,password) values($name,$email,$password)";
echo $name;
"<br>";
echo $email;
"<br>";
echo $password;
?>