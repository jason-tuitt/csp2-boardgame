<?php 
	require_once('./connect.php');
	session_start();

	$id = $_SESSION['user_data']['id'];

	$type = $_POST['id'];
	$value = $_POST['value'];

	$sql_info ="SELECT $type from users where id=$id";
	$result_info = mysqli_query($conn, $sql_info);
	$row_info = mysqli_fetch_assoc($result_info);

	if ($row_info[$type] == $value) {
		echo json_encode(2);
	} elseif ($type == 'email' && strpos($value, '@') != True){
			echo json_encode(3);
	} else {
		if ($type == 'username' or $type == 'email'){
			$sql_find = "SELECT $type from users where $type = '$value'";
			$result_find = mysqli_query($conn, $sql_find);

			if (mysqli_num_rows($result_find) > 0) {
				echo json_encode(0);
			} 
			else {
				$sql = "UPDATE users SET $type = '$value' where id = $id";
				$result = mysqli_query($conn, $sql);

				$_SESSION['user_data'][$type] = $value;

				echo json_encode(1);
			}
		} else {
			$sql = "UPDATE users SET $type = '$value' where id = $id";
			$result = mysqli_query($conn, $sql);

			$_SESSION['user_data'][$type] = $value;

			echo json_encode(1);
		}
	}

	



	// if ($type == 'username' or $type == 'email') {
	// 	if (mysqli_num_rows($result_find) > 1) {
	// 		echo json_encode(0);
	// 		while ($row = mysqli_fetch_assoc($result_find)) {
	// 			if ($row[$type] == $value) echo json_encode(2);
	// 		}
	// 	} else {
	// 		echo json_encode(2);
	// 	}
	// } else {
	// 	$row = mysqli_fetch_assoc($result_find)
	// 	if ($value == $row[$type]) {
	// 		echo json_encode(2);
	// 	} else {
			
	// 	}
	// }


	

	// echo $sql;

	// var_dump($_SESSION['user_data']);


