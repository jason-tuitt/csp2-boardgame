<?php 
	require_once('./connect.php');
	session_start();

	$id = $_SESSION['user_data']['id'];
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	$confirmnewpassword = $_POST['confirmnewpassword'];

	$encrypted = password_hash($newpassword, PASSWORD_BCRYPT);

	$sql = "SELECT * FROM users where id=$id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if (password_verify($oldpassword, $row['password'])) {
		if ($newpassword == $confirmnewpassword) {
			$sql_pass = "UPDATE users SET password = '$encrypted' where id = $id";
			$result_pass = mysqli_query($conn, $sql_pass);
			echo json_encode(2);
		} else {
			echo json_encode(1);
		}
	} else {
		echo json_encode(0);
	}