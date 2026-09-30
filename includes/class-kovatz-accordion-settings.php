<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (  class_exists( 'WC_Settings_Page' ) ) :

	/**
	 * WC_Settings_Accounts
	 */
	class Kovatz_Accordion_Settings extends WC_Settings_Page {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id    = 'kovatz_accordion';
			$this->label = __( 'Kovatz Accordions Tabs', 'accordion-tabs-for-woocommerce' );
			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
			add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
			add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		}

		/**
		 * Get settings array
		 *
		 * @return array
		 */
		public function get_settings() {

			return apply_filters( 'woocommerce_' . $this->id . '_settings',
				array(
					array(
						'title' 			=> __( 'Kovatz Accordions Tabs Settings', 'accordion-tabs-for-woocommerce' ),
						'type' 				=> 'title',
						'desc' 				=> '',
						'id' 					=> 'kovatz_title'
					),
					array(
						'title' 			=> __( 'Enable', 'accordion-tabs-for-woocommerce' ),
						'desc' 				=> __( 'Enable Kovatz Accordions Tab.', 'accordion-tabs-for-woocommerce' ),
						'type' 				=> 'checkbox',
						'id'					=> 'kovatz_accordion[enabled]',
						'default' 		=> 'no'
					),
					array(
						'title' 			=> __( 'Accordion Type', 'accordion-tabs-for-woocommerce' ),
						'desc' 				=> '',
						'type' 				=> 'radio',
						'id'					=> 'kovatz_accordion[accordion_type]',
						'default' 		=> 'one',
						'options'  => [
							'one' => __( 'Open One Accordion at a time', 'accordion-tabs-for-woocommerce' ),
							'all' => __( 'Open Any Number of Accordion', 'accordion-tabs-for-woocommerce' ),
						]
					),
					array(
						'title' 				=> __( 'Use Theme Button Styles', 'accordion-tabs-for-woocommerce' ),
						'desc' 				=> __( 'Use the active theme button styles for accordion headers and desktop tabs.', 'accordion-tabs-for-woocommerce' ),
						'type' 				=> 'checkbox',
						'id' 					=> 'kovatz_accordion[use_theme_button_styles]',
						'default' 		=> 'yes'
					),
					array(
						'title' 	  	=> __( 'Accordion Title Color', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[title_color]',
						'type' 		  	=> 'color',
						'default'	  	=> '#222222',
						'css' 		  	=> 'width: 125px;',
						'desc_tip'	  =>  true
					),
					array(
						'title' 	  	=> __( 'Accordion Active Title Color', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[title_active]',
						'type' 		  	=> 'color',
						'default'	  	=> '#222222',
						'css' 		  	=> 'width: 125px;',
						'desc_tip'	  =>  true
					),

					array(
						'title' 	  	=> __( 'Accordion Arrow', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[arrow_img]',
						'html_id' 		  		=> 'kovatz_accordion_arrow_img',
						'type' 		  	=> 'kovatz_file',
						'default'	  	=> '',
						'css' 		  	=> '',
						'desc_tip'	  =>  true,
					),
					array(
						'title' 	  	=> __( 'Accordion Active Arrow', 'accordion-tabs-for-woocommerce' ),
						'id' 		  	=> 'kovatz_accordion[arrow_active_img]',
						'html_id' 		=> 'kovatz_accordion_arrow_active_img',
						'type' 		  	=> 'kovatz_file',
						'default'	  	=> '',
						'css' 		  	=> '',
						'desc_tip'	  =>  true,
					),
					array(
						'title' 	  	=> __( 'Icon Size', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[icon_size]',
						'type' 		  	=> 'number',
						'default'	  	=> 15,
						'css' 		  	=> 'width: 125px;',
						'custom_attributes' => [
							'min' => 0,
							'max' => 100,
						],
						'suffix' => ' px',
					),
					array(
						'title' 	  	=> __( 'Header Background Color', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[bg]',
						'type' 		  	=> 'color',
						'default'	  	=> '#ffffff',
						'css' 		  	=> 'width: 125px;',
						'desc_tip'	  =>  true
					),
					array(
						'title' 	  	=> __( 'Header Active Background', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[active_bg]',
						'type' 		  	=> 'color',
						'default'	  	=> '#cccccc',
						'css' 		  	=> 'width: 125px;',
						'desc_tip'	  =>  true
					),
					array(
						'title' 	  	=> __( 'Accordion Header Padding', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[header_padding]',
						'type' 		  	=> 'kovatz_dimensions',
						'default' => [
							'top' => 18,
							'right' => 18,
							'bottom' => 18,
							'left' => 18,
						],
						'placeholder' 	=> __( 'px', 'accordion-tabs-for-woocommerce' ),
						'suffix' => ' px',
						'custom_attributes' => [
							'min' => 0,
							'max' => 50,
						],
						'html_id' => 'header_padding',
					),
					array(
						'title' => __( 'Header Border Radius', 'accordion-tabs-for-woocommerce' ),
						'id'    => 'kovatz_accordion[header_border_radius]',
						'type'  => 'kovatz_dimensions',
						'default' => [
							'top' => 0,
							'right' => 0,
							'bottom' => 0,
							'left' => 0,
						],
						'html_id' => 'header_border_radius',
					),
					array(
						'title' 	  	=> __( 'Header Border Width', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[header_border_bottom_width]',
						'type' 		  	=> 'number',
						'default'	  	=> 1,
						'css' 		  	=> 'width: 125px;',
						'desc_tip'	  =>  true,
						'placeholder' 	=> __( 'px', 'accordion-tabs-for-woocommerce' ),
						'suffix' => ' px',
						'custom_attributes' => [
							'min' => 0,
							'max' => 50,
						]
					),
					/*array(
						'title' => __( 'Header Border Width', 'accordion-tabs-for-woocommerce' ),
						'id'    => 'kovatz_accordion[header_border_width]',
						'type'  => 'kovatz_dimensions',
					),*/
					array(
						'title' 	  	=> __( 'Header Border Color', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[header_border_color]',
						'type' 		  	=> 'color',
						'default'	  	=> '#676767',
						'css' 		  	=> 'width: 125px;',
						'desc_tip'	  =>  true
					),
					array(
						'title' 	  	=> __( 'Header Title Size', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[header_title_size]',
						'type' 		  	=> 'number',
						'default'	  	=> 16,
						'css' 		  	=> 'width: 125px;',
						'custom_attributes' => [
							'min' => 10,
							'max' => 100,
						],
						'suffix' => ' px',

					),
					array(
						'title' 	  	=> __( 'Body Background', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[content_bg]',
						'type' 		  	=> 'color',
						'default'	  	=> 'transparent',
						'css' 		  	=> 'width: 125px;',
						'desc_tip'	  =>  true
					),
					array(
						'title' 	  	=> __( 'Accordion Body Padding', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[content_padding]',
						'type' 		  	=> 'number',
						'default'	  	=> '18',
						'css' 		  	=> 'width: 125px;',
						'desc_tip'	  =>  true,
						'placeholder' 	=> __( 'px', 'accordion-tabs-for-woocommerce' ),
						'suffix' => ' px',
						'custom_attributes' => [
							'min' => 0,
							'max' => 50,
						]
					),
					array(
						'title' => __( 'Body Border Radius', 'accordion-tabs-for-woocommerce' ),
						'id'    => 'kovatz_accordion[body_border_radius]',
						'type'  => 'kovatz_dimensions',
						'default' => [
							'top' => 0,
							'right' => 0,
							'bottom' => 0,
							'left' => 0,
						],
						'html_id' => 'body_border_radius',
					),
					array(
						'title' => __( 'Body Border Width', 'accordion-tabs-for-woocommerce' ),
						'id'    => 'kovatz_accordion[body_border_width]',
						'type'  => 'kovatz_dimensions',
						'default' => [
							'top' => 0,
							'right' => 0,
							'bottom' => 1,
							'left' => 0,
						],
						'html_id' => 'body_border_width',
					),
					array(
						'title' 	  	=> __( 'Body Border Color', 'accordion-tabs-for-woocommerce' ),
						'id' 		  		=> 'kovatz_accordion[body_border_color]',
						'type' 		  	=> 'color',
						'default'	  	=> 'none',
						'css' 		  	=> 'width: 125px;',
						'desc_tip'	  =>  true
					),
					array(
						'type' => 'sectionend',
						'id' => 'simple_kovatz_options'
					),

					array( 'type' => 'sectionend', 'id' => 'simple_kovatz_options'),

				)); // End pages settings
		}
	}
	return new Kovatz_Accordion_Settings();

endif;