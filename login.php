<?php
include("dbinclude.php");
$username = $_POST["username"];
$password = $_POST["password"];
$password_md5 = md5($password);

$check_account = mysqli_query($conn, "SELECT * FROM users_table WHERE username = '$username' and password = '$password_md5'");
if(mysqli_num_rows($check_account) < 1){

	header("Location: index.php");
}
else{
	session_start();
	$result = mysqli_fetch_assoc($check_account);
	$_SESSION["address"] = $result["address"];
	$_SESSION["username"] = $username;
	header("Location: home.php");
}


?>