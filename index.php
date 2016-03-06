<?php
/*
Plugin Name: WP River (.js) Reader
Plugin URI: http://blog.henrikcarlsson.se/tag/wp-river.js-reader/
Description: A widget that displays a "River of News". (http://scripting.com/2014/06/02/whatIsARiverOfNewsAggregator.html)
Author: MrHenko
Author URI: http://henrikcarlsson.se
*/

// Block direct requests.
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Require needed files.
require_once( 'RiverReader.php' );
require_once( 'RiverWidget.php' );

// Register widget.
add_action( 'widgets_init', function () {
	register_widget( 'RiverWidget' );
} );