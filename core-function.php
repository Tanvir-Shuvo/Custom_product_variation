<?php

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
