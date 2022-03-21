<?php

namespace WooAddToCart\Classes;

class FrontendHandler
{

    public static $inquireUsConfig = [];

    public static function initWooAddToCart()
    {
        if (!is_singular('product')) {
            return;
        }
        
        $productId = get_the_ID();

        $inquireUsConfig =  self::getInquireUsSettings($productId);  // inquire us
        self::$inquireUsConfig = $inquireUsConfig;
        
        self::inquireUsButtonPostion(); // inquire us button position set
    }

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
    
    public static function inquireUsButtonPostion()
    {   
        $inquireUsConfig = self::$inquireUsConfig;
      
        if (!$inquireUsConfig){
            return;
        }

        $inquire_us         = $inquireUsConfig['inquire_us'];
        $inquire_us_button  = $inquireUsConfig['inquire_us_button'];
        $remove_cart_button = $inquireUsConfig['remove_cart_button'];

        $below_title         = $inquire_us_button == "below_title";
        $below_description   = $inquire_us_button == "below_description";
        $next_to_cart_button = $inquire_us_button == "next_to_cart_button";
      
        if ($inquire_us != 'yes' || $inquire_us_button == ''){
            return;
        }

        if ($below_title){ // below title
            add_action('woocommerce_single_product_summary', ['\WooAddToCart\Classes\FrontendHandler', 'addSingleCustomButton'], 15);
        }  
        else if ($next_to_cart_button && $remove_cart_button == 'no' ) {  // next to cart button 
            add_action('woocommerce_after_add_to_cart_button', ['\WooAddToCart\Classes\FrontendHandler', 'addSingleCustomButton']);
        }
        else { //below_description
            add_action('woocommerce_single_product_summary', ['\WooAddToCart\Classes\FrontendHandler', 'addSingleCustomButton'], 20);
        }
       
    }

    /**
     *  Added custom button
     */
    public static function addSingleCustomButton()
    {
        // $productId = get_the_ID();
        
        $inquireUsConfig = self::$inquireUsConfig;

        if (!$inquireUsConfig){
            return;
        }

        $inquire_us             = $inquireUsConfig['inquire_us'];
        $inquire_us_ButtonText  = $inquireUsConfig['inquire_us_text'];
        $inquire_us_ButtonLink  = $inquireUsConfig['inquire_us_link'];
        $inquire_us_button      = $inquireUsConfig['inquire_us_button'];
        $remove_cart_button     = $inquireUsConfig['remove_cart_button'];
        //$inquire_us_form        = $inquireUsConfig['inquire_us_form'];
        //$inquire_us_custom_html = $inquireUsConfig['inquire_us_custom_html'];
        
        $below_title = $inquire_us_button         == "below_title";
        $below_description = $inquire_us_button   == "below_description";
        $next_to_cart_button = $inquire_us_button == "next_to_cart_button";
       
        // if ($inquire_us == 'yes') {
        //     return;
        // }
        // // class add
        if ($below_title) {
            $inquire_us_button_class = '_wooaddtocart_below_title';
        }   
        
        if ($below_description) {
            $inquire_us_button_class = '_wooaddtocart_below_description';
        }
        
        if ($next_to_cart_button && $remove_cart_button == 'no') {
            $inquire_us_button_class = '_wooaddtocart_next_to_cart_button';
        }

        if ($next_to_cart_button && $remove_cart_button == 'yes') {
            $inquire_us_button_class = '_wooaddtocart_next_to_cart_btn';
        }

        if ($inquire_us == 'yes') {
            echo "<button type='button' id='_wooaddtocart_inquire_us_btn' class='single_add_to_cart_button button ".$inquire_us_button_class."'>" . $inquire_us_ButtonText . "</button>";
        }

    }

    /**
     * get Inquire Us Settings
    */ 
    public static function getInquireUsSettings($productId = false){
       
        if (!is_singular('product')) {
            return;
        }

        if (!$productId) {
            $productId = get_the_ID();
        }
        
        $inquire_us             = get_post_meta($productId, '_wooaddtocart_inquire_us', true);
        $inquire_us_button      = get_post_meta($productId, '_wooaddtocart_inquire_us_button', true);
        $inquire_us_text        = get_post_meta($productId, '_wooaddtocart_inquire_text', true);
        $inquire_us_link        = get_post_meta($productId, '_wooaddtocart_inquire_link', true);
        $remove_cart_button     = get_post_meta($productId, '_wooaddtocart_product_hide_cart_button', true);
 
        $inquireUsConfig = [
            'inquire_us'             => $inquire_us,
            'inquire_us_button'      => $inquire_us_button,
            'inquire_us_text'        => $inquire_us_text,
            'inquire_us_link'        => $inquire_us_link,
            'remove_cart_button'     => $remove_cart_button,
        ];

        $inquireUsConfig['product_id'] = $productId;

        return apply_filters('wooaddtocart_inquireus_config', $inquireUsConfig, $productId);
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