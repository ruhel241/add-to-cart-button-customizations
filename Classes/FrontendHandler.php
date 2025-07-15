<?php

namespace WooAddToCart\Classes;

class FrontendHandler
{
    /**
     *  remove single cart button
    */
    public static function removeSingleCartButton() {
        // Only run this check on product pages
        if (!is_product()) {
            return;
        }
        
        $product_id = get_the_ID();
        $remove_cart_button = get_post_meta($product_id, '_wooaddtocart_product_hide_cart_button', true);
        $button_hide = get_option('_wooaddtocart_settings_button_hide', 'global_page');
        
        if (($button_hide === 'single_page' || $button_hide === 'global_page') && $remove_cart_button === 'yes') {
            // Output CSS directly in the page
            ?>
            <style>
                /* Hide add to cart button and related elements */
                .wc-block-add-to-cart-form,
                .single_add_to_cart_button,
                .cart .quantity,
                form.cart,
                .woocommerce-variation-add-to-cart {
                    display: none !important;
                }
            </style>
            <?php
            
            // Additionally, you can still remove the template function
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        }
    }

    /**
     * cart button change on Shop page
    */
    public static function removeShopCartButton($button, $product)
    {   
        // Only process on shop or category pages
        if (is_shop() || is_product_category()) {
            // Get product ID directly from the product object (more reliable)
            $productId = $product->get_id();
            $remove_cart_button = get_post_meta($productId, '_wooaddtocart_product_hide_cart_button', true);
            $buttonHide = get_option('_wooaddtocart_settings_button_hide', 'global_page');
            
            // Use strict comparison (=== instead of ==)
            if ($buttonHide === 'shop_page' || $buttonHide === 'global_page') {
                if ($remove_cart_button === 'yes') {
                    return ''; // Return empty immediately
                }
            }
        }

        return $button;
    }

    /**
     * custom cart button text on Shop page
    */
    public static function customTextAddToCartShop($text)
    { 
        if ( is_shop() || is_product_category() ) {
            
            $productId = get_the_ID();
            $customText = get_post_meta($productId, '_wooaddtocart_product_cart_button_text', true);
            
            if ($customText) {
                $text = $customText;
                return $text;
            } 
        }

        return $text;
    }

    /**
     * Custom cart button text on single page
    */
    public static function customTextAddToCartSingle($text)
    {
        if (!is_singular('product')) {
            return;
        }

        $productId = get_the_ID();

        $customText = get_post_meta($productId, '_wooaddtocart_product_cart_button_text', true);

        if ($customText) {
            $text = $customText;
            return $text;
        } 

       return $text;
    }
   
    

    /**
     * Hide price on single product pages
     */
    public static function hideSinglePrice() 
    {
        // Only proceed if we're on a product page
        if (!is_product()) {
            return;
        }
        
        $product_id = get_the_ID();
        $hide_price = get_post_meta($product_id, '_wooaddtocart_product_hide_price', true);
        
        if ($hide_price === 'yes') {
            // Remove the price from the single product summary
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            
            // Add some CSS to hide any prices that might be added by the theme or other plugins
            ?>
            <style>
                .single-product .price,
                .single-product .woocommerce-Price-amount,
                .single-product .product p.price,
                .single-product .product span.price {
                    display: none !important;
                }
            </style>
            <?php
        }
    }

    /**
     * Hide Price for Shop Price 
    */
    public static function hideShopPrice($price, $product)
    {
        $productId = get_the_ID();
       
        if (is_shop() || is_product_category()) {
            $hidePrice = get_post_meta($productId, '_wooaddtocart_product_hide_price', true);
            
            if ($hidePrice == 'yes') {
                return '';
            }
        }

        return $price;
    }
}