<?php 
	require_once('./connect.php');
	session_start();

	var_dump($_FILES);

	$item_id = $_SESSION['add_item_id'];

	$target_dir = "../assets/image/";
	$target_file = $target_dir . basename($_FILES["uploadimageadd"]["name"]);
	move_uploaded_file($_FILES["uploadimageadd"]["tmp_name"], $target_file);

	// var_dump($_FILES); 

	$sql = "UPDATE items SET item_image = '$target_file' where id = $item_id";

	$result = mysqli_query($conn, $sql);

	unset($_SESSION['add_item_id']);