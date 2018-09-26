<?php 
	session_start();

	$id = $_POST['id'];
	$newQty = $_POST['qty'];

	// echo $id;
	// echo $newQty;

	foreach ($_SESSION['cart'] as $key => $item) {
		if($item['id'] == $id) {
			$old_qty = $item['qty'];
			$_SESSION['cart'][$key]['qty'] = $newQty;
		}
	}

	$_SESSION['cartQuantity'] = $_SESSION['cartQuantity'] - $old_qty + $newQty;

	echo json_encode($_SESSION['cartQuantity']);