<?php

namespace WooAddToCart\Classes;

class Customization 
{

    public static function wooAddToCartAddSettings($settings)
    {
        $settings[] = include_once 'WooAddToCartSettings.php';
        return $settings;
    }
  

    public static function customStyle()
    {
        // First enqueue the base stylesheet
        wp_enqueue_style("wooaddtocart-css", WOOADDTOCART_PLUGIN_DIR_URL . "src/public/css/woo-add-to-cart.css");

        // Get all your options
        $bgColor            = get_option('_wooaddtocart_settings_button_bg_color', '#735dee');
        $textColor          = get_option('_wooaddtocart_settings_button_text_color', '#ffffff');
        $borderColor        = get_option('_wooaddtocart_settings_button_border_color', '#cfc6f5');
        $hoverColor         = get_option('_wooaddtocart_settings_button_hover_color', '#4c4747');
        $borderSize         = get_option('_wooaddtocart_settings_button_border_size', '');
        $borderRadius       = get_option('_wooaddtocart_settings_button_radius_size', '');
        $fontSize           = get_option('_wooaddtocart_settings_button_font_size', '');
        $buttonType         = get_option('_wooaddtocart_settings_button_type', 'none');
        $buttonIcon         = get_option('_wooaddtocart_settings_button_icon', 'wooaddtocart-shopping-cart');
        $buttonIconPosition = get_option('_wooaddtocart_settings_button_icon_position', 'before');
        
        // Build CSS string
        $custom_css = "button.wc-block-components-product-button__button.add_to_cart_button.wooaddtocart-custom-css, .wooaddtocart-custom-css  {";
        
            if ($bgColor) {
                $custom_css .= "background: $bgColor !important;";
            }
            if ($textColor) {
                $custom_css .= "color: $textColor !important;";
            }
            if ($buttonType) {
                $custom_css .= "border-style: $buttonType !important;
                            border-width: {$borderSize}px !important;
                            border-color: $borderColor !important;";
            }
            if ($borderRadius) {
                $custom_css .= "border-radius: {$borderRadius}px !important;";
            }
            if ($fontSize) {
                $custom_css .= "font-size: {$fontSize}px !important;";
            }
        
            $custom_css .= "transition: 0.3s;
        }
        
        button.wc-block-components-product-button__button.add_to_cart_button.wooaddtocart-custom-css:hover, .wooaddtocart-custom-css:hover {";
        
        if ($hoverColor) {
            $custom_css .= "background: $hoverColor !important;";
        }
       
        if ($textColor) {
            $custom_css .= "color: $textColor !important;";
        }
        
        $custom_css .= "}";
        
        // Add icon CSS if an icon is set
        if ($buttonIcon) {
            $custom_css .= "
            .wooaddtocart-cart-arrow-down:$buttonIconPosition { content: \"\\61\"; }
            .wooaddtocart-cart-plus:$buttonIconPosition { content: \"\\62\"; }
            .wooaddtocart-bag:$buttonIconPosition { content: \"\\63\"; }
            .wooaddtocart-caddie-shop-shopping-streamline:$buttonIconPosition { content: \"\\64\"; }
            .wooaddtocart-caddie-shopping-streamline:$buttonIconPosition { content: \"\\65\"; }
            .wooaddtocart-cart-shopping-1:$buttonIconPosition { content: \"\\66\"; }
            .wooaddtocart-shopping-cart:$buttonIconPosition { content: \"\\67\"; }
            .wooaddtocart-bag-1:$buttonIconPosition { content: \"\\68\"; }
            .wooaddtocart-basket:$buttonIconPosition { content: \"\\69\"; }
            .wooaddtocart-grocery:$buttonIconPosition { content: \"\\6a\"; }";
        }
        
        // Add the inline style
        wp_add_inline_style('wooaddtocart-css', $custom_css);
        
       // Script approach that will work more reliably
        if ($buttonIcon) {
            // Register a script file (create a small empty JS file in your plugin)
            wp_enqueue_script(
                'wooaddtocart-script', 
                WOOADDTOCART_PLUGIN_DIR_URL . 'src/public/js/wooaddtocart-script.js', 
                array('jquery'), 
                WOOADDTOCART_PLUGIN_VERSION, 
                true
            );
            
            // Pass the icon class to JavaScript
            wp_localize_script('wooaddtocart-script', 'wooAddToCartData', array(
                'buttonIcon' => $buttonIcon
            ));
        }
    }
}