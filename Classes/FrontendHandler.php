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
        $remove_cart_button = get_post_meta($productId, '_wooaddtocart_remove_cart_button', true);
        $buttonDisplay = get_option('wooaddtocart_button_display');

        if($buttonDisplay == 'single_page' || $buttonDisplay == 'global_page') {
            if ($remove_cart_button == 'yes') {
                if (is_product()) {
                    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
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
            $productId = $product->id;
            $remove_cart_button = get_post_meta($productId, '_wooaddtocart_remove_cart_button', true);
            $buttonDisplay = get_option('wooaddtocart_button_display');
               
            if($buttonDisplay == 'shop_page' || $buttonDisplay == 'global_page') {
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
            global $product;
            $productId = $product->id;
            $customText = get_post_meta($productId, '_wooaddtocart_cart_button_text', true);
            if($customText){
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
        global $product;
        if (!is_singular('product')) {
            return;
        }
        $productId = $product->id;
        $customText = get_post_meta($productId, '_wooaddtocart_cart_button_text', true);
        if($customText){
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
        $hidePrice = get_post_meta($productId, '_wooaddtocart_hide_price', true);
        if ($hidePrice == "yes") {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        }
    }
    /**
     * Hide Price for Shop Price 
     */
    public static function hideShopPrice($price, $product)
    {
        $productId = $product->id;
        if (is_shop() || is_product_category()) {
            $hidePrice = get_post_meta($productId, '_wooaddtocart_hide_price', true);
            if ($hidePrice == 'yes') {
                return '';
            }
        }
        return $price;
    }

}