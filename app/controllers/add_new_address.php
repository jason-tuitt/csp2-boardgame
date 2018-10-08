<?php 
	require_once('./connect.php');
	session_start();

	$id = $_SESSION['user_data']['id'];

	// $address_id = $_POST['address_id'];

	$address_type_id = $_POST['address_type_id'];
	$house_num_others = $_POST['house_num_others'];
	$region_code = $_POST['region_code'];
	$region_province_code = $_POST['region_province_code'];
	$city_municipality_code = $_POST['city_municipality_code'];
	$barangay_id = $_POST['barangay_id'];

	$default = 0;


	$sql_check = "SELECT * from addresses where user_id=$id AND address_type_id = $address_type_id";
	$result_check = mysqli_query($conn, $sql_check);


	if (mysqli_num_rows($result_check) < 1) {
		$default = 1;
	} 

	$sql_add = "INSERT INTO addresses(house_num_others, region_code, region_province_code, city_municipality_code, barangay_id, address_type_id, default_add, user_id) VALUES ('$house_num_others', '$region_code', '$region_province_code', '$city_municipality_code', $barangay_id, $address_type_id, $default, $id)";
	$result_add = mysqli_query($conn, $sql_add);

	echo $sql_add;


