<?php 
	require_once('./connect.php');
	session_start();

	$item_id = $_POST['id'];

	$sql = "DELETE from items where id = $item_id";

	$result = mysqli_query($conn, $sql);

	echo json_encode('Successfully Deleted');