<?php

// this is used to check whether the given class is defined or not.
if(!class_exists('TS_Custom_Tab_Class')){

// Define TS_Custom_Tab_Class class
class TS_Custom_Tab_Class{

    public function __construct() {
        // Hook into WooCommerce settings tabs
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_custom_tab'), 99);

        // hook into settings fields to the custom tab 'woocommerce_settings_{tab}' ...
        add_action('woocommerce_settings_ts-custom-tab', array($this, 'add_custom_tab_content') );
        
        // hook into when the WooCommerce settings are saved
        add_action('woocommerce_settings_save_ts-custom-tab', array($this,'save_ts_custom_setting') );
    }

    // Add a custom tab in WooCommerce settings
    public function add_custom_tab($tabs) {
        $tabs['ts-custom-tab'] = __('TS Product Variation', 'ts-product-variation');
        return $tabs;
    }

    // Add settings fields to the custom tab
    public function add_custom_tab_content() {
        woocommerce_admin_fields(array(
            array(
                'name' => __('TS Custom Settings', 'ts-product-variation'),
                'type' => 'title',
                'id' => 'custom_settings_title',
            ),
           
            array(
                'name'     => __('TS Custom Product Variation', 'ts-product-variation'),
                'type'     => 'checkbox',
                'id'       => 'enable_feature',
                'desc'     => __('Enable or Disable TS Custom Product Variation.', 'ts-product-variation'),
                
            ),


            array(
                'type' => 'sectionend',
            ),
        ));
    }

    public function save_ts_custom_setting() {
        // Ensure that the option is properly updated
        $enable_feature = isset($_POST['enable_feature']) ? 'yes' : 'no';
        update_option('enable_feature', $enable_feature);
    }


}


}

// Initialize the plugin class.
$ts_custom_tab_class = new TS_Custom_Tab_Class();