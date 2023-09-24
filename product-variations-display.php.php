 <?php
/**
 * Plugin Name: Custom WooCommerce product variation
 * Description: Enhances WooCommerce product variation display.
 * Version: 1.0
 * Author: Tanvir Shuvo
 */

 // exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

//include dependencies
require_once plugin_dir_path(__FILE__) . 'includes/class-custom-variation-display.php';

