<?php 
	require_once('./connect.php');
	session_start();

	$address_id = $_POST['address_id'];

	$address_type_id = $_POST['address_type_id'];
	$house_num_others = $_POST['house_num_others'];
	$region_code = $_POST['region_code'];
	$region_province_code = $_POST['region_province_code'];
	$city_municipality_code = $_POST['city_municipality_code'];
	$barangay_id = $_POST['barangay_id'];
	// $default = 1;

	// echo $address_type_id, $house_num_others, $region_code, $region_province_code, $city_municipality_code, $barangay_id;

	$id = $_SESSION['user_data']['id'];

	$sql = "UPDATE addresses SET house_num_others = '$house_num_others', region_code = '$region_code', region_province_code = '$region_province_code', city_municipality_code = '$city_municipality_code', barangay_id = $barangay_id, address_type_id = $address_type_id WHERE id = $address_id";

	$result = mysqli_query($conn, $sql);

	echo $result;

// UPDATE addresses SET house_num_others = '123 fdg qwer, sdfg, qweasd', region_code = '04',region_province_code = '0434',city_municipality_code = '043410',barangay_id = 10771 WHERE user_id = 101 AND address_type_id = 1