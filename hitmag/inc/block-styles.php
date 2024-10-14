<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @package WordPress
 * @subpackage HitMag
 * @since HitMag 1.3.0
 */

if ( function_exists( 'register_block_style' ) ) {

	/**
	 * Register block styles.
	 *
	 * @since HitMag 1.3.0
	 *
	 * @return void
	 */
    function hitmag_register_block_styles() {
        register_block_style(
			'core/heading',
			array(
				'name'  => 'hitmag-widget-title',
				'label' => esc_html__( 'Widget title style', 'hitmag' ),
			)
		);
    }
    add_action( 'init', 'hitmag_register_block_styles' );

}

