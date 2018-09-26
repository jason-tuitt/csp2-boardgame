<?php 
	require_once('./connect.php');

	$category = $_GET['category'];
	// $category = 'municipalities';
	$filtercode = $_GET['filter'];
	// $filtercode = '0128';

	

	if ($category == 'regions') {
		$sql = "SELECT * FROM $category";
		$result = mysqli_query($conn, $sql);
		$data = array();
		// echo 'asdasdasd';
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($data, $row);
			}		
		}
		echo json_encode($data);
	}

	if ($category == 'provinces') {
		$sql = "SELECT * FROM regions_provinces where region_code = $filtercode";
		$result = mysqli_query($conn, $sql);
		$data = array();
		// echo 'asdasdasd';
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($data, $row);
			}		
		}
		echo json_encode($data);
	}

	if ($category == 'municipalities') {
		$filtercode = ltrim($filtercode, 0);
		// echo ($filtercode);
		$sql = "SELECT * FROM cities_municipalities where region_province_id = $filtercode";
		$result = mysqli_query($conn, $sql);
		$data = array();

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($data, $row);
			}		
		}
		echo json_encode($data);
	}

	if ($category == 'barangays') {
		$filtercode = ltrim($filtercode, 0);
		// echo ($filtercode);
		$sql = "SELECT * FROM barangays where city_municipality_code = $filtercode";
		$result = mysqli_query($conn, $sql);
		$data = array();

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($data, $row);
			}		
		}
		echo json_encode($data);
	}

	// if($category == 'province') {
	// 	$sql = "SELECT "
	// }



	