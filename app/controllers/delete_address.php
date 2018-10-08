<?php 
	require_once('./connect.php');
	session_start();

	$address_id = $_POST['id'];
	$user_id = $_SESSION['user_data']['id'];

	$sql = "SELECT id, default_add from addresses where id = $address_id and default_add = 1 and user_id=$user_id";

	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) != 0) {
		// echo $sql;
		echo json_encode(0);
	} else {
		$sql_delete = "DELETE from addresses where id = $address_id and user_id=$user_id";
		$result_delete = mysqli_query($conn, $sql_delete);
		echo json_encode(1);
		// echo $sql_delete;
	}
