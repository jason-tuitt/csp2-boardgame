<?php 
	require_once('./connect.php');
	session_start();
	

	// $_SESSION['wishlistQuantity'];
	$user_id = $_SESSION['user_data']['id'];
	$response_data = array();
	$wishlist = $_SESSION['wishlist'];


	// foreach($wishlist as $id) {
	// 	$sql = "SELECT id, name, item_image, price from items where id = $id";
	// 	$result = mysqli_query($conn, $sql);

	// 	$row = mysqli_fetch_assoc($result);

	// 	array_push($response_data, $row);
	// }

	$sql = "SELECT w.user_id, i.id, i.name, i.item_image, i.price from wishlists as w JOIN items as i ON i.id = w.item_id where user_id = $user_id";
	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result)) {
		array_push($response_data, $row);
	}

	echo json_encode($response_data);