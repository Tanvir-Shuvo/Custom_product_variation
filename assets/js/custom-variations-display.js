

jQuery(document).ready(function ($) {
    // Function to update the product price based on selected attributes.
    function updateProductPrice() {
        // Get selected color and size values.
        var selectedColor = $('.color-swatch.selected').data('color');
        var selectedSize = $('select#pa_size').val(); // Adjust the selector based on your size input type.

        // Check if both color and size are selected.
        if (selectedColor && selectedSize) {
            // AJAX request to retrieve the updated price.
            $.ajax({
                type: 'POST',
                url: ajaxurl, // WordPress AJAX URL
                data: {
                    action: 'update_product_price',
                    product_id: woocommerce_params.product_id,
                    color: selectedColor,
                    size: selectedSize,
                },
                success: function (response) {
                    // Update the displayed price on the page.
                    $('.product .price').html(response);
                },
            });
        }
    }

    // Event listeners for color swatch and size selection.
    $('.color-swatch').click(function () {
        $('.color-swatch').removeClass('selected');
        $(this).addClass('selected');
        updateProductPrice();
    });

    $('select#pa_size').change(function () {
        updateProductPrice();
    });

    // Initialize the price based on the initial selections.
    updateProductPrice();
});
