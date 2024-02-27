<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'WooAddToCartSettings' ) ) :
    /**
	 * Settings class
	 *
	 * @since 1.0.0
	 */
class WooAddToCartSettings extends WC_Settings_Page
{
	
	/**
	 * Setup settings class
	 *
	 * @since  1.0
	 */

	
	public function __construct() 
	{
		$this->id    = 'wooaddtocart';
		$this->label = __( 'Add To Cart Customization Settings', 'wooaddtocart' );
		
		add_filter( 'woocommerce_settings_tabs_array',        array( $this, 'add_settings_page' ), 20 );
		add_action( 'woocommerce_settings_' . $this->id,      array( $this, 'output' ) );
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		add_action( 'woocommerce_sections_' . $this->id,      array( $this, 'output_sections' ) );
	}
	
	
	/**
	 * Get sections
	 *
	 * @return array
	 */
	public function get_sections() 
	{
		$sections = array(
			'' => __( 'Button Hide Settings', 'wooaddtocart' ),
			'button_customization'   => __( 'Button Customization', 'wooaddtocart')
		);
		
		return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}
	
	/**
	 * Get settings array
	 *
	 * @since 1.0.0
	 * @param string $current_section Optional. Defaults to empty string.
	 * @return array Array of settings
	 */
	public function get_settings( $current_section = '' ) 
	{
		if ( 'button_customization' == $current_section ) {

			$settings = apply_filters('wooaddtocart_cart_button_customization_data', array(
			
				array(
					'name'     => __( 'Add To Cart Button Customization', 'wooaddtocart' ),
					'type'     => 'title',
					'desc'     => 'You can customize "Add To Cart" Button background, Button color, Button font size etc',
					'id'       => '_wooaddtocart_settings_title'
				),
				
				array(
					'name'     => __( 'Button Background Color', 'wooaddtocart' ),
					'type'     => 'color',
					'desc'     => __( 'Button Background Color', 'wooaddtocart' ),
					'desc_tip' => true,
					'id'       => '_wooaddtocart_settings_button_bg_color',
					'css'      => 'width:165px',
					'default'  => '#735dee',
				),
	
				array(
					'name'     => __( 'Text Font Color', 'wooaddtocart' ),
					'type'     => 'color',
					'desc'     => __( 'Text Font Color', 'wooaddtocart'),
					'desc_tip' => true,
					'id'	   => '_wooaddtocart_settings_button_text_color',
					'css'      => 'width:165px',
					'default'  => '#ffffff',
				),
				array(
					'name'     => __( 'Hover Color', 'wooaddtocart' ),
					'type'     => 'color',
					'desc'     => __( 'Hover Color', 'wooaddtocart'),
					'desc_tip' => true,
					'id'	   => '_wooaddtocart_settings_button_hover_color',
					'css'      => 'width:165px',
					'default'  => '#4c4747',
				),
				array(
					'name'     => __( 'Button Radius', 'wooaddtocart' ),
					'type'     => 'number',
					'desc'     => __( 'Button Radius', 'wooaddtocart'),
					'desc_tip' => true,
					'id'	   => '_wooaddtocart_settings_button_radius_size',
					'css'      => 'width:200px',
				),
				array(
					'name'     => __( 'Text Font Size', 'wooaddtocart' ),
					'type'     => 'number',
					'desc'     => __( 'Text Font Size', 'wooaddtocart'),
					'desc_tip' => true,
					'id'	   => '_wooaddtocart_settings_button_font_size',
					'css'      => 'width:200px',
				),
				array(
					'name'     => __( 'Button Type', 'wooaddtocart' ),
					'type'     => 'select',
					'desc'     => __( 'Button Type', 'wooaddtocart'),
					'desc_tip' => true,
					'id'	   => '_wooaddtocart_settings_button_type',
					'css'      => 'width:200px',
					'options'  => array(
						'none'   => __( 'None', 'wooaddtocart' ),
						'solid'  => __( 'Solid', 'wooaddtocart' ),
                        'double' => __( 'Double', 'wooaddtocart' ),
						'dotted' => __( 'Dotted', 'wooaddtocart' ),
						'dashed' => __( 'Dashed', 'wooaddtocart' )
					),
				),
				array(
					'name'     => __( 'Border Width', 'wooaddtocart' ),
					'type'     => 'number',
					'desc'     => __( 'Border Width', 'wooaddtocart'),
					'desc_tip' => true,
					'id'	   => '_wooaddtocart_settings_button_border_size',
					'css'      => 'width:200px',
				),
				array(
					'name'     => __( 'Border Color', 'wooaddtocart' ),
					'type'     => 'color',
					'desc'     => __( 'Border Color', 'wooaddtocart'),
					'desc_tip' => true,
					'id'	   => '_wooaddtocart_settings_button_border_color',
					'css'      => 'width:165px',
					'default'  => '#cfc6f5',
				),

				array(
					'name'     => __( 'Button Icon', 'wooaddtocart' ),
					'type'     => 'select',
					'desc'     => __( 'Button Icon', 'wooaddtocart'),
					'desc_tip' => true,
					'id'	   => '_wooaddtocart_settings_button_icon',
					'css'      => 'width:200px',
					'default'  => 'wooaddtocart-shopping-cart',
					'options'  => array(
						''  => __( 'None', 'wooaddtocart' ),
						'wooaddtocart-cart-arrow-down'  => __( 'Cart Arrow Down', 'wooaddtocart' ),
                        'wooaddtocart-cart-plus'    	=> __( 'Cart Plus', 'wooaddtocart' ),
						'wooaddtocart-bag'  			=> __( 'Bag', 'wooaddtocart' ),
						'wooaddtocart-caddie-shop-shopping-streamline'  => __( 'Shop Shopping', 'wooaddtocart' ),
						'wooaddtocart-caddie-shopping-streamline'  => __( 'Shopping', 'wooaddtocart' ),
						'wooaddtocart-cart-shopping-1'  => __( 'Cart Shopping1', 'wooaddtocart' ),
						'wooaddtocart-shopping-cart'    => __( 'Shopping Cart', 'wooaddtocart' ),
						'wooaddtocart-bag-1'  			=> __( 'Bag-1', 'wooaddtocart' ),
						'wooaddtocart-basket'  			=> __( 'Basket', 'wooaddtocart' ),
						'wooaddtocart-grocery' 			=> __( 'Grocery', 'wooaddtocart' )
					),
				),
				
				array(
					'name'     => __( 'Button Icon Position', 'wooaddtocart' ),
					'type'     => 'select',
					'desc'     => __( 'Button Icon Position', 'wooaddtocart'),
					'desc_tip' => true,
					'id'	   => '_wooaddtocart_settings_button_icon_position',
					'css'      => 'width:200px',
					'options'  => array(
						'before'=> __( 'Before', 'wooaddtocart' ),
                        'after' => __( 'After', 'wooaddtocart' ),
					),
				),

				array(
					'type'  => 'sectionend',
					'id'    => '_wooaddtocart_settings_section_end'
				)
			) );	
		} else {
			$settings = apply_filters('wooaddtocart_cart_button_custom_data', array(
			
				array(
					'name'     => __( 'Add To Cart Button Custom Settings', 'wooaddtocart' ),
					'desc'     => 'If the "Add To Cart" Button is hidden in the single product then it\'s working.',
					'type'     => 'title',
                    'id'       => '_wooaddtocart_button_custom_settings_title'
                ),
				
				array(
                    'title'    => __( 'Button Hide', 'wooaddtocart' ),
                    'id'       => '_wooaddtocart_settings_button_hide',
                    'default'  => 'global_page',
                    'type'     => 'radio',
                    'options'  => array(
						'global_page'  => __( 'Global page', 'wooaddtocart' ),
                        'shop_page'    => __( 'Shop Page', 'wooaddtocart' ),
						'single_page'  => __( 'Single page', 'wooaddtocart' )
					),
				),

				array(
                    'type'  => 'sectionend',
                    'id'    => '_wooaddtocart_settings_section_end'
                )
			) );
		}
		?>

		<script>
			jQuery(document).ready(function($) {
				const buttonType  =  $("#_wooaddtocart_settings_button_type");
				const buttonWidth =  $('#_wooaddtocart_settings_button_border_size');
				const buttonColor =  $('#_wooaddtocart_settings_button_border_color');

				if ( buttonType.val() == 'none') {
					$(buttonWidth).closest('tr').hide();
					$(buttonColor).closest('tr').hide();
				}
				
				$(buttonType).change(function(){
					if ($(this).val() != 'none') {
						$(buttonWidth).closest('tr').fadeIn();
						$(buttonColor).closest('tr').fadeIn();
					} else {
						$(buttonWidth).closest('tr').fadeOut();
						$(buttonColor).closest('tr').fadeOut();
					}
				})
			})
		</script>
		
		<?php

		return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );
	}
	
	
	/**
	 * Output the settings
	 *
	 * @since 1.0
	 */
	public function output() 
	{
		global $current_section;
		
		$settings = $this->get_settings( $current_section );
		WC_Admin_Settings::output_fields( $settings );
	}
	
	
	/**
	 * Save settings
		*
		* @since 1.0
		*/
	public function save()
	{
		global $current_section;
		
		$settings = $this->get_settings( $current_section );
		WC_Admin_Settings::save_fields( $settings );
	}
}

return new WooAddToCartSettings();

endif;