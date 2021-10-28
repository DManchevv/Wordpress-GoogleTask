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
	$point1X = $_POST['point1X'];
	$point1Y = $_POST['point1Y'];
	$point2X = $_POST['point2X'];
	$point2Y = $_POST['point2Y'];

	
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

	if (!empty($point1X) && !empty($point1Y) && !empty($point2X) && !empty($point2Y)) {
		if ($point1X <= $point2X) {
			$where .= " and x>='$point1X' and x<='$point2X'";
		}
		else {
			$where .= " and x<'$point1X' and x>'$point2X'";
		}
		
		if ($point1Y <= $point2Y) {
			$where .= " and y>='$point1Y' and y<='$point2Y'";
		}
		else {
			$where .= " and y<'$point1Y' and y>'$point2Y'";
		}
	}

	$points = $wpdb->get_results("SELECT x,y FROM google_maps_points $where");

	$response = array();
	$response["success"] = true;
	$response["response"] = $points;

	echo json_encode($response);
?>
