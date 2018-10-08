<?php 
	require_once('./connect.php');
	session_start();

	$item_id = $_POST['id'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$item_image = $_POST['item_image'];
	$item_desc = $_POST['item_desc'];
	$min_players = $_POST['min_players'];
	$max_players = $_POST['max_players'];
	$average_length_id = $_POST['average_length_id'];
	$categories_id = $_POST['categories_id'];
	$game_types_id = $_POST['game_types_id'];
	$trends_id = $_POST['trends_id'];

	$_SESSION['update_item_id'] = $item_id; 

	$year = $_POST['year'];
	$rating = $_POST['rating'];

	$target_dir = "../assets/img/";

	var_dump($_FILES);

	// $target_file = $target_dir . basename($_FILES["upload"]["name"]);
	// move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file);


	// if(isset($target_file)) {
	// 	$item_image = $target_file;
	// }

	$sql = "UPDATE items SET item_desc='$item_desc', item_image='$item_image', name='$name', price=$price, min_players=$min_players, max_players=$max_players, average_length_id=$average_length_id, game_types_id=$game_types_id, trends_id=$trends_id, categories_id=$categories_id, year='$year', rating=$rating where id=$item_id";


	$result = mysqli_query($conn, $sql);

	// echo json_encode($sql);