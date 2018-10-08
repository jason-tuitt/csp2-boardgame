<?php 
	require_once('./connect.php');
	session_start();

	var_dump($_FILES);

	if (isset($_SESSION['update_item_id'])) {
		$item_id = $_SESSION['update_item_id'];

		$target_dir = "../assets/image/";
		$target_file = $target_dir . basename($_FILES["uploadimage"]["name"]);
		move_uploaded_file($_FILES["uploadimage"]["tmp_name"], $target_file);

		$sql = "UPDATE items SET item_image = '$target_file' where id = $item_id";

		$result = mysqli_query($conn, $sql);

		unset($_SESSION['update_item_id']);
	} 
	