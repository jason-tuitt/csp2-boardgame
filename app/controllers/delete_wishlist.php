<?php 
	require_once('./connect.php');
	session_start();

	$user_id = $_SESSION['user_data']['id'];
	$id = $_POST['id'];

	$sql = "DELETE from wishlists where item_id = $id AND user_id = $user_id";
	$result = mysqli_query($conn, $sql);

	// foreach($_SESSION['wishlist'] as $key => $wish) {
	// 	if ($wish == $id) {
	// 		echo $_SESSION['wishlist'][$key];
	// 		unset($_SESSION['wishlist'][$key]);
	// 	} else {

	// 	}
	// }

	$_SESSION['wishlistQuantity'] = $_SESSION['wishlistQuantity'] - 1;

	echo json_encode($_SESSION['wishlistQuantity']);