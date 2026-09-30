<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */

$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) :
    $product_tab_keys = array_keys( $product_tabs );
    $active_tab_key  = isset( $product_tabs['description'] ) ? 'description' : reset( $product_tab_keys );
    $kovatz_accordion = get_option( 'kovatz_accordion', array() );
    if ( ! is_array( $kovatz_accordion ) ) {
        $kovatz_accordion = array();
    }
    $use_theme_button_styles = ( $kovatz_accordion['use_theme_button_styles'] ?? 'yes' ) === 'yes';
?>

	<div class="woocommerce-tabs wc-tabs-wrapper">

        <div class="kovatz-desktop-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Product information', 'woocommerce' ); ?>">
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                <button id="tab-<?php echo esc_attr( $key ); ?>" class="button kovatz-tab-button <?php if ( $active_tab_key === $key ) echo 'kovatz-active'; ?>" type="button" role="tab" data-target="#flush-<?php echo esc_attr( $key ); ?>" aria-selected="<?php echo ( $active_tab_key === $key ) ? 'true' : 'false'; ?>" aria-controls="flush-<?php echo esc_attr( $key ); ?>" tabindex="<?php echo ( $active_tab_key === $key ) ? '0' : '-1'; ?>">
                    <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                </button>
            <?php endforeach; ?>
        </div>

		<div class="kovatz-accordion" id="kovatz-accordionFlushWC">

            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>

                <div class="kovatz-accordion-item <?php if ( $active_tab_key === $key ) echo 'kovatz-active'; ?>">
                    <h2 class="kovatz-accordion-header <?php echo esc_attr( $key ); ?>_tab" id="accordion-title-<?php echo esc_attr( $key ); ?>">
                        <button class="button kovatz-accordion-button" type="button" data-target="#flush-<?php echo esc_attr( $key ); ?>" aria-expanded="<?php echo ( $active_tab_key === $key ) ? 'true' : 'false'; ?>" aria-controls="flush-<?php echo esc_attr( $key ); ?>" >
							<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
						</button>
					</h2>
                    <div id="flush-<?php echo esc_attr( $key ); ?>" class="kovatz-accordion-body <?php if ( $active_tab_key === $key ) echo 'show'; ?>" role="tabpanel" aria-labelledby="tab-<?php echo esc_attr( $key ); ?>" data-parent="#kovatz-accordionFlushWC">
						<div class="kovatz-accordion-content">
							<?php
							if ( isset( $product_tab['callback'] ) ) {
								call_user_func( $product_tab['callback'], $key, $product_tab );
							}
							?>
						</div>
					</div>
				</div>
                <?php endforeach; ?>
		</div>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

	<?php

        $kovatz_accordion = get_option( 'kovatz_accordion' );
        $kovatz_accordion = shortcode_atts( array(
            'bg'                   => '#ffffff',
            'active_bg'            => '#cccccc',
            'title_color'          => '#222222',
            'title_active'         => '#222222',
            'arrow_img'            => '',
            'arrow_active_img'     => '',
            'content_bg'           => 'transparent',
            'content_padding'      => '18',
            'header_border_radius' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0' ],
            'body_border_radius'   => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0' ],
            'header_border_bottom_width'  => 1,
            'header_border_color'  => '#676767',
            'body_border_width'  => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0' ],
            'body_border_color'  => 'none',
            'header_padding'       => [ 'top' => 18, 'right' => 18, 'bottom' => 18, 'left' => 18 ],
            'header_title_size' => 16,
            'icon_size' => 15,
        ), $kovatz_accordion );

        $kovatz_accordion['content_bg'] = str_replace( '#ffffff', 'transparent', $kovatz_accordion['content_bg'] );

        ob_start();
	?>
        .kovatz-accordion-item:first-of-type {
            border-top-left-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['top']); ?>px;
            border-top-right-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['right']); ?>px;
        }
        .kovatz-accordion-item:last-of-type {
            border-bottom-right-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['bottom']); ?>px;
            border-bottom-left-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['left']); ?>px;
        }
        <?php if ( ! $use_theme_button_styles ) : ?>
        .kovatz-accordion-item:first-of-type .kovatz-accordion-header .kovatz-accordion-button {
            border-top-left-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['top']); ?>px;
            border-top-right-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['right']); ?>px;
        }
        <?php endif; ?>
        <?php if ( ! $use_theme_button_styles ) : ?>
        .kovatz-accordion-item:last-of-type:not(.kovatz-active) .kovatz-accordion-header .kovatz-accordion-button{
            border-bottom-right-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['bottom']); ?>px;
            border-bottom-left-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['left']); ?>px;
        }
        <?php endif; ?>
        .kovatz-accordion-item:last-of-type .kovatz-accordion-body{
            border-bottom-right-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['bottom']); ?>px;
            border-bottom-left-radius: <?php echo esc_html($kovatz_accordion['body_border_radius']['left']); ?>px;
        }
        .kovatz-accordion-item{
            border-width: <?php echo esc_html($kovatz_accordion['body_border_width']['top']); ?>px
                    <?php echo esc_html($kovatz_accordion['body_border_width']['right']); ?>px
                    <?php echo esc_html($kovatz_accordion['body_border_width']['bottom']); ?>px
                    <?php echo esc_html($kovatz_accordion['body_border_width']['left']); ?>px;
            border-style:solid;
            border-color: rgba(0, 0, 0, .125);
        }
        <?php if ( ! $use_theme_button_styles ) : ?>
        .kovatz-accordion-item .kovatz-accordion-header .kovatz-accordion-button{
            background-color: <?php echo esc_html(sanitize_hex_color($kovatz_accordion['bg'])); ?>;
            color:  <?php echo esc_html(sanitize_hex_color($kovatz_accordion['title_color'])); ?>;
            padding:  <?php echo esc_html($kovatz_accordion['header_padding']['top']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_padding']['right']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_padding']['bottom']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_padding']['left']); ?>px;
            border: none;
            border-radius:
                    <?php echo esc_html($kovatz_accordion['header_border_radius']['top']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_border_radius']['right']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_border_radius']['bottom']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_border_radius']['left']); ?>px
                ;
            font-size: <?php echo esc_html($kovatz_accordion['header_title_size']); ?>px;
        }
        .kovatz-desktop-tabs .kovatz-tab-button{
            background-color: <?php echo esc_html(sanitize_hex_color($kovatz_accordion['bg'])); ?>;
            color: <?php echo esc_html(sanitize_hex_color($kovatz_accordion['title_color'])); ?>;
            padding: <?php echo esc_html($kovatz_accordion['header_padding']['top']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_padding']['right']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_padding']['bottom']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_padding']['left']); ?>px;
            border-radius: <?php echo esc_html($kovatz_accordion['header_border_radius']['top']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_border_radius']['right']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_border_radius']['bottom']); ?>px
                    <?php echo esc_html($kovatz_accordion['header_border_radius']['left']); ?>px;
            font-size: <?php echo esc_html($kovatz_accordion['header_title_size']); ?>px;
                border: 0;
                border-bottom: 2px solid transparent;
        }
        .kovatz-desktop-tabs .kovatz-tab-button.kovatz-active,
        .kovatz-desktop-tabs .kovatz-tab-button:hover{
            background-color: <?php echo esc_html(sanitize_hex_color($kovatz_accordion['active_bg'])); ?>;
            color: <?php echo esc_html(sanitize_hex_color($kovatz_accordion['title_active'])); ?>;
            border-bottom-color: <?php echo esc_html(sanitize_hex_color($kovatz_accordion['header_border_color'])); ?>;
        }

        .kovatz-active.kovatz-accordion-item .kovatz-accordion-header .kovatz-accordion-button{
            /*border-bottom: 1px solid #eee;*/
            box-shadow: inset 0 -<?php echo esc_html($kovatz_accordion['header_border_bottom_width']); ?>px 0 <?php echo esc_html(sanitize_hex_color($kovatz_accordion['header_border_color'])); ?>;
        }
        .kovatz-active.kovatz-accordion-item .kovatz-accordion-header .kovatz-accordion-button,
        .kovatz-accordion-item .kovatz-accordion-header .kovatz-accordion-button:hover {
            background-color: <?php echo esc_html(sanitize_hex_color($kovatz_accordion['active_bg'])); ?>;
            color:  <?php echo esc_html(sanitize_hex_color($kovatz_accordion['title_active'])); ?>;
        }
        <?php endif; ?>

        .kovatz-accordion-content{
            padding: <?php echo esc_html($kovatz_accordion['content_padding']); ?>px;
            background-color: <?php echo esc_html(sanitize_hex_color($kovatz_accordion['content_bg'])); ?>;
        }
        .kovatz-accordion-button:after {
            width: <?php echo esc_html($kovatz_accordion['icon_size']); ?>px;
            height: <?php echo esc_html($kovatz_accordion['icon_size']); ?>px;
        }

        <?php if (!empty($kovatz_accordion['arrow_img'])): ?>
            .kovatz-accordion-button:after {
                background: url("<?php echo esc_url($kovatz_accordion['arrow_img']); ?>") center center no-repeat;
                background-size: contain;
            }
        <?php endif; ?>

        <?php if (!empty($kovatz_accordion['arrow_active_img'])): ?>
            .kovatz-active .kovatz-accordion-button:after {
                background: url("<?php echo esc_url($kovatz_accordion['arrow_active_img']); ?>") center center no-repeat;
                background-size: contain;
            }
        <?php endif; ?>
    <?php
        $override_css = ob_get_clean();
        wp_register_style( 'kovatz-override-css', false,'',1 );
        wp_enqueue_style( 'kovatz-override-css' );
        wp_add_inline_style( 'kovatz-override-css', $override_css);
    ?>

<?php endif; ?>
