<?php
	
	require('../../../wp-load.php');
	define('WP_USE_THEMES', false);
	global $wpdb;
	require(ABSPATH . 'wp-load.php');

	$country = $_POST['country'];
	$city = $_POST['city'];
	$type = $_POST['type'];
	
	if (!empty($country) && $type == "country") {
		$points = $wpdb->get_results("SELECT DISTINCT country FROM google_maps_points WHERE country LIKE '$country%' LIMIT 10");
	}
	else if (empty($country) && $type == "country") {
		$points = $wpdb->get_results("SELECT DISTINCT country FROM google_maps_points LIMIT 10");
	}
	else if (!empty($city) && empty($country)) {
		$points = $wpdb->get_results("SELECT DISTINCT city FROM google_maps_points WHERE city LIKE '$city%' LIMIT 10");
	}
	else if (!empty($city) && !empty($country)) {
		$points = $wpdb->get_results("SELECT DISTINCT city FROM google_maps_points WHERE country='$country' and city LIKE '$city%' LIMIT 10");
	}
	else if (empty($city) && !empty($country) && $type == "city"){
		$points = $wpdb->get_results("SELECT DISTINCT city FROM google_maps_points WHERE country='$country' LIMIT 10");
	}
	else if (empty($city) && empty($country) && $type == "city") {
		$points = $wpdb->get_results("SELECT DISTINCT city FROM google_maps_points LIMIT 10");
	}

	$response = array();
	$response["success"] = true;
	$response["response"] = $points;

	echo json_encode($response);
?>
