<?php 
	session_start();
	
	$id = $_POST['id'];
	$qty = $_POST['qty'];

	$duplicate = false;

	// var_dump(array('id' => $id, 'qty' => $qty));
	// var_dump($id, $qty);

	// $_SESSION['datatrial'] = $data;

	foreach($_SESSION['cart'] as $key => $cart_item) {
		if ($cart_item['id'] == $id) {
			$duplicate = true;

			$_SESSION['cart'][$key]['qty'] += $qty;
		} 
	}

	if ($duplicate == false) {
		array_push($_SESSION['cart'], array('id' => $id, 'qty' => $qty));
	}

	$cartQuantity = 0;

	foreach($_SESSION['cart'] as $key => $cart_item) {
		$cartQuantity += $cart_item['qty'];
	}

	$_SESSION['cartQuantity'] = $cartQuantity;

	echo $cartQuantity;

	
?>