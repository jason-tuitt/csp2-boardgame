<?php 
	require_once('./connect.php');
	session_start();

	$ADD = 50*0;

	$LOWER_ID = 0 + $ADD;
	$UPPER_ID = 50 + $ADD;

	$sql = "SELECT  i.id, i.item_desc, i.item_image, i.name, i.price, i.min_players, i.max_players, i.average_length_id, tr.trend_names, cat.category_names, gt.game_type_names, i.year, i.rating 
		from items as i
			JOIN trends as tr
				ON i.trends_id = tr.id
			JOIN categories as cat 
				ON i.categories_id = cat.id
			JOIN game_types as gt 
				ON i.game_types_id = gt.id ORDER by i.id DESC LIMIT 30";

	$result = mysqli_query($conn, $sql);

	$complete = Array();

	while($row = mysqli_fetch_assoc($result)) {
		array_push($complete, $row);
			
		// echo json_encode($row);
	}
	// echo  $sql;

	echo json_encode($complete);
	
	// echo $result;

	// echo json_encode($items_array);