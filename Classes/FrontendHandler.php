<?php

namespace WooAddToCart\Classes;

class FrontendHandler
{

    public static $timerConfig = [];
    public static $inquireUsConfig = [];

    // public static function initSaleBooster()
    // {
    //     wp_enqueue_style("sale-booster-css", WOOADDTOCART_PLUGIN_DIR_URL . "src/public/css/sale-booster.css", false);
        
    //     if (!is_singular('product')) {
    //         return;
    //     }

    //     $productId = get_the_ID();
        
    //     if( defined('FLUENTFORM')){
    //         self::singlePageExitPopup($productId); // single page Exit popup modal
    //     }
        
    //     //Pro feature 
    //     if (defined('SALES_BOOTER_PRO_INSTALLED')) {
    //         $inquireUsConfig =  self::getInquireUsSettings($productId);  // inquire us
    //         self::$inquireUsConfig = $inquireUsConfig;
    //         self::inquireUsButtonPostion(); // inquire us button position set
    //     }
        
    //     $timerConfig = self::getTimerSettings($productId);
    //     self::$timerConfig = $timerConfig;

    //     if (!$timerConfig) {
    //         return;
    //     }
    //     wp_enqueue_script("sale-booster-timer-js", WOOADDTOCART_PLUGIN_DIR_URL . "src/public/js/sale-booster-timer.js", array('jquery'), WOOADDTOCART_PLUGIN_DIR_VERSION, true);
    //     wp_localize_script('sale-booster-timer-js', 'WOOADDTOCART_countdown_vars', $timerConfig);
    //     add_action('wp_head', array('SaleBooster\Classes\Customization', 'customStyle')); // custom css

    //     $showTopBar = $timerConfig['position'] == 'both' || $timerConfig['position'] == 'top';
    //     $showBottomBar = $timerConfig['position'] == 'both' || $timerConfig['position'] == 'bottom';
    //     $showFooterSticky = $timerConfig['position'] == 'footer_sticky';

    //     if($showTopBar) {
    //         add_action('wp_footer', array('\SaleBooster\Classes\FrontendHandler', 'discountTimerTop'));
    //     }
    //     if ($showBottomBar) {
    //         add_action('woocommerce_share', array('\SaleBooster\Classes\FrontendHandler', 'discountTimerBottom'));
    //     }

    //     if($showFooterSticky) {
    //         add_action('wp_footer', array('\SaleBooster\Classes\FrontendHandler', 'discountTimerFooter'));
    //     }
    // }

  
    
    /*
    * Pro Specific Hooks.
    * Add inquire us button in single product page..
    */
    // public static function inquireUsButtonPostion()
    // {   
    //     $inquireUsConfig = self::$inquireUsConfig;
      
    //     if(!$inquireUsConfig){
    //         return;
    //     }

    //     $inquire_us         = $inquireUsConfig['inquire_us'];
    //     $inquire_us_button  = $inquireUsConfig['inquire_us_button'];
    //     $remove_cart_button = $inquireUsConfig['remove_cart_button'];

    //     $below_title         = $inquire_us_button == "below_title";
    //     $below_description   = $inquire_us_button == "below_description";
    //     $next_to_cart_button = $inquire_us_button == "next_to_cart_button";
      
    //     if($inquire_us != 'yes' || $inquire_us_button == ''){
    //         return;
    //     }

    //     if($below_title){ // below title
    //         add_action('woocommerce_single_product_summary', array('\SaleBooster\Classes\FrontendHandler', 'addSingleCustomButton'), 15);
    //     }  
    //     else if($next_to_cart_button && $remove_cart_button != 'yes' ){  // next to cart button 
    //         add_action('woocommerce_after_add_to_cart_button', array('\SaleBooster\Classes\FrontendHandler', 'addSingleCustomButton'));
    //     } else { //below_description or next_to_cart_button (when add to cart button remove)
    //         add_action('woocommerce_single_product_summary', array('\SaleBooster\Classes\FrontendHandler', 'addSingleCustomButton'), 30);
    //     }
       
    // }
    /**
     *  remove single cart button
    */
    public static function removeSingleCartButton()
    {
        $productId = get_the_ID();
        $remove_cart_button = get_post_meta($productId, '_wooaddtocart_remove_cart_button', true);
        
        if ($remove_cart_button == 'yes' ) {
            if (is_product()) {
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            }
        }
    }
    /**
     *  Added custom button
     */
    // public static function addSingleCustomButton()
    // {
    //     $productId = get_the_ID();
        
    //     $inquireUsConfig = self::$inquireUsConfig;
    //     if(!$inquireUsConfig){
    //         return;
    //     }
    //     $inquire_us             = $inquireUsConfig['inquire_us'];
    //     $cart_ButtonText        = $inquireUsConfig['cart_ButtonText'];
    //     $inquire_us_button      = $inquireUsConfig['inquire_us_button'];
    //     $inquire_us_form        = $inquireUsConfig['inquire_us_form'];
    //     $inquire_us_custom_html = $inquireUsConfig['inquire_us_custom_html'];
        
    //     $below_title = $inquire_us_button         == "below_title";
    //     $below_description = $inquire_us_button   == "below_description";
    //     $next_to_cart_button = $inquire_us_button == "next_to_cart_button";
       
    //     if($inquire_us == 'yes' && !defined('SALES_BOOTER_PRO_INSTALLED')) {
    //         return;
    //     }
    //     // class add
    //     if($below_title) {
    //         $inquire_us_button_class = '_WOOADDTOCART_below_title';
    //     }   
    //     if($below_description) {
    //         $inquire_us_button_class = '_WOOADDTOCART_below_description';
    //     }
    //     if($next_to_cart_button) {
    //         $inquire_us_button_class = '_WOOADDTOCART_next_to_cart_button';
    //     }

    //     if ($inquire_us == 'yes') {
    //         echo "<button type='button' id='_WOOADDTOCART_inquire_us_btn' class='single_add_to_cart_button button alt ".$inquire_us_button_class."'>" . $cart_ButtonText . "</button>";
    //     }

    //     /**
    //      * Inquire us modal 
    //      */
    //     if( !defined('FLUENTFORM')){
    //         return;
    //     }

    //     $inquireShortCode = "";
    //     if($inquire_us_form == 'custom_html'){
    //         $inquireShortCode =  $inquire_us_custom_html;
    //     } else {
    //         $inquireShortCode =  $inquire_us_form;
    //     }

    //     if(!$inquireShortCode){
    //         return;
    //     }
    //     self::inquireUsModal($inquireShortCode);
    // 
    // }

    

    /**
     * cart button change on Shop page
     */
    public static function removeShopCartButton($button, $product)
    {   
        if (is_shop() || is_product_category()) {
            $productId = $product->id;
            $remove_cart_button = get_post_meta($productId, '_WOOADDTOCART_remove_cart_button', true);
            
            if ($remove_cart_button == 'yes') {
                $button = "";
            }
        }
        return $button;
    }
    /**
     * custom cart button text on Shop page
     */
    // public static function customTextAddToCartShop($text)
    // { 
    //     if ( is_shop() || is_product_category() ) {
    //         global $product;
    //         $productId = $product->id;
    //         $customText = get_post_meta($productId, '_WOOADDTOCART_cart_button_text', true);
    //         if($customText){
    //             $text = $customText;
    //             return $text;
    //         } 
    //     }
    //     return $text;
    // }

    /**
     * custom cart button text on single page
     */
    // public static function customTextAddToCartSingle($text)
    // {
    //     global $product;
    //     if (!is_singular('product')) {
    //         return;
    //     }
    //     $productId = $product->id;
    //     $customText = get_post_meta($productId, '_WOOADDTOCART_cart_button_text', true);
    //     if($customText){
    //         $text = $customText;
    //         return $text;
    //     } 
    //    return $text;
    // }
    /**
     * hide price
     */
    // public static function hideSinglePrice()
    // {
    //     $productId = get_the_ID();
    //     $hidePrice = get_post_meta($productId, '_WOOADDTOCART_hide_price', true);
    //     if ($hidePrice == "yes") {
    //         remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    //     }
    // }
    // /**
    //  * Shop Price Hide
    //  */
    // public static function hideShopPrice($price, $product)
    // {
    //     $productId = $product->id;
    //     if (is_shop() || is_product_category()) {
    //         $hidePrice = get_post_meta($productId, '_WOOADDTOCART_hide_price', true);
    //         if ($hidePrice == 'yes') {
    //             return '';
    //         }
    //     }
    //     return $price;
    // }

    

    

    /**
     *  get Timer Settings
     */
    // public static function getTimerSettings($productId = false)
    // {
    //     if (!is_singular('product')) {
    //         return;
    //     }
    //     if (!$productId) {
    //         $productId = get_the_ID();
    //     }

    //     $type = get_post_meta($productId, '_WOOADDTOCART_discount_timer', true);
    //     $timerSeconds = false;
    //     if ($type == 'user_based_time') {

    //         if(!defined('SALES_BOOTER_PRO_INSTALLED')) {
    //             return false;
    //         }

    //         $timerMinites = intval(get_post_meta($productId, '_WOOADDTOCART_user_based_expire_time', true));
    //         $timerSeconds = $timerMinites * 60;
    //     } else if ($type == 'fixed_date') {
    //         $dateTime = get_post_meta($productId, '_WOOADDTOCART_expire_date_time', true);
    //         $timerSeconds = strtotime($dateTime) - time();
    //     }
    //     if (!$timerSeconds || $timerSeconds <= 0) {
    //         return false;
    //     }

    //     $titleBefore = get_post_meta($productId, '_WOOADDTOCART_stock_quantity', true);
    //     $titleAfter = get_post_meta($productId, '_WOOADDTOCART_note', true);

    //     if(strpos($titleBefore, '{stock}', $titleBefore.$titleAfter) !== false) {
    //         $product = new \WC_Product($productId);
    //         $stock  = $product->get_stock_quantity();
    //         $titleBefore = str_replace('{stock}', $stock, $titleBefore);
    //         $titleAfter = str_replace('{stock}', $stock, $titleAfter);
    //     }

    //     $timerConfig = [
    //         'type'         => $type,
    //         'timerSeconds' => $timerSeconds,
    //         'title_before' => $titleBefore,
    //         'title_after'  => $titleAfter,
    //         'hide_days'    => get_post_meta($productId, '_WOOADDTOCART_hide_days', true),
    //         'position'     => get_post_meta($productId, '_WOOADDTOCART_expaire_date_layout', true)
    //     ];

    //     $timerConfig['trans'] = apply_filters('sales_booster_timer_trans', [
    //         'days' => __('days', 'WOOADDTOCART'),
    //         'hours'  => __('hours', 'WOOADDTOCART'),
    //         'minutes' => __('minutes', 'WOOADDTOCART'),
    //         'seconds' => __('seconds', 'WOOADDTOCART')
    //     ], $productId);
    //     $timerConfig['product_id'] = $productId;

    //     return apply_filters('sales_booster_timer_config', $timerConfig, $productId);
    // }

    /**
     * get Inquire Us Settings
    */ 
    // public static function getInquireUsSettings($productId = false){
       
    //     if (!is_singular('product')) {
    //         return;
    //     }
    //     if (!$productId) {
    //         $productId = get_the_ID();
    //     }
        
    //     $inquire_us             = get_post_meta($productId, '_WOOADDTOCART_inquire_us', true);
    //     $inquire_us_button      = get_post_meta($productId, '_WOOADDTOCART_inquire_us_button', true);
    //     $remove_cart_button     = get_post_meta($productId, '_WOOADDTOCART_remove_cart_button', true);
    //     $cart_ButtonText        = get_post_meta($productId, '_WOOADDTOCART_inquire_text', true);
    //     $inquire_us_form        = get_post_meta($productId, '_WOOADDTOCART_inquire_us_form', true);
    //     $inquire_us_custom_html = get_post_meta($productId, '_WOOADDTOCART_inquire_us_custom_html', true);
        
    //     $inquireUsConfig = [
    //         'inquire_us'             => $inquire_us,
    //         'inquire_us_button'      => $inquire_us_button,
    //         'remove_cart_button'     => $remove_cart_button,
    //         'cart_ButtonText'        => $cart_ButtonText,
    //         'inquire_us_form'        => $inquire_us_form,
    //         'inquire_us_custom_html' => $inquire_us_custom_html,
    //     ];

    //     $inquireUsConfig['product_id'] = $productId;

    //     return apply_filters('sales_booster_inquireus_config', $inquireUsConfig, $productId);
    // }


}