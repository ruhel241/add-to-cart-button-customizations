<?php
/*
Plugin Name: Add To Cart Button Customizations
Description: The Best Add To Cart Customizations Plugin for Woocommerce.
Version: 2.0.2
Author: wpcreativeidea
Author URI: https://wpcreativeidea.com/home
Plugin URI: https://wpcreativeidea.com/add-to-cart-button
License: GPLv2 or later
Text Domain: wooaddtocart
Domain Path: /languages
*/

defined("ABSPATH") or die;

class WooAddToCartCustomizationsLite
{
   
    public function boot()
    {
        $this->loadDependencies();
        
        if (is_admin()) {
            $this->adminHooks();
        }
        $this->publicHooks();
    }

    private function loadDependencies()
    {
        // Define constants before they're needed
        define("WOOADDTOCART_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
        define("WOOADDTOCART_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
        define("WOOADDTOCART_PLUGIN_VERSION", '2.0.2'); // Keep original constant name
        
        include_once 'load.php';
    }

    public function adminHooks()
    {
        add_filter('woocommerce_product_data_tabs', array('WooAddToCart\Classes\ProductSettings', 'registerProductDataTab'));
        add_action('woocommerce_product_data_panels', array('WooAddToCart\Classes\ProductSettings', 'createDataFields'));
        add_action('woocommerce_process_product_meta', array('WooAddToCart\Classes\ProductSettings', 'saveDataFields'));
        add_filter('woocommerce_get_settings_pages', array('WooAddToCart\Classes\Customization', 'wooAddToCartAddSettings'), 15, 1);
        add_action('admin_notices', [$this, 'adminNotice']);
        add_action('admin_init', [$this, 'atcbc_notice_dismissed']);
    }

    public function adminNotice() {
        $screen  = get_current_screen();
        $user_id = get_current_user_id();
        $nonce   = wp_create_nonce('atcbc_dismiss_notice_nonce');
    
        // Ensure user meta exists
        if (!get_user_meta($user_id, 'atcbc-notice-dismissed', true)) {
            add_user_meta($user_id, 'atcbc-notice-dismissed', 'active');
        }
    
        // Show notice only on specific screens
        if ($screen && in_array($screen->id, ['dashboard', 'plugins'], true)) {
            if (get_user_meta($user_id, 'atcbc-notice-dismissed', true) === 'active') { 
                ?>
                <div class="notice notice-success is-dismissible" id="is_atcbcReviewNotice">
                    <p>
                        <?php esc_html_e('Congratulations! You have installed "Add To Cart Button Customizations" for WooCommerce plugin. Please consider rating this plugin.', 'wooaddtocart'); ?>
                        <em><a href="https://wordpress.org/support/plugin/add-to-cart-button-customizations/reviews/#new-post" target="_blank"><?php esc_html_e('Rate Us', 'wooaddtocart'); ?></a></em>
                    </p>
                    <button type="button" class="notice-dismiss" onclick="window.location.href='<?php echo esc_url(add_query_arg(['atcbc-dismissed-notice' => 1, 'atcbc_nonce' => $nonce])); ?>'"></button>
                </div>
                <?php
            }
        }
    }

    public function atcbc_notice_dismissed() {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return;
        }
        
        // Verify nonce and parameter existence
        if (!isset($_GET['atcbc-dismissed-notice'], $_GET['atcbc_nonce']) || 
            !wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['atcbc_nonce'])), 'atcbc_dismiss_notice_nonce')) {
            return;
        }
        
        // Update user meta
        $user_id = get_current_user_id();
        update_user_meta($user_id, 'atcbc-notice-dismissed', 'deactive');
        
        // Redirect back to remove query parameters
        if (isset($_SERVER['HTTP_REFERER'])) {
            wp_safe_redirect($_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    public function publicHooks()
    {
        // Remove add to cart button on shop page 
        add_filter('woocommerce_loop_add_to_cart_link', array('WooAddToCart\Classes\FrontendHandler', 'removeShopCartButton'), 10, 2);
        // Custom Text add to cart button on shop page
        add_filter('woocommerce_product_add_to_cart_text', array('WooAddToCart\Classes\FrontendHandler', 'customTextAddToCartShop'), 30, 1);
        // Custom Text add to cart button on Single page
        add_filter('woocommerce_product_single_add_to_cart_text', array('WooAddToCart\Classes\FrontendHandler', 'customTextAddToCartSingle'), 30, 1);
        // remove cart button single page
        add_action('woocommerce_before_single_product', array('WooAddToCart\Classes\FrontendHandler', 'removeSingleCartButton'), 1);
        // shop Hide Price
        add_filter('woocommerce_get_price_html', array('WooAddToCart\Classes\FrontendHandler', 'hideShopPrice'), 10, 2);
        // Single hide price
        add_action('woocommerce_before_single_product', array('WooAddToCart\Classes\FrontendHandler', 'hideSinglePrice'), 5);
        // Custom css load
        add_action('wp_enqueue_scripts', array('WooAddToCart\Classes\Customization', 'customStyle'));
    }

    /**
     * Notify the user about the Add To Cart Button Customizations dependency and instructs to install it.
     */
    public function injectDependency()
    {
        add_action('admin_notices', function () {
            $pluginInfo = $this->getInstallationDetails();

            $class = 'notice notice-error';

            $install_url_text = 'Click Here to Install the Plugin';

            if ($pluginInfo->action == 'activate') {
                $install_url_text = 'Click Here to Activate the Plugin';
            }

            $message = 'Add To Cart Button Customizations For Woocommerce Add-On Requires Woocommerce Base Plugin, <b><a href="' . $pluginInfo->url
                . '">' . $install_url_text . '</a></b>';

            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), wp_kses_post($message));
        });
    }

    /**
     * Get the Add To Cart Button Customizations For Woocommerce plugin installation information e.g. the URL to install.
     *
     * @return \stdClass $activation
     */
    protected function getInstallationDetails()
    {
        $activation = (object)[
            'action' => 'install',
            'url'    => ''
        ];

        $allPlugins = get_plugins();

        if (isset($allPlugins['woocommerce/woocommerce.php'])) {
            $url = wp_nonce_url(
                self_admin_url('plugins.php?action=activate&plugin=woocommerce/woocommerce.php'),
                'activate-plugin_woocommerce/woocommerce.php'
            );
            
            $activation->action = 'activate';
        } else {
            $api = (object)[
                'slug' => 'woocommerce'
            ];

            $url = wp_nonce_url(
                self_admin_url('update.php?action=install-plugin&plugin=' . $api->slug),
                'install-plugin_' . $api->slug
            );
        }

        $activation->url = $url;

        return $activation;
    }
}

add_action('plugins_loaded', function () {
    // Check for WooCommerce dependency before instantiating the plugin
    if (!defined('WC_PLUGIN_FILE')) {
        $plugin = new WooAddToCartCustomizationsLite();
        return $plugin->injectDependency();
    }

    $WOOADDTOCART = new WooAddToCartCustomizationsLite();
    $WOOADDTOCART->boot();
});

register_deactivation_hook(__FILE__, function () {
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'atcbc-notice-dismissed', 'active');
});