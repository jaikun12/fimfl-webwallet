<html>
	<head>
		<link href="css/main.css" type="text/css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato|Raleway" rel="stylesheet"> 
	</head>
	<body>
		<?php session_start();
			$da8 = array("method" => "getBalance", "params" => array('address' => $_SESSION['address']));
			//$dat = array("method" => "createAddress");
			$da8_string = json_encode($da8);

			$kech8 = curl_init('http://localhost:8070/json_rpc');
			curl_setopt($kech8, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($kech8, CURLOPT_POSTFIELDS, $da8_string);
			curl_setopt($kech8, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($kech8, CURLOPT_HTTPHEADER, array(
 	    	'Content-Type: application/json',
	    	'Content-Length: ' . strlen($da8_string))
				);
			$getBalance_result = curl_exec($kech8);
			$balanceJson = json_decode($getBalance_result, true);
			$balance = $balanceJson['result']['availableBalance'];
			$normalbalance = $balance / "100000000";
		?>
		<div id="home-body">
			<a class="logout-btn" href="logout.php">Logout</a>
			<div id="balance-info-section">
				<h2>Welcome <?php echo $_SESSION['username']; ?></h2>
				<p>your address is <?php echo $_SESSION['address']; ?></p>
				<div id="cur-balance">
					<h3>Current Balance</h3>
					<p><?php echo $normalbalance; ?></p>
				</div>
				<p>*Unconfirmed balances are not reflected. Please wait a moment to reflect.</p>
			</div>
			<div id="send-money-section">
				<form action="send.php" method="POST">
					<h2>Send FIMFL</h2>
					<p>Use this form to send FIMFL</p>
					<p><label for="payment_id">Payment ID: </label>
					<input type="text" name="payment_id"/>
					</p>
					<p><label for="receiver">Receiving Address: </label>
					<input type="text" name="receiver"/>
					</p>
					<p><label for="amount">Amount: </label>
					<input type="text" name="amount"/>
					</p>
					<p><label for="amount">Fixed Fee: </label>
					<input type="text" name="fee" value="0.01" disabled/>
					</p>
					<button type="submit">Send</button>
				</form>
			</div>
		</div>
	</body>
</html>