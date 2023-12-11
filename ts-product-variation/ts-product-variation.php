<?php

/**
 * @wordpress-plugin
 * Plugin Name:       TS Product Variation
 * Plugin URI:        https://rownakh14.sg-host.com/
 * Description:       Custom Woocommerce product variation display after product thumbnail 
 * Version:           1.0.0
 * Author:            Tanvir Shuvo
 * Author URI:        https://rownakh14.sg-host.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ts-product-variation
 * Domain Path:       /languages
 */

  // exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


// Include the class file
include_once(plugin_dir_path(__FILE__) . 'includes/class-ts-custom-tab.php');

include_once(plugin_dir_path(__FILE__) . 'includes/class-ts-variation-template.php');