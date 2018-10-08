<?php 
	session_start();
	
	$id = $_POST['id'];

	$duplicate = false;

	foreach($_SESSION['wishlist'] as $wish) {
		if ($wish == $id) {
			$duplicate = true;
		}
	}

	if ($duplicate == false) {
		array_push($_SESSION['wishlist'], $id);
	}

	$wishlistQuantity = count($_SESSION['wishlist']);

	$_SESSION['wishlistQuantity'] = $wishlistQuantity;

	echo $wishlistQuantity;
