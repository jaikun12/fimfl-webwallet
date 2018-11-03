<?php
include("dbinclude.php");
$username = $_POST["username"];
$password = $_POST["password"];
$password_md5 = md5($password);

$da = array("method" => "createAddress");
$da_string = json_encode($da);
$create_address = curl_init('http://127.0.0.1:8070/json_rpc');
        curl_setopt($create_address, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($create_address, CURLOPT_POSTFIELDS, $da_string);
        curl_setopt($create_address, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($create_address, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($da_string))
        );

$result2 = curl_exec($create_address);
$det1 = json_decode($result2, true);
$address = $det1['result']['address'];

$table = "users_table";
$check_registration_table = mysqli_query($conn, "SHOW TABLES LIKE '".$table."'");
if(mysqli_num_rows($check_registration_table) == 1){
	$create_user_query = mysqli_query($conn, "INSERT INTO users_table(username,password,address) VALUES('$username', '$password_md5', '$address');");
}
else{
	$create_users_table = mysqli_query($conn, "CREATE TABLE users_table (
										id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										username VARCHAR(30) NOT NULL,
										password VARCHAR(32) NOT NULL,
										address VARCHAR(999),
										reg_date TIMESTAMP
										) ");
	$create_user_query = mysqli_query($conn, "INSERT INTO users_table(username,password,address) VALUES('$username', '$password_md5', '$address');");
}

mysqli_close($conn);

?>

<html>
	<head>
	</head>
	<body>
		<h1>Registration is complete</h1>
		<p>Your username is: <?php echo $username; ?></p>
		<p>Your address is: <?php echo $address; ?></p>
		<p>Please remember your password and address.</p>
		<a href="index.php">Return to login</a>
	</body>
</html>