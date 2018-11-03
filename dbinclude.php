<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fimflwebwallet";

// Check connection
$conn = mysqli_connect($servername, $username, $password);
$check_db = mysqli_select_db($conn, $dbname);
if(!$check_db){
  	$create_db = mysqli_query($conn, "CREATE DATABASE fimflwebwallet");
}
$selectdb = mysqli_select_db($conn, $dbname);
?>