<?php



class Ts_Variable_Template {

    public function __construct() {

        // Check if the 'enable_feature' option is set to 'yes'
        $enable_feature = get_option('enable_feature');

        // Only execute the actions if the feature is enabled
        if ($enable_feature === 'yes') {
            // hook into remove default variation swatches
            add_action('init', array($this, 'remove_default_variation'));

            // Hook into replace the variation in 'woocommerce_product_thumbnails'
            add_action('woocommerce_product_thumbnails', array($this, 'add_variation_product_thumbnails'));

            // Override the default variation template
            add_filter('wc_get_template', array($this, 'override_variation_template'), 10, 5);

        }
    }

    // default variation swatches remove function
    public function remove_default_variation() {
        remove_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);
    }

    // add variation swatches to another (woocommerce_product_thumbnails) place
    public function add_variation_product_thumbnails() {
        add_action('woocommerce_product_thumbnails', 'woocommerce_variable_add_to_cart', 30);
    }

    // Override the default variation template
    public function override_variation_template($template, $template_name, $template_path, $default_path, $args) {
        if ($template_name == 'single-product/add-to-cart/variable.php') {
            // Change this path to the location of your custom template within the plugin
            $custom_template_path = plugin_dir_path(__FILE__) . '../templates/custom-variable.php';
            return file_exists($custom_template_path) ? $custom_template_path : $template;
        }

        return $template;
    }
     



}

// Check if the 'enable_feature' option is set to 'yes'
$enable_feature = get_option('enable_feature');

if ($enable_feature === 'yes') {
    // Initialize the Ts_Variable_Template class
    $ts_variable_template = new Ts_Variable_Template();
}












/*
 
class Custom_woocommerce_locate_template{

    public function __construct() {
        add_filter('woocommerce_locate_template', array($this, 'custom_woocommerce_template_locate'), 10, 3);
    }

    public function custom_woocommerce_template_locate($template, $template_name, $template_path) {
        if ('variable.php' === basename($template)) {
            $template = trailingslashit(plugin_dir_path(__FILE__)) . '/woocommerce/add-to-cart/variable.php';
        }

        return $template;
    }

}


// Initialize the class.
$custom_woocommerce_locate_template = new Custom_woocommerce_locate_template();

*/