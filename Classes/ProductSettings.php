<?php

namespace WooAddToCart\Classes;

class ProductSettings
{
    /**
     * Register Tab
    */ 
    public static function registerProductDataTab($product_data_tabs)
    {
        self::adminEnqueueScripts();

        $menuName = esc_html__('Add To Cart Button Customization Lite', 'wooaddtocart');
        
        $product_data_tabs['_wooaddtocart'] = array(
            'label'  => $menuName,
            'target' => 'wooaddtocart_product_data',
            'class'  => array('show_if_wooaddtocart_product_data'),
        );

        return $product_data_tabs;
    }

    // admin enqueue script
    public static function adminEnqueueScripts()
    {
        wp_enqueue_style("wooaddtocart-admin-css", WOOADDTOCART_PLUGIN_DIR_URL . "src/admin/css/woo-admin-add-to-cart.css");
        wp_enqueue_script("wooaddtocart-admin-js", WOOADDTOCART_PLUGIN_DIR_URL . "src/admin/js/woo-admin-add-to-cart.js", array('jquery'), WOOADDTOCART_PLUGIN_DIR_VERSION, true);
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

                        woocommerce_wp_checkbox(
                            array(
                                'id'          => '_wooaddtocart_inquire_us',
                                'label'       => __('Inquire Us', 'wooaddtocart'),
                                'description' => __('Enable', 'wooaddtocart')
                            )
                        );   
                    ?>
                    <div id="_wooaddtocart_inquire" style="display:none"> 
                        <?php
                            woocommerce_wp_text_input(
                                array(
                                    'id'          => '_wooaddtocart_inquire_text',
                                    'label'       => __('Inquire Us Text', 'wooaddtocart'),
                                    'placeholder' => __('Contact US', 'wooaddtocart'),
                                    'desc_tip'    => 'true',
                                    'description' => __('Inquire Us Text.', 'wooaddtocart')
                                )
                            );

                            woocommerce_wp_text_input(
                                array(
                                    'id'          => '_wooaddtocart_inquire_link',
                                    'label'       => __('Inquire Us Link', 'wooaddtocart'),
                                    'placeholder' => __('link', 'wooaddtocart'),
                                    'desc_tip'    => 'true',
                                    'description' => __('Inquire Us Link.', 'wooaddtocart')
                                )
                            );

                            woocommerce_wp_radio(
                                array(
                                    'label'   => __('Inquire Us Button', 'wooaddtocart'),
                                    'id'      => '_wooaddtocart_inquire_us_button',
                                    'options' => array(
                                        'below_title'           => __("Below Title", 'wooaddtocart'),
                                        'below_description'     => __("Below Description", 'wooaddtocart'),
                                        'next_to_cart_button'   => __("Next To Cart Button", 'wooaddtocart'),
                                    ),
                                )
                            );
                        ?>
                    </div>
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


        // Inquire Us Enable
        if (isset($_REQUEST['_wooaddtocart_inquire_us'])) {
            update_post_meta($post_id, '_wooaddtocart_inquire_us', 'yes');
        } else {
            update_post_meta($post_id, '_wooaddtocart_inquire_us', 'no');
        }

        // inquire Text Field
        if (!add_post_meta($post_id, '_wooaddtocart_inquire_text', 'Buy Now', true)) {
            update_post_meta($post_id, '_wooaddtocart_inquire_text', sanitize_text_field($_REQUEST['_wooaddtocart_inquire_text']));
        }

        // inquire Link Field
         if (isset($_REQUEST['_wooaddtocart_inquire_link'])) {
            update_post_meta($post_id, '_wooaddtocart_inquire_link', sanitize_text_field($_REQUEST['_wooaddtocart_inquire_link']));
        }
        
        // inquire button
        if (isset($_REQUEST['_wooaddtocart_inquire_us_button'])) {
            update_post_meta($post_id, '_wooaddtocart_inquire_us_button', sanitize_text_field($_REQUEST['_wooaddtocart_inquire_us_button']));
        }

    }
    
}

