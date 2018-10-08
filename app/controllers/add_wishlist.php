<?php 
	session_start();
	require_once('./connect.php');
	
	$user_id = $_SESSION['user_data']['id'];
	$id = $_POST['id'];


	$duplicate = false;

	$sql_check = "SELECT * from wishlists where user_id = $user_id";
	$result_check = mysqli_query($conn, $sql_check);

	while($row = mysqli_fetch_assoc($result_check)) {
		if ($row['item_id'] == $id) {
			$duplicate	= true;
		}
	}


	if ($duplicate == false) {
		$sql = "INSERT INTO wishlists(user_id, item_id) VALUES ($user_id, $id)";
		$result = mysqli_query($conn, $sql);
	}

	$sql_count = "SELECT count(*) from wishlists where user_id = $user_id";
	$result_count = mysqli_query($conn, $sql_count);
	$row = mysqli_fetch_assoc($result_count);

	$wq = (int)$row["count(*)"];

	$_SESSION['wishlistQuantity'] = $wq;

	echo $wq;

