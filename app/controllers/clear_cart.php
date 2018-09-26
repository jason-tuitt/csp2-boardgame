<?php 
	session_start();

	$_SESSION['cart'] = array();
	$_SESSION['cartQuantity'] = 0;

	header('Location: ../views/cart.php');

 ?>