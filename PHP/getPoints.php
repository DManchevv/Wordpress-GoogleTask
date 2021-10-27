<?php
	require('../../../wp-load.php');
	define('WP_USE_THEMES', false);
	global $wpdb;
	require(ABSPATH . 'wp-load.php');
	//$points = $wpdb->get_results("SELECT x,y FROM google_maps_points LIMIT 10");
	//echo json_encode($points);

	$timezone = $_POST['timezone'];
	$elevation = $_POST['elevation'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	
	$where = 'WHERE 1';

	if (!empty($timezone)) {
		$where .= " and timezone='$timezone'";
	}

	if (!empty($elevation)) {
		$where .= " and elevation='$elevation'";
	}

	if (!empty($city)) {
		$where .= " and city='$city'";
	}

	if (!empty($country)) {
		$where .= " and country='$country'";
	}

	$points = $wpdb->get_results("SELECT x,y FROM google_maps_points $where");

	$response = array();
	$response["success"] = true;
	$response["response"] = $points;

	echo json_encode($response);
?>
