<?php 
	require_once('./connect.php');
	session_start();

	$current_id = $_SESSION['user_data']['id'];

	$type = $_GET['data'];

	if ($type == 'currentShipping') $add_type = 1;
	elseif ($type == 'currentBilling') $add_type = 2;

	$sql = "SELECT ad.house_num_others, r.region, rp.region_province, cm.province_code, b.barangay, ad.address_type_id, ad.default, ad.user_id 
		from addresses as ad 
			JOIN regions as r
				ON ad.region_code = r.region_code
			JOIN regions_provinces as rp 
				ON ad.region_province_code = rp.province_code 
			JOIN cities_municipalities as cm
				ON ad.city_municipality_code = cm.city_municipality_code
			JOIN barangays as b
				ON ad.barangay_id = b.id
			where user_id = $current_id";

	$result = mysqli_query($conn, $sql);

	$data = array();

	if (mysqli_num_rows($result) > 0) {

		while($row = mysqli_fetch_assoc($result)) {

			if ($row['address_type_id'] == $add_type and $row['default'] == 1) {
				echo json_encode($row);
			}
		}
	}




	// var_dump($data);

	// echo json_encode($data);

