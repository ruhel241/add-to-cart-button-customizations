<?php

namespace WooAddToCart\Classes;

class FrontendHandler
{
    /**
     *  remove single cart button
    */
    public static function removeSingleCartButton()
    {
        $productId = get_the_ID();
        $remove_cart_button = get_post_meta($productId, '_wooaddtocart_product_hide_cart_button', true);
        $buttonHide = get_option('_wooaddtocart_settings_button_hide', 'global_page');

        if ($buttonHide == 'single_page' || $buttonHide == 'global_page') {
            if ($remove_cart_button == 'yes') {
                if (is_product()) {
                    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
                    ?>
                    <style>
                        .wc-block-add-to-cart-form {
                            display: none;
                        }
                        </style>
                    <?php
                }
            }
        }

    }

    /**
     * cart button change on Shop page
    */
    public static function removeShopCartButton($button, $product)
    {   
        if (is_shop() || is_product_category()) {
            
            $productId = get_the_ID();
            $remove_cart_button = get_post_meta($productId, '_wooaddtocart_product_hide_cart_button', true);
            $buttonHide = get_option('_wooaddtocart_settings_button_hide', 'global_page');
               
            if ($buttonHide == 'shop_page' || $buttonHide == 'global_page') {
                if ($remove_cart_button == 'yes') {
                    $button = "";
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
     * Hide price for single product
    */
    public static function hideSinglePrice()
    {
        $productId = get_the_ID();

        $hidePrice = get_post_meta($productId, '_wooaddtocart_product_hide_price', true);
       
        if ($hidePrice == "yes") {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
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