<?php

namespace WooAddToCart\Classes;

class Customization 
{

    public static function wooAddToCartAddSettings($settings)
    {
        $settings[] = include_once 'WooAddToCartSettings.php';

        // css file add
		add_action('admin_enqueue_scripts', ['WooAddToCart\Classes\Customization', 'adminEnqueueScripts']);

        return $settings;
    }
  
    public static function adminEnqueueScripts()
    {
        if (
            isset($_GET['page'], $_GET['tab']) &&
            $_GET['page'] === 'wc-settings' &&
            $_GET['tab'] === 'wooaddtocart'
        ) {
            wp_enqueue_style(
                'admin-wooaddtocart-css',
                WOOADDTOCART_PLUGIN_DIR_URL . 'src/admin/css/admin-woo-add-to-cart.css',
                [],
                WOOADDTOCART_PLUGIN_VERSION
            );
        }
    }

    public static function customStyle()
    {
        wp_enqueue_style(
            "wooaddtocart-css",
            WOOADDTOCART_PLUGIN_DIR_URL . "src/public/css/woo-add-to-cart.css",
            [],
            WOOADDTOCART_PLUGIN_VERSION
        );

        // Get options with defaults
        $bgColor       = sanitize_hex_color(get_option('_wooaddtocart_settings_button_bg_color', ''));
        $textColor     = sanitize_hex_color(get_option('_wooaddtocart_settings_button_text_color', ''));
        $borderColor   = sanitize_hex_color(get_option('_wooaddtocart_settings_button_border_color', ''));
        $hoverColor    = sanitize_hex_color(get_option('_wooaddtocart_settings_button_hover_color', ''));
        $borderSize    = absint(get_option('_wooaddtocart_settings_button_border_size', 0));
        $borderRadius  = absint(get_option('_wooaddtocart_settings_button_radius_size', 0));
        $fontSize      = absint(get_option('_wooaddtocart_settings_button_font_size', 0));
        $buttonType    = sanitize_text_field(get_option('_wooaddtocart_settings_button_type', 'none'));
        $paddingTop    = absint(get_option('wooaddtocart_settings_button_padding_top', 0));
        $paddingBottom = absint(get_option('wooaddtocart_settings_button_padding_bottom', 0));
        $paddingRight  = absint(get_option('wooaddtocart_settings_button_padding_right', 0));
        $paddingLeft   = absint(get_option('wooaddtocart_settings_button_padding_left', 0));
        $buttonIcon         = sanitize_text_field(get_option('_wooaddtocart_settings_button_icon', ''));
        $buttonIconPosition = sanitize_text_field(get_option('_wooaddtocart_settings_button_icon_position', 'before'));

        // Build CSS
        $custom_css = "
        button.wc-block-components-product-button__button.add_to_cart_button.wooaddtocart-custom-css,
        .wooaddtocart-custom-css {
            transition: 0.3s;
        ";

        if ($bgColor) {
            $custom_css .= "background:{$bgColor} !important; ";
        }

        if ($textColor) {
            $custom_css .= "color:{$textColor} !important; ";
        }

        // Border only if enabled
        if ($buttonType !== 'none' && $borderSize > 0) {
            $custom_css .= "
                border-style: {$buttonType} !important;
                border-width: {$borderSize}px !important;
                border-color: {$borderColor} !important;
            ";
        } else {
            $custom_css .= "border: none !important; ";
        }

        if ($borderRadius > 0) {
            $custom_css .= "border-radius:{$borderRadius}px !important; ";
        }

        if ($fontSize > 0) {
            $custom_css .= "font-size:{$fontSize}px !important; ";
        }

        if ($paddingTop > 0) {
            $custom_css .= "padding-top:{$paddingTop}px !important; ";
        }

        if ($paddingBottom > 0) {
            $custom_css .= "padding-bottom:{$paddingBottom}px !important; ";
        }

        if ($paddingRight > 0) {
            $custom_css .= "padding-right:{$paddingRight}px !important; ";
        }

        if ($paddingLeft > 0) {
            $custom_css .= "padding-left:{$paddingLeft}px !important; ";
        }

        $custom_css .= "}";

        // Hover
        $custom_css .= "
        button.wc-block-components-product-button__button.add_to_cart_button.wooaddtocart-custom-css:hover,
        .wooaddtocart-custom-css:hover {
        ";

        if ($hoverColor) {
            $custom_css .= "background:{$hoverColor} !important; ";
        }

        if ($textColor) {
            $custom_css .= "color:{$textColor} !important; ";
        }

        $custom_css .= "}";

        // Icon CSS
        if (!empty($buttonIcon)) {
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

        wp_add_inline_style('wooaddtocart-css', $custom_css); 

        wp_enqueue_script(
            'wooaddtocart-script',
            WOOADDTOCART_PLUGIN_DIR_URL . 'src/public/js/wooaddtocart-script.js',
            ['jquery'],
            WOOADDTOCART_PLUGIN_VERSION,
            true
        );

        wp_localize_script('wooaddtocart-script', 'wooAddToCartDataVar', [
            'buttonIcon' => $buttonIcon
        ]);
    }
}