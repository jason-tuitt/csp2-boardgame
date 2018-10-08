<?php 
	require_once('./connect.php');
	session_start();

	$LIMIT = 25;
	$filter = $_GET['filter'];

	$protected_filter = str_replace(array("'", '"', ";"), '', $filter);

	// echo $protected_filter;

	// echo $filter;
	$filtered_items = array();

	$sql = "SELECT id, name, price, item_image, item_desc FROM items where name LIKE '%{$protected_filter}%' LIMIT 25";



	$result = mysqli_query($conn, $sql);


	while($row = mysqli_fetch_assoc($result)) {
		array_push($filtered_items, $row);
	}

	$data_response = array('login' => isset($_SESSION['user_data']), 'filter' => $filtered_items);

	echo json_encode($data_response);


	


