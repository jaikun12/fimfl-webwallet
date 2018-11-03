<?php
include("dbinclude.php");
session_start();
$username = $_SESSION['username'];
$address = $_SESSION['address'];
$payment_id = $_POST['payment_id'];
$amountbig = $_POST['amount'];
$feebig = 0.01;
$address_to = $_POST['receiver'];
$amount = $amountbig * "100000000";
$fee = $feebig * "100000000";

$cmd = array(
	"method" => "sendTransaction",
	"params" => array(
		"anonymity" => 6,
		"fee" => $fee,
		"paymentId" => $payment_id,
		"addresses" => array(
			$address) ,
		"transfers" => array(
			array(
			 "amount" => $amount,
			 "address" => $address_to
			)
		)
	)
);

$cmd_string = json_encode($cmd, JSON_NUMERIC_CHECK);
$cmdInit = curl_init('http://127.0.0.1:8070/json_rpc');
curl_setopt($cmdInit, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($cmdInit, CURLOPT_POSTFIELDS, $cmd_string);
curl_setopt($cmdInit, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cmdInit, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json',
	'Content-Length: ' . strlen($cmd_string)
));
$result = curl_exec($cmdInit);
$det1 = json_decode($result, true);
$output = $det1['result']['transactionHash'];

$table = "transactions_table";
$check_transactions_table = mysqli_query($conn, "SHOW TABLES LIKE '".$table."'");
if(mysqli_num_rows($check_transactions_table) == 1){
	$create_transaction_query = mysqli_query($conn, "INSERT INTO transactions_table(payment_id,username,addressto,transactionHash,amount) VALUES('$payment_id', '$username', '$address_to', '$output', $amountbig);");
}
else{
	$create_users_table = mysqli_query($conn, "CREATE TABLE transactions_table (
										id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										payment_id VARCHAR(999) NOT NULL,
										username VARCHAR(60) NOT NULL,
										addressto VARCHAR(999),
										amount DOUBLE,
										transactionHash VARCHAR(100),
										transaction_date TIMESTAMP
										) ");
	$create_transaction_query = mysqli_query($conn, "INSERT INTO transactions_table(payment_id,username,addressto,transactionHash,amount) VALUES('$payment_id', '$username', '$address_to', '$output', $amountbig);");
}


?>

<html>
	<head>
		<link href="css/main.css" type="text/css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato|Raleway" rel="stylesheet"> 
	</head>
	<body id="send-body">
		<div id="send-content">
		<?php 
			if ($output != ""){
				echo "<h2>Payment Successfully Sent!</h2>";
				echo "<p>You successfully sent ".$amountbig." FIMFL Coins to the address: ".$address_to.".";
			}
			?>
			<br>
			<a href="home.php">Return to Home</a>
		</div>
	</body>
</html>