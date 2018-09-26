<?php 
	require_once('../controllers/connect.php');
	session_start();

	$checkout_items = array();
	

	foreach($_SESSION['cart'] as $key => $cart_item) {
		$sql = "SELECT id, item_image, name, price FROM items where id='$cart_item[id]'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
	
		array_push($checkout_items, $row);
	}

	echo json_encode($checkout_items);
	// while($row = mysqli_fetch_assoc($result)) {
	// 	array_push($checkout_items, $row);
	// }


	// echo json_encode($checkout_items);