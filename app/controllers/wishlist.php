<?php 
	require_once('./connect.php');
	session_start();
	

	// $_SESSION['wishlistQuantity'];

	$response_data = array();
	$wishlist = $_SESSION['wishlist'];

	foreach($wishlist as $id) {
		$sql = "SELECT id, name, item_image, price from items where id = $id";
		$result = mysqli_query($conn, $sql);

		$row = mysqli_fetch_assoc($result);

		array_push($response_data, $row);
	}

	echo json_encode($response_data);

	