<?php 
	require_once('./connect.php');
	session_start();

	$id = $_POST['id'];

	// echo "$id";
	// $updated_cart = array();

	foreach($_SESSION['cart'] as $key => $cart_item) {
		if ($cart_item['id'] == $id) {
			$qty = $_SESSION['cart'][$key]['qty'];
			unset($_SESSION['cart'][$key]);
		} else {
			// $sql_delete = "SELECT * FROM items where id = '$cart_item[id]'";
			// $result = mysqli_query($conn, $sql_delete);
			// $row = mysqli_fetch_assoc($result);
			// array_push($updated_cart, $row);
		}
	}


	$_SESSION['cartQuantity'] = $_SESSION['cartQuantity'] - $qty;




	echo json_encode($updated_cart);

	// $cart = $_SESSION['cart'];

	// var_dump($cart);

	// 

 ?>