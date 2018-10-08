<?php 
	require_once('./connect.php');
	session_start();

	$LIMIT = 25;

	$filter = $_GET['filter'];
	$id = $_GET['id'];

	$_SESSION[$filter] = $id;

	if ($filter == 'none') {
		unset($_SESSION['game_types_id']);
		unset($_SESSION['categories_id']);
	}

	if (isset($_SESSION['categories_id']) && isset($_SESSION['game_types_id'])) {
		$sql = "SELECT id, name, price, item_image, item_desc FROM items where game_types_id = $_SESSION[game_types_id] AND categories_id = $_SESSION[categories_id] LIMIT $LIMIT";

	} elseif (isset($_SESSION['game_types_id'])) {
		$sql = "SELECT id, name, price, item_image, item_desc FROM items where game_types_id = $_SESSION[game_types_id] LIMIT $LIMIT";

	} else {
		$sql = "SELECT id, name, price, item_image, item_desc FROM items LIMIT $LIMIT";
	}

	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	$filtered_items = array();

	while($row = mysqli_fetch_assoc($result)) {
		array_push($filtered_items, $row);
		// echo json_encode($row);
	}

	if (isset($_SESSION['user_data'])) {
		$login = 1;
	} else {
		$login = 0;
	}

	$data_response = array('login' => isset($_SESSION['user_data']), 'filter' => $filtered_items);

	// echo json_encode($sql);

	echo json_encode($data_response);



	// echo json_encode($filtered_items);

	// echo $sql;

	
	// if (!isset($_SESSION['game_id_filter'])) {
	// 	$_SESSION['game_id_filter'] = null;
	// }
	// if (!isset($_SESSION['type_id_filter'])) {
	// 	$_SESSION['type_id_filter'] = null;
	// }

	// if ($filter == 'card_games' || $filter == 'board_games' ||  $filter == 'special_games') {

	// 	$game_filter_sql_search = "SELECT id from categories where category_names = '$filter' LIMIT 20";
	// 	$game_result = mysqli_query($conn, $game_filter_sql_search);
	// 	$row_g = mysqli_fetch_assoc($game_result);

	// 	$game_id = $row_g['id'];

	// 	$_SESSION['game_id_filter'] = $game_id;
	// } else {
	// 	$type_filter_sql_search = "SELECT id from game_types where game_type_names = '$filter' LIMIT 20";
	// 	$type_result = mysqli_query($conn, $type_filter_sql_search);
	// 	$row_t = mysqli_fetch_assoc($type_result);

	// 	$type_id = $row_t['id'];

	// 	$_SESSION['type_id_filter'] = $type_id;
	// }

	// if ($filter === 'none') {
	// 	$_SESSION['game_id_filter'] = null;
	// 	$_SESSION['type_id_filter'] = null;
	// }

	// $g = $_SESSION['game_id_filter'];
	// $t = $_SESSION['type_id_filter'];

	// if (!isset($g) && isset($t)) {
	// 	$sql = "SELECT id, name, price, item_image FROM items where categories_id = $t LIMIT 20";
	// }
	// if (!isset($t) && isset($g)) {
	// 	$sql = "SELECT id, name, price, item_image FROM items where game_types_id = $g LIMIT 20";
	// }
	// if (isset($t) && isset($g)) {
	// 	$sql = "SELECT id, name, price, item_image FROM items where game_types_id = $g AND categories_id = $t LIMIT 20";
	// }
	// if (!isset($g) && !isset($t)) {
	// 	$sql = "SELECT id, name, price, item_image FROM items LIMIT 20";
	// }