<?php

namespace WooAddToCart\Classes;

class Customization {

    public static function wooAddToCartAddSettings($settings) {
        $settings[] = include_once 'WooAddToCartSettings.php';
        return $settings ;
    }
  
    public static function customStyle(){

        wp_enqueue_style("wooaddtocart-css", WOOADDTOCART_PLUGIN_DIR_URL . "src/public/css/woo-add-to-cart.css");

        $bgColor            = get_option('_wooaddtocart_settings_button_bg_color', '#7901ff');
        $textColor          = get_option('_wooaddtocart_settings_button_text_color', '#ff185f');
        $borderColor        = get_option('_wooaddtocart_settings_button_border_color', '#ffffff');
        $hoverColor         = get_option('_wooaddtocart_settings_button_hover_color', '#9B4DCA');
        $borderSize         = get_option('_wooaddtocart_settings_button_border_size', '');
        $borderRadius       = get_option('_wooaddtocart_settings_button_radius_size', '');
        $fontSize           = get_option('_wooaddtocart_settings_button_font_size', '');
        $buttonType         = get_option('_wooaddtocart_settings_button_type', 'none');
        $buttonIcon         = get_option('_wooaddtocart_settings_button_icon', '');
        $buttonIconPosition = get_option('_wooaddtocart_settings_button_icon_position', 'none');
        ?>
        <style type='text/css'>
 
            ul.products li.product .button, .single_add_to_cart_button {
                <?php  echo $bgColor ? ("background: $bgColor !important;") : '';?>
                <?php  echo $textColor ? ("color: $textColor !important;") : '';?>
                <?php  echo $buttonType ? ("border: $buttonType !important;") : '';?>
                <?php  echo $borderColor ? ("border-color: $borderColor !important;") : '';?>
                <?php  echo $borderSize ? ("border-width: $borderSize".'px !important;') : '';?>
                <?php  echo $borderRadius ? ("border-radius: $borderRadius".'px !important;') : '';?>
                <?php  echo $fontSize ? ("font-size: $fontSize".'px !important;') : ''; ?>
            }
            
            ul.products li.product .button:hover, .single_add_to_cart_button:hover {
               <?php  echo $hoverColor ? ("background: $hoverColor !important;") : ''; ?>
               <?php  echo $textColor ? ("color: $textColor !important;") : ''; ?>
            }

            <?php if($buttonIcon): ?>
                .wooaddtocart-cart-arrow-down:<?php echo $buttonIconPosition;?> {
                    content: "\61";
                }
                .wooaddtocart-cart-plus:<?php echo $buttonIconPosition;?> {
                    content: "\62";
                }
                .wooaddtocart-bag:<?php echo $buttonIconPosition;?> {
                    content: "\63";
                }
                .wooaddtocart-caddie-shop-shopping-streamline:<?php echo $buttonIconPosition;?> {
                    content: "\64";
                }
                .wooaddtocart-caddie-shopping-streamline:<?php echo $buttonIconPosition;?> {
                    content: "\65";
                }
                .wooaddtocart-cart-shopping-1:<?php echo $buttonIconPosition;?> {
                    content: "\66";
                }
                .wooaddtocart-shopping-cart:<?php echo $buttonIconPosition;?> {
                    content: "\67";
                }
                .wooaddtocart-bag-1:<?php echo $buttonIconPosition;?> {
                    content: "\68";
                }
                .wooaddtocart-basket:<?php echo $buttonIconPosition;?> {
                    content: "\69";
                }
                .wooaddtocart-grocery:<?php echo $buttonIconPosition;?> {
                    content: "\6a";
                }
            <?php endif; ?>
        </style>

        <?php if($buttonIcon): ?>
            <script>
                jQuery(document).ready(function($) {
                    $('.add_to_cart_button, .single_add_to_cart_button').addClass('<?php echo $buttonIcon; ?>');
                })
            </script>
        <?php endif;
    }

}