<?php 
	require_once('./connect.php');
	session_start();

	$current_id = $_SESSION['user_data']['id'];

	$type = $_GET['data'];

	$address_data = array();

	if ($type == 'currentShipping' || $type == 'shipping') $add_type = 1;
	elseif ($type == 'currentBilling' || $type == 'billing') $add_type = 2;

	$sql = "SELECT ad.id, ad.house_num_others, r.region, rp.region_province, cm.province_code, b.barangay, ad.address_type_id, ad.default_add, ad.user_id 
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

			if ($row['address_type_id'] == $add_type) {
				array_push($address_data, $row);
			}
		}

		echo json_encode($address_data);
	} else {
		echo json_encode(0);
	}
