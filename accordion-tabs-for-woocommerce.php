<?php
/*
 * Plugin Name: Kovatz Accordion Tabs for WooCommerce
   Plugin URI: https://Kovatz.com
   Description: Replace WooCommerce product tabs with a modern, responsive accordion layout. Lightweight, customizable, and optimized for performance.
   License: GPL v2 or later
   License URI: https://www.gnu.org/licenses/gpl-2.0.html
   Author: Kovatz
   Author URI: https://profiles.wordpress.org/kovatz/
   Text Domain: kovatz-accordion-tabs-for-woocommerce
   Version: 1.0.1
   Requires Plugins: woocommerce
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require __DIR__ . '/includes/kovatz-extra-fields.php';
require __DIR__ . '/includes/kovatz-extra-field-file.php';

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'kovatz_plugin_settings_link' );

function kovatz_plugin_settings_link( $links )
{
	$url = admin_url('/admin.php?page=wc-settings&tab=kovatz_accordion');
	$_link = '<a href="'.$url.'" target="_blank">Settings</a>';
	$links[] = $_link;

	return $links;
}

add_filter( 'woocommerce_locate_template', 'kovatz_intercept_wc_template', 10, 3 );
/**
 * Filter the cart template path to use cart.php in this plugin instead of the one in WooCommerce.
 *
 * @param string $template      Default template file path.
 * @param string $template_name Template file slug.
 * @param string $template_path Template file name.
 *
 * @return string The new Template file path.
 */
function kovatz_intercept_wc_template( $template, $template_name, $template_path ) {

	$kovatz_accordion = get_option( 'kovatz_accordion' );

	if( !is_array($kovatz_accordion) ) return $template;
	if( $kovatz_accordion['enabled'] != 'yes'  ) return $template;

	if ( 'tabs.php' === basename( $template ) ) {
		$template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/single-product/tabs/tabs.php';
	}

	return $template;
}

add_filter( 'woocommerce_get_settings_pages', 'kovatz_get_accordion_settings_pages' );

function kovatz_get_accordion_settings_pages( $settings ) {
	$settings[] = include 'includes/class-kovatz-accordion-settings.php';
	return $settings;
}

add_action('wp_enqueue_scripts', 'kovatz_load_scripts');

function kovatz_load_scripts(){

	$kovatz_accordion = get_option( 'kovatz_accordion' );
	if( !is_array($kovatz_accordion) ) return;
	if( $kovatz_accordion['enabled'] != 'yes'  ) return;

	if (is_product()){
		wp_enqueue_script('kovatz-accordion',plugin_dir_url( __FILE__ ).'assets/js/accordion.js',array('jquery'),1.18,true);
		wp_enqueue_style('kovatz-accordion',plugin_dir_url( __FILE__ ).'assets/css/accordion.css','',1.18);

		wp_register_script( 'kovatz-accordion-settings', '','',1.0,['in_footer' => true]);
		wp_localize_script( 'kovatz-accordion-settings', 'kovatz_accordion',
			array(
				'accordion_type' => $kovatz_accordion['accordion_type'] ?? 'one',
			)
		);
		wp_enqueue_script('kovatz-accordion-settings');
	}
}

add_action('admin_enqueue_scripts','kovatz_admin_scripts');

function kovatz_admin_scripts() {
	wp_register_script( 'kovatz-admin-settings', plugin_dir_url( __FILE__ ).'assets/admin/js/kovatz-settings.js',array('jquery'),1.11,['in_footer' => true]);
	wp_register_style( 'kovatz-admin-settings', plugin_dir_url( __FILE__ ).'assets/admin/css/kovatz-settings.css','',1.10);
}

add_filter('woocommerce_product_description_heading','kovatz_product_description_heading');

function kovatz_product_description_heading($heading){

	$kovatz_accordion = get_option( 'kovatz_accordion' );
	if( !is_array($kovatz_accordion) ) return $heading;
	if( $kovatz_accordion['enabled'] != 'yes'  ) return $heading;

	return  false;
}