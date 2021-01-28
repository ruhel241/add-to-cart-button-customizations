<?php

namespace WooAddToCart\Classes;

class ProductSettings
{

    /**
     * Register Tab
    */ 
    public static function registerProductDataTab($product_data_tabs)
    {
        $menuName = esc_html__('Woo Add To Cart Lite', 'wooaddtocart');
        
        $product_data_tabs['_wooaddtocart'] = array(
            'label'  => $menuName,
            'target' => 'wooaddtocart_product_data',
            'class'  => array('show_if_wooaddtocart_product_data'),
        );
        return $product_data_tabs;
    }

   
   /**
    * Create Data Fields
   */
    public static function createDataFields() 
    {
        ?>
            <div id="wooaddtocart_product_data" class="panel woocommerce_options_panel">
                <input type="hidden" name="_wooaddtocart_product_have_values" value="1"/>
                <div class="options_group">
                        <?php
                        // hidden input
                        woocommerce_wp_hidden_input([
                            'id'    => '_wooaddtocart_product_have_values',
                            'value' => 1
                        ]);
                        
                        woocommerce_wp_checkbox(
                            array(
                                'id'          => '_wooaddtocart_product_hide_cart_button',
                                'label'       => __('Cart Button', 'wooaddtocart'),
                                'description' => __('Button hide', 'wooaddtocart')
                            )
                        );
                        //cart button text replace
                        woocommerce_wp_text_input(
                            array(
                                'id'          => '_wooaddtocart_product_cart_button_text',
                                'label'       => __('Cart Button Text', 'wooaddtocart'),
                                'description' => __('Replace Cart Button Text', 'wooaddtocart'),
                                'desc_tip'    => 'true'
                            )
                        );
                        // Hide Price
                        woocommerce_wp_checkbox(
                            array(
                                'id'          => '_wooaddtocart_product_hide_price',
                                'label'       => __('Hide Price', 'wooaddtocart'),
                                'description' => __('Check me to hide price', 'wooaddtocart')
                            )
                        );
                    ?>
                </div>
            </div>
       <?php
    }


    /**
     * save Data Fields
    */ 
    public static function saveDataFields($post_id)
    {
        if (!isset($_REQUEST['_wooaddtocart_product_have_values'])) {
            return;
        }

        // Save Remove cart button
        if (isset($_REQUEST['_wooaddtocart_product_hide_cart_button'])) { 
            update_post_meta($post_id, '_wooaddtocart_product_hide_cart_button', 'yes');
        } else {
            update_post_meta($post_id, '_wooaddtocart_product_hide_cart_button', 'no');
        }

       
        // Cart button text
        if (isset($_REQUEST['_wooaddtocart_product_cart_button_text'])) {
            update_post_meta($post_id, '_wooaddtocart_product_cart_button_text', sanitize_text_field($_REQUEST['_wooaddtocart_product_cart_button_text']));
        } 

        // Save hide price
        if (isset($_REQUEST['_wooaddtocart_product_hide_price'])) {
            update_post_meta($post_id, '_wooaddtocart_product_hide_price', 'yes');
        } else {
            update_post_meta($post_id, '_wooaddtocart_product_hide_price', 'no');
        }

    }

}

