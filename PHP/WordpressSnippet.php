// This is a code that I use in wordpress with the plugin XYZ PHP Code

<?php
  define('WP_USE_THEMES', false);
  global $wpdb;
  require(ABSPATH . 'wp-load.php');
  $points = $wpdb->get_results("SELECT * FROM google_maps_points LIMIT 1000");
  echo json_encode($points);
?>
