<?php

namespace WooAddToCart\Classes;

class Customization 
{

    public static function wooAddToCartAddSettings($settings)
    {
        $settings[] = include_once 'WooAddToCartSettings.php';
        return $settings ;
    }
  
    public static function customStyle()
    {
        wp_enqueue_style("wooaddtocart-css", WOOADDTOCART_PLUGIN_DIR_URL . "src/public/css/woo-add-to-cart.css");

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
        ?>
        <style type='text/css'>
            button.wc-block-components-product-button__button.add_to_cart_button.wooaddtocart-custom-css, .wooaddtocart-custom-css  {
                <?php  echo $bgColor ? ("background: $bgColor !important;") : '';?>
                <?php  echo $textColor ? ("color: $textColor !important;") : '';?>
                <?php 
                    if ($buttonType ) {
                        echo "border-style: $buttonType !important;
                        border-width: $borderSize"."px !important;
                        border-color: $borderColor !important;";
                    } 
                ?>
                <?php  echo $borderRadius ? ("border-radius: $borderRadius".'px !important;') : '';?>
                <?php  echo $fontSize ? ("font-size: $fontSize".'px !important;') : ''; ?>
                <?php  echo "transition: 0.3s"; ?>
            }
            
            button.wc-block-components-product-button__button.add_to_cart_button.wooaddtocart-custom-css:hover, .wooaddtocart-custom-css:hover {
               <?php  echo $hoverColor ? ("background: $hoverColor !important;") : ''; ?>
               <?php  echo $textColor ? ("color: $textColor !important;") : ''; ?>
            }

            <?php if ($buttonIcon): ?>
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

        <?php if ($buttonIcon) : ?>
            <script>
                jQuery(document).ready(function($) {
                    $('.add_to_cart_button, .single_add_to_cart_button, .wc-block-components-product-button__button').addClass('<?php echo $buttonIcon; ?> wooaddtocart-custom-css');
                })
            </script>
        <?php endif;
    }
}