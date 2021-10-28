<?php
	require('../../../wp-load.php');
	define('WP_USE_THEMES', false);
	global $wpdb;
	require(ABSPATH . 'wp-load.php');
	//$points = $wpdb->get_results("SELECT x,y FROM google_maps_points LIMIT 10");
	//echo json_encode($points);

	$timezone = $_POST['timezone'];
	$elevationMin = $_POST['elevationMin'];
	$elevationMax = $_POST['elevationMax'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$point1X = $_POST['point1X'];
	$point1Y = $_POST['point1Y'];
	$point2X = $_POST['point2X'];
	$point2Y = $_POST['point2Y'];

	
	$where = 'WHERE 1';

	if (!empty($timezone)) {
		$where .= " and timezone='$timezone'";
	}

	if (!empty($elevationMin)) {
		$where .= " and elevation>'$elevationMin'";
	}

	if (!empty($elevationMax)) {
		$where .= " and elevation<'$elevationMax'";
	}

	if (!empty($city)) {
		$where .= " and city='$city'";
	}

	if (!empty($country)) {
		$where .= " and country='$country'";
	}

	if (!empty($point1X) && !empty($point1Y) && !empty($point2X) && !empty($point2Y)) {
		$where .= " and x>'$point1X' and x<'$point2X' and y>'$point1Y' and y<'$point2Y'";
	}

	$points = $wpdb->get_results("SELECT x,y FROM google_maps_points $where");

	$response = array();
	$response["success"] = true;
	$response["response"] = $points;

	echo json_encode($response);
?>
