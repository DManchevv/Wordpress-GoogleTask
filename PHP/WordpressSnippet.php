// This is a code that I use in wordpress with the plugin XYZ PHP Code

<?php
  define('WP_USE_THEMES', false);
  global $wpdb;
  require(ABSPATH . 'wp-load.php');
  $points = $wpdb->get_results("SELECT x,y FROM google_maps_points");
  echo json_encode($points);
?>
