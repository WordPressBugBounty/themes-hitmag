<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package HitMag
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function hitmag_body_classes( $classes ) {
	global $post;

	if ( false == get_theme_mod( 'hitmag_boxed_layout', true ) ) {
		$classes[] = 'hitmag-full-width';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_home() || is_archive() || is_search() ) {
		$archive_sidebar_align = get_option( 'archive_sidebar_align', 'th-right-sidebar' );
		$classes[] = esc_attr( $archive_sidebar_align );
	}

	if ( is_single() ) {
		$post_specific_layout = get_post_meta( $post->ID, '_hitmag_layout_meta', true );
		if ( empty( $post_specific_layout ) || $post_specific_layout == 'th-default-layout' ) {
			$classes[] = esc_attr( get_option( 'post_sidebar_align', 'th-right-sidebar' ) );
		} else {
			$classes[] = esc_attr( $post_specific_layout );
		}
	}

	if( is_page_template( 'template-magazine.php' ) ) {
		$classes[] = 'th-right-sidebar';
	} elseif ( is_page() ) {
		$page_specific_layout = get_post_meta( $post->ID, '_hitmag_layout_meta', true );
		if ( empty( $page_specific_layout ) || $page_specific_layout == 'th-default-layout' ) {
			$classes[] = esc_attr( get_option( 'page_sidebar_align', 'th-right-sidebar' ) );
		} else {
			$classes[] = esc_attr( $page_specific_layout );
		}		
	}

	return $classes;
}
add_filter( 'body_class', 'hitmag_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function hitmag_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'hitmag_pingback_header' );

/**
 * Add a custom excerpt length.
 */
function hitmag_excerpt_length( $length ) {
	if( is_admin() ) {
		return $length;
	}
	$custom_length = get_theme_mod( 'excerpt_length', 30 );
	return absint( $custom_length );
}
add_filter( 'excerpt_length', 'hitmag_excerpt_length', 999 );

/**
 * Changes the excerpt more text.
 */
function hitmag_excerpt_more( $more ) {

	if ( is_admin() ) {
		return $more;
	}

	return ' &hellip; ';
}
add_filter( 'excerpt_more', 'hitmag_excerpt_more' );



if ( ! function_exists( 'hitmag_get_layout' ) ) :
/**
 * Returns the selected sidebar alignment for the page.
 *
 * @return string
 */
function hitmag_get_layout() {

	global $post;

	$layout = 'th-right-sidebar';

	if ( is_home() || is_archive() || is_search() ) {
		$archive_sidebar_align = get_option( 'archive_sidebar_align', 'th-right-sidebar' );
		$layout = $archive_sidebar_align;
	}

	if ( is_single() ) {
		$post_specific_layout = get_post_meta( $post->ID, '_hitmag_layout_meta', true );
		if ( empty( $post_specific_layout ) || $post_specific_layout == 'th-default-layout' ) {
			$layout = get_option( 'post_sidebar_align', 'th-right-sidebar' );
		} else {
			$layout = $post_specific_layout;
		}
	}
	if( is_page_template( 'template-magazine.php' ) ) {
		$layout = 'th-right-sidebar';
	} elseif ( is_page() ) {
		$page_specific_layout = get_post_meta( $post->ID, '_hitmag_layout_meta', true );
		if ( empty( $page_specific_layout ) || $page_specific_layout == 'th-default-layout' ) {
			$layout = get_option( 'page_sidebar_align', 'th-right-sidebar' );
		} else {
			$layout = $page_specific_layout;
		}	
	}

	return $layout;

}

endif;


/**
 * Changes tag font size.
 */
function hitmag_tag_cloud_sizes($args) {
	$args['smallest']	= 10;
	$args['largest'] 	= 10;
	return $args; 
}
add_filter('widget_tag_cloud_args','hitmag_tag_cloud_sizes');


/**
 * View all link for posts widgets 
 */
function hitmag_viewall_link( $category_id, $viewall_text ) {

	if ( ! empty( $viewall_text ) ) :

		if ( ! empty( $category_id ) ) {
			$viewall_link = get_category_link( $category_id );
		} else {
			$posts_page_id = get_option( 'page_for_posts' );

			if ( $posts_page_id ) {
				$viewall_link = get_page_link( $posts_page_id );
			} else {
				$viewall_link = "";
			}
		}

		if ( $viewall_link ) { ?>
			<a class="hm-viewall" href="<?php echo esc_url( $viewall_link ); ?>"><span><?php echo esc_html( $viewall_text ); ?></span></a>
		<?php }

	endif;  

}

/**
 * Get the color using a give icon name.
 */
function hitmag_get_social_icon_color( $icon ) {
	$social_colors = array(
		'facebook'  => '#1877F2',
		'youtube'   => '#FF0000',
		'twitter'   => '#000000',
		'x'   		=> '#000000',
		'pinterest' => '#BD081C',
		'instagram' => '#E4405F',
		'linkedin'  => '#0A66C2',
		'bluesky'   => '#1185FE',
		'skype'     => '#00AFF0',
		'dribbble'  => '#EA4C89',
		'vk'        => '#0077FF',
		'tumblr'    => '#36465D',
		'github'    => '#181717',
		'flickr'    => '#FF0084',
		'vimeo'     => '#1AB7EA',
		'vine'      => '#00B488',
		'yelp'      => '#D32323',
		'tripadvisor'=> '#34E0A1',
		'telegram'  => '#26A5E4',
		'tiktok'    => '#000000',
		'twitch'    => '#9146FF',
		'mastodon'  => '#6364FF',
		'discord'   => '#5865F2',
		'diaspora'  => '#4A4A4A',
		'whatsapp'  => '#25D366',
		'reddit'    => '#FF4500',
		'snapchat'  => '#FFFC00',
		'threads'   => '#000000',
		'quora'     => '#B92B27',
		'patreon'   => '#FF424D',
		'wechat'    => '#07C160',
		'line'      => '#06C755',
	);

	return isset( $social_colors[ $icon ] ) ? $social_colors[ $icon ] : '';
}


if ( ! function_exists( 'hitmag_get_icon_svg' ) ) :
	/**
	 * Get SVG Icons.
	 * 
	 * @since HitMag 1.4.5
	 * 
	 * @param string $icon_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 */
	function hitmag_get_icon_svg( $icon_name, $group = 'ui' ) {

		// Make sure that only our allowed tags and attributes are included.
		$svg = wp_kses( HitMag_SVG_Icons::get_svg( $icon_name, $group ), array(
			'svg'     => array(
				'class'       => true,
				'xmlns'       => true,
				'width'       => true,
				'height'      => true,
				'viewbox'     => true,
				'aria-hidden' => true,
				'role'        => true,
				'focusable'   => true,
			),
			'path'    => array(
				'fill'      => true,
				'fill-rule' => true,
				'd'         => true,
				'transform' => true,
			),
			'polygon' => array(
				'fill'      => true,
				'fill-rule' => true,
				'points'    => true,
				'transform' => true,
				'focusable' => true,
			),
		) );

		if ( ! $svg ) {
			return false;
		}

		return $svg;

	}

endif;


if ( ! function_exists( 'hitmag_the_icon_svg' ) ) {
	/**
	 * Echo svg icon.
	 * 
	 * @since HitMag 1.4.5
	 * 
	 * @param string $icon_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 */
	function hitmag_the_icon_svg( $icon_name, $group = 'ui' ) {
		echo hitmag_get_icon_svg( $icon_name, $group ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in hitmag_get_icon_svg().
	}
}

/**
 * Adds social icon field to social menu items.
 *
 * @since HitMag 1.4.5
 *
 * @param int      $item_id           Menu item ID.
 * @param WP_Post  $menu_item        Menu item object.
 * @param int      $depth             Menu item depth.
 * @param stdClass $args              Menu arguments.
 * @param int      $current_object_id   Nav menu ID.
 */
function hitmag_social_icon_menu_item_field( $item_id, $menu_item, $depth, $args, $current_object_id ) {
	
	$current_menu_id = isset( $_GET['menu'] ) ? absint( $_GET['menu'] ) : 0;

	$locations = get_nav_menu_locations();

	$social_menu_id = isset( $locations['menu-social'] ) ? absint( $locations['menu-social'] ) : 0;

	if ( $current_menu_id !== $social_menu_id ) {
		return;
	}

	$selected_icon = get_post_meta(
		$item_id,
		'_hitmag_social_menu_icon',
		true
	);

	$social_icons = HitMag_SVG_Icons::$social_icons;
	?>

	<p class="field-hitmag-social-icon description description-wide">

		<label for="edit-hitmag-menu-item-social-icon-<?php echo esc_attr( $item_id ); ?>">

			<?php esc_html_e( 'Social Icon', 'hitmag' ); ?><br>

			<select
				id="edit-hitmag-menu-item-social-icon-<?php echo esc_attr( $item_id ); ?>"
				name="hitmag-menu-item-social-icon[<?php echo esc_attr( $item_id ); ?>]"
				class="widefat"
			>

				<option value="">
					<?php esc_html_e( 'Auto Detect', 'hitmag' ); ?>
				</option>

				<?php foreach ( $social_icons as $icon => $svg ) : ?>

					<option
						value="<?php echo esc_attr( $icon ); ?>"
						<?php selected( $selected_icon, $icon ); ?>
					>
						<?php echo esc_html( ucfirst( $icon ) ); ?>
					</option>

				<?php endforeach; ?>

			</select>

			<span class="description">
				<?php esc_html_e(
					'Select an icon or use automatic detection based on the URL.',
					'hitmag'
				); ?>
			</span>

		</label>

	</p>

	<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'hitmag_social_icon_menu_item_field', 10, 5 );

/**
 * Saves Social Icon menu item setting.
 *
 * @since HitMag 1.4.5
 * 
 * @param int   $menu_id         Menu ID.
 * @param int   $menu_item_db_id Menu item ID.
 * @param array $args            Menu item arguments.
 */
function hitmag_save_social_icon_menu_item( $menu_id, $menu_item_db_id, $args ) {

	if ( ! isset( $_POST['hitmag-menu-item-social-icon'][ $menu_item_db_id ] ) ) {
		return;
	}

	$icon = sanitize_key(
		wp_unslash(
			$_POST['hitmag-menu-item-social-icon'][ $menu_item_db_id ]
		)
	);

	$icons = HitMag_SVG_Icons::$social_icons;

	if ( $icon && isset( $icons[ $icon ] ) ) {

		update_post_meta(
			$menu_item_db_id,
			'_hitmag_social_menu_icon',
			$icon
		);

	} else {

		delete_post_meta(
			$menu_item_db_id,
			'_hitmag_social_menu_icon'
		);
	}
}
add_action( 'wp_update_nav_menu_item', 'hitmag_save_social_icon_menu_item', 10, 3 );

/**
 * Displays SVG icons in social links menu.
 * 
 * @since HitMag 1.4.5
 * 
 * @param string	$item_output 	The menu item's starting HTML output.
 * @param WP_Post 	$item 			Menu item data object.
 * @param int 		$depth 			Depth of the menu. Used for padding.
 * @param stdClass 	$args 			An object of wp_nav_menu() arguments.
 * @return string The menu item output with social icon.
 */
function hitmag_nav_menu_social_icons( $item_output, $item, $depth, $args ) {

	if ( 'menu-social' !== $args->theme_location ) {
		return $item_output;
	}

	$icon = '';
	$svg  = '';

	$selected_icon = get_post_meta(
		$item->ID,
		'_hitmag_social_menu_icon',
		true
	);

	// Use manually selected icon first.
	if ( $selected_icon ) {
		$icon = $selected_icon;
		$svg = HitMag_SVG_Icons::get_svg(
			$icon,
			'social'
		);		
	} else {
		// Fallback to URL detection.
		$svg_data = HitMag_SVG_Icons::get_social_link_svg( $item->url );

		if ( ! empty( $svg_data ) ) {
			$icon = $svg_data['icon'];
			$svg = $svg_data['svg'];
		}
	}

	if ( empty( $svg ) ) {
		$svg = hitmag_get_icon_svg( 'link' );
	}

	if ( ! empty( $icon ) ) {
		// Add social media brand color to the link.
		$color = hitmag_get_social_icon_color( $icon );

		if ( ! empty( $color ) ) {		
			$item_output = preg_replace(
				'/<a\b/',
				'<a style="color: ' . esc_attr( $color ) . ';"',
				$item_output,
				1
			);		
		}
	}

	$item_output = str_replace( $args->link_after, '</span>' . $svg, $item_output ); 

	return $item_output;

}
add_filter( 'walker_nav_menu_start_el', 'hitmag_nav_menu_social_icons', 10, 4 );