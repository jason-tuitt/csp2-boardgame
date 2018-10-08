<?php 
	require_once('./connect.php');
	session_start();

	$id = $_POST['id'];

	foreach($_SESSION['wishlist'] as $key => $wish) {
		if ($wish == $id) {
			// echo $_SESSION['wishlist'][$key];
			unset($_SESSION['wishlist'][$key]);
		} else {

		}
	}

	$_SESSION['wishlistQuantity'] = $_SESSION['wishlistQuantity'] - 1;

	echo json_encode($_SESSION['wishlistQuantity']);