<?php
/*
Plugin Name: WooCommerce Add To Cart Button Customizations
Description: The Best Add To Cart Customizations Plugin for Woocommerce.
Version: 1.3.0
Author: Md.Ruhel Khan
Author URI: https://github.com/ruhel241
Plugin URI: https://github.com/ruhel241/add-to-cart-customizations
License: GPLv2 or later
Text Domain: wooaddtocart
Domain Path: /languages
*/

defined("ABSPATH") or die;

class WooAddToCartCustomizationsLite
{
   
    public function boot()
    {
        if (is_admin()) {
            $this->adminHooks();
        }
        $this->loadTextDomain();
        $this->publicHooks();
        $this->loadDependecies();
   }

    private function loadDependecies()
    {
        include_once 'load.php';
        define("WOOADDTOCART_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
        define("WOOADDTOCART_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
        define("WOOADDTOCART_PLUGIN_DIR_VERSION", '1.3.0');
    }

    public function adminHooks()
    {
        add_filter('woocommerce_product_data_tabs', array('WooAddToCart\Classes\ProductSettings', 'registerProductDataTab'));
        add_action('woocommerce_product_data_panels', array('WooAddToCart\Classes\ProductSettings', 'createDataFields'));
        add_action('woocommerce_process_product_meta', array('WooAddToCart\Classes\ProductSettings', 'saveDataFields'));
        add_filter( 'woocommerce_get_settings_pages', array('WooAddToCart\Classes\Customization', 'wooAddToCartAddSettings'), 15, 1 );
        add_action( 'admin_notices', [$this, 'adminNotice'] );
        // add_action( 'admin_enqueue_scripts', [$this, 'adminEnqueueScript'] );
    }

    public function adminNotice() {
		//get the current screen
		$screen = get_current_screen();
		
		if ( $screen->id == 'dashboard' ||  $screen->id == 'plugins' ) {
			?>
				<div class="notice notice-success is-dismissible">
					<p>
						<?php _e('Congratulations! you have installed "Add To Cart Button Customizations" for WooCommerce plugin, Please rating this plugin.', 'wooaddtocart'); ?>
						<em><a href="https://wordpress.org/support/plugin/add-to-cart-button-customizations/reviews/#new-post" target="_blank">Rating</a></em>
					</p>
				</div>
			<?php
		}
	}

    public function publicHooks()
    {
        // Remove add to cart button on shop page 
            add_filter('woocommerce_loop_add_to_cart_link', array('WooAddToCart\Classes\FrontendHandler', 'removeShopCartButton'), 10, 2);
        // Custom Text add to cart button on shop page
            add_filter( 'woocommerce_product_add_to_cart_text', array('WooAddToCart\Classes\FrontendHandler', 'customTextAddToCartShop'), 30, 1);
        // Custom Text add to cart button on Single page
            add_filter( 'woocommerce_product_single_add_to_cart_text', array('WooAddToCart\Classes\FrontendHandler', 'customTextAddToCartSingle'), 30, 1);
        // remove cart button single page
            add_action('woocommerce_single_product_summary', array('WooAddToCart\Classes\FrontendHandler', 'removeSingleCartButton'), 1);
        // shop Hide Price
            add_filter('woocommerce_get_price_html', array('WooAddToCart\Classes\FrontendHandler', 'hideShopPrice'), 10, 2);
        // Single hide price
            add_action('woocommerce_single_product_summary', array('WooAddToCart\Classes\FrontendHandler', 'hideSinglePrice'), 1);
        // Custom css load
            add_action('wp_head', array('WooAddToCart\Classes\Customization', 'customStyle')); 
       
        // forntend
        add_action('wp', array('WooAddToCart\Classes\FrontendHandler', 'initWooAddToCart'));

    }

    public function loadTextDomain()
    {
        load_plugin_textdomain('wooaddtocart', false, basename(dirname(__FILE__)) . '/languages');
    }

}

add_action('plugins_loaded', function () {
    $WOOADDTOCART = new WooAddToCartCustomizationsLite;
    $WOOADDTOCART->boot();
});



