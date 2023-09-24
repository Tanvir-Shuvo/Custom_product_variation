<?php

 // exit if file is called directly
 if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


class Custom_Variations_Display {
    public function __construct() {
        add_action('init', array($this, 'init_hooks'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('wp_ajax_update_product_price', array($this, 'update_product_price'));
        add_action('wp_ajax_nopriv_update_product_price', array($this, 'update_product_price'));
        add_action('admin_init', array($this, 'add_custom_setting'));
    }

    public function init_hooks() {
        add_action('woocommerce_before_single_product_summary', array($this, 'display_color_swatches'), 10);
        add_action('woocommerce_before_single_product_summary', array($this, 'display_size_dropdown'), 20);
    }

    public function display_color_swatches() {
        global $product;

    // Check if the product is variable.
    if ($product->is_type('variable')) {
        // Get available variations for the product.
        $variations = $product->get_available_variations();

        // Initialize an array to store unique color attributes.
        $unique_colors = array();

        // Iterate through variations to collect unique color attributes.
        foreach ($variations as $variation) {
            $attributes = $variation['attributes'];
            if (isset($attributes['attribute_pa_color'])) {
                $color = get_term_by('slug', $attributes['attribute_pa_color'], 'pa_color');
                if ($color) {
                    $unique_colors[$color->slug] = $color;
                }
            }
        }

        // Display color swatches.
        echo '<div class="color-swatches">';
        foreach ($unique_colors as $color) {
            $color_slug = $color->slug;
            $color_name = $color->name;
            // Generate swatch HTML. Replace with your desired markup.
            echo '<div class="color-swatch" data-color="' . $color_slug . '">' . $color_name . '</div>';
        }
        echo '</div>';
    }
    
    }

    public function display_size_dropdown() {
        global $product;
        if ($product->is_type('variable')) {
            // Code to display size dropdown here.
            echo '<div class="size-dropdown">'; // Replace with your HTML markup.
            echo 'Size Dropdown Here'; // Replace with dropdown display logic.
            echo '</div>';
        }
    }


    // Enqueue the CSS file.
    public function enqueue_styles() {
        wp_enqueue_style('custom-variations-display-style', plugin_dir_url(__FILE__) . 'custom-variations-display.css');
    }


    // Enqueue the JavaScript file.
    public function enqueue_scripts() {
        wp_enqueue_script('custom-variations-display', plugin_dir_url(__FILE__) . 'custom-variations-display.js', array('jquery'), '1.0', true);
        wp_localize_script('custom-variations-display', 'woocommerce_params', array('product_id' => get_the_ID()));
    }

    // Handle AJAX request to update product price.
    public function update_product_price() {
        // Retrieve product ID, color, and size from AJAX data.
        $product_id = $_POST['product_id'];
        $color = $_POST['color'];
        $size = $_POST['size'];

        // Calculate the new price based on selected attributes.
        // Implement your logic here.

        // Return the new price as a response.
        $new_price = '$19.99'; // Replace with the calculated price.
        echo $new_price;

        // Always exit to prevent unwanted output.
        exit();
    }

    // Add a custom setting to WooCommerce settings page.
    public function add_custom_setting() {
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_custom_settings_tab'), 50);
        add_action('woocommerce_settings_tabs_custom_variations_display', array($this, 'create_custom_settings_page'));
        add_action('woocommerce_update_options_custom_variations_display', array($this, 'save_custom_settings'));

        // Register the actual setting.
        register_setting('woocommerce_custom_variations_display', 'custom_variations_display_enabled', array($this, 'sanitize_custom_setting'));
    }

    // Add a new tab to the WooCommerce settings page.
    public function add_custom_settings_tab($tabs) {
        $tabs['custom_variations_display'] = __('Custom Variations Display', 'custom-variations-display');
        return $tabs;
    }

    // Create the custom settings page content.
    public function create_custom_settings_page() {
        ?>
        <div class="wrap">
            <h2><?php _e('Custom Variations Display Settings', 'custom-variations-display'); ?></h2>
            <form method="post" action="options.php">
                <?php
                    settings_fields('woocommerce_custom_variations_display');
                    do_settings_sections('woocommerce_custom_variations_display');
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    // Sanitize the custom setting.
    public function sanitize_custom_setting($input) {
        return sanitize_text_field($input);
    }

    // Save the custom setting.
    public function save_custom_settings() {
        $enabled = isset($_POST['custom_variations_display_enabled']) ? '1' : '0';
        update_option('custom_variations_display_enabled', $enabled);
    }
    
}

// Initialize the plugin class.
$custom_variations_display = new Custom_Variations_Display();
