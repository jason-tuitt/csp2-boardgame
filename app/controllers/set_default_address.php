<?php 
	require_once('./connect.php');
	session_start();

	$address_id = $_POST['address_id'];
	$address_type_id = $_POST['address_type_id'];

	$id = $_SESSION['user_data']['id'];

	$sql_setzero = "UPDATE addresses SET default_add = 0 WHERE user_id = $id AND address_type_id = $address_type_id";

	$result_setzero = mysqli_query($conn, $sql_setzero);

	$sql_setdefault = "UPDATE addresses SET default_add = 1 WHERE id = $address_id";
	$result_setdefault = mysqli_query($conn, $sql_setdefault);

	echo $sql_setzero;
	echo $sql_setdefault;

	// echo $result;