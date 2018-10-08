<?php 
	require_once('./connect.php');
	session_start();

	$item_id = $_GET['id'];

	// $sql = "SELECT  i.id, i.item_desc, i.item_image, i.name, i.price, i.min_players, i.max_players, i.average_length_id, tr.trend_names, cat.category_names, gt.game_type_names, i.publisher, i.rating 
	// 	from items as i
	// 		JOIN trends as tr
	// 			ON i.trends_id = tr.id
	// 		JOIN categories as cat 
	// 			ON i.categories_id = cat.id
	// 		JOIN game_types as gt 
	// 			ON i.game_types_id = gt.id
	// 		where i.id = $item_id";

	$sql = "SELECT * from items where id = $item_id";

	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo json_encode($row);
		}
	} else {
		echo 'error';
	}


	