<?php
/**
 * HitMag functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package HitMag
 */

if ( ! function_exists( 'hitmag_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hitmag_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on HitMag, use a find and replace
	 * to change 'hitmag' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'hitmag', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'hitmag-landscape',	1120, 450, true );
	add_image_size( 'hitmag-featured', 735, 400, true );
	add_image_size( 'hitmag-grid', 348, 215, true );
	add_image_size( 'hitmag-list', 290, 220, true );
	add_image_size( 'hitmag-thumbnail', 135, 93, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' 		=> esc_html__( 'Main Menu', 'hitmag' ),
		'menu-2' 		=> esc_html__( 'Top Menu', 'hitmag' ),
		'menu-social'  	=> esc_html__( 'Social Media Menu', 'hitmag' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for custom logo upload.
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 380,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );	

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'hitmag_custom_background_args', array(
		'default-color' => 'dddddd',
		'default-image' => '',
	) ) );

	// Declare WooCommerce support.
	add_theme_support( 'woocommerce' );	
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add editor style.
	add_editor_style( array( 'css/editor-style.css', hitmag_fonts_url() ) );

	// Load regular editor styles into the new block-based editor.
	add_theme_support( 'editor-styles' );

 	// Load default block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			
			'sidebar-1' => array(
				'search',
				'text_about',
				'custom_popular_widget' => array( 'hitmag_tabbed_widget', array(
						'nop'	=> 5,
						'noc'	=> 5
					)	 
				),
				'recent-posts'
			),

			'magazine' => array(
				'magazine_posts_style_1' => array( 'hitmag_single_category_posts', array(
						'title' => 'Fashion'
					)
				),
				'magazine_posts_style_2' => array( 'hitmag_dual_category_posts', array(
						'title1' 		=> 'Lifestyle',
						'number_posts1' => 4,
						'title2' 		=> 'Technology',
						'number_posts2' => 4
					)
				),
				'magazine_posts_style_3' => array( 'hitmag_grid_category_posts', array(
						'title' 		=> 'Sports',
						'number_posts' => 6
					)
				)
			),

			'footer-left' => array(
				'text_business_info',
			),
			
			'footer-mid' => array(
				'text_about',
			),

			'footer-right' => array(
				'recent-posts',
				'search',
			),

		),

		'posts' => array(
			// Add pages.
			'home' => array(
				'template' => 'template-magazine.php'
			),
			'blog'		
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set up nav menus for each of the three areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "main menu" location.
			'menu-1' => array(
				'name' => esc_html__( 'Main Menu', 'hitmag' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_blog',
				),
			),

			// Assign a menu to the "top menu" location.
			'menu-2' => array(
				'name' => esc_html__( 'Top Menu', 'hitmag' ),
				'items' => array(
					'link_home',
					'page_blog',
				),
			),

			// Assign a menu to the "menu-social" location.
			'menu-social' => array(
				'name' => esc_html__( 'Social Links Menu', 'hitmag' ),
				'items' => array(
					'link_facebook',
					'link_twitter',
					'link_instagram',
				),
			),
		),

	);

	$starter_content = apply_filters( 'hitmag_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );	

}
endif;
add_action( 'after_setup_theme', 'hitmag_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hitmag_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hitmag_content_width', 735 );
}
add_action( 'after_setup_theme', 'hitmag_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hitmag_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'hitmag' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'hitmag' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Magazine Homepage', 'hitmag' ),
		'id'            => 'magazine',
		'description'   => esc_html__( 'Appearas on Magazine Homepage template only. Add magazine posts widgets to this widget area.', 'hitmag' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Header Advertisement Area', 'hitmag' ),
		'id'            => 'sidebar-header',
		'description'   => esc_html__( 'You can add advertisement widget to this widget area.', 'hitmag' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Left Sidebar', 'hitmag' ),
		'id'            => 'footer-left',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Mid Sidebar', 'hitmag' ),
		'id'            => 'footer-mid',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Right Sidebar', 'hitmag' ),
		'id'            => 'footer-right',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	) );	
}
add_action( 'widgets_init', 'hitmag_widgets_init' );

/**
 * Load Google Fonts
 */
function hitmag_fonts_url() {
    $fonts_url = get_theme_file_uri( '/css/fonts.css' );
    return $fonts_url;
}
/**
* Enqueue Google fonts.
*/
function hitmag_font_styles() {
    wp_enqueue_style( 'hitmag-fonts', hitmag_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'hitmag_font_styles' );

/**
 * Enqueue scripts and styles.
 */
function hitmag_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'hitmag-font-awesome', get_template_directory_uri() . '/css/all.min.css', array(), '6.5.1' );

	wp_enqueue_style( 'hitmag-style', get_stylesheet_uri(), array(), $theme_version );

	wp_enqueue_script( 'hitmag-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), $theme_version, true );

	wp_enqueue_script( 'hitmag-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), $theme_version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_page_template( 'template-magazine.php' ) && ( true == get_theme_mod( 'show_slider', true ) ) ) {
		wp_enqueue_style( 'hitmag-swiper', get_template_directory_uri() . '/css/swiper-bundle.min.css', '', '11.0.5', 'screen' );
		wp_enqueue_script( 'hitmag-swiper', get_template_directory_uri() . '/js/swiper-bundle.min.js', '', '11.0.5', true );
	}

	wp_enqueue_script( 'hitmag-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), $theme_version, true );	

	if ( ! is_front_page() && is_singular() && ( true == get_theme_mod( 'use_lightbox', true ) ) ) {
		wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '', true );
		wp_enqueue_style( 'jquery-magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '' );
	}

    wp_enqueue_script( 'html5shiv',get_template_directory_uri().'/js/html5shiv.min.js');
    wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );	

}
add_action( 'wp_enqueue_scripts', 'hitmag_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 *
 * @since HitMag 1.3.1
 */
function hitmag_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'hitmag-block-editor-style', get_template_directory_uri() . '/css/editor-blocks.css' );
	// Add custom fonts.
	wp_enqueue_style( 'hitmag-fonts', hitmag_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'hitmag_block_editor_styles' );

/**
 * custom logo.
 */
function hitmag_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

/**
 * Embed kirki plugin.
 */
if ( ! class_exists( 'Kirki' ) ) {
	include_once( get_template_directory() . '/inc/kirki/kirki.php' );
}
require get_template_directory() . '/inc/customizer/kirki-config.php';
require get_template_directory() . '/inc/customizer/styles.php';

require_once( trailingslashit( get_template_directory() ) . '/inc/customizer/custom-controls/class-upsell-customize.php' );

/**
 * Custom block styles.
 */
require get_template_directory() . '/inc/block-styles.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Custom meta boxes.
 */
require get_template_directory() . '/inc/class-meta-boxes.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load all widgets.
 */
require get_template_directory() . '/inc/widgets/block-posts-single.php';
require get_template_directory() . '/inc/widgets/block-posts-dual.php';
require get_template_directory() . '/inc/widgets/block-posts-grid.php';
require get_template_directory() . '/inc/widgets/sidebar-posts.php';
require get_template_directory() . '/inc/widgets/popular-tags-comments.php';
require get_template_directory() . '/inc/widgets/popular-posts.php';


/**
 * Theme Info Page.
 */
require get_template_directory() . '/inc/dashboard/theme-info.php';