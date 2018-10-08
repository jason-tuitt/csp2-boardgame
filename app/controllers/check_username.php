<?php 
	require_once('./connect.php');
	session_start();

	$username = $_GET['user'];

	$sql = "SELECT id, username from users where username = '$username'";
	$result = mysqli_query($conn, $sql);
	// echo $sql;

	if(mysqli_num_rows($result) > 0) {
		echo json_encode(0);
	} else {
		echo json_encode(1);
	}