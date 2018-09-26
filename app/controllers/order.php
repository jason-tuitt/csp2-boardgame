<?php 
	require_once('./connect.php');
	session_start();
	require './generate_transaction_number.php';
// include './generate_transaction_number.php';

	$payment_method = $_POST['paymentMethod'];
	$timestamp = date("Y-m-d H:i:s");
	$referenceNumber = referenceNumberGenerator();


	$id = $_SESSION['user_data']['id'];

	$sql = "INSERT INTO orders (order_timestamp, status_id, transaction_num, user_id, payment_method) VALUES ('$timestamp', 1, '$referenceNumber', $id, $payment_method)";

	$result = mysqli_query($conn, $sql);

	echo $sql;
	echo '<hr>';
	// echo $result;
	echo $result;
	echo '<hr>';
	echo gettype($timestamp);




