<?php 
	require_once('./connect.php');
	session_start();

	$userdata = $_SESSION['user_data']['id'];
	$subcategory = $_GET['data'];

	$sql ="SELECT $subcategory from users where id=$userdata";

	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	// $data = $row[$subcategory];

	echo json_encode($row);

	// echo json_encode($row);

