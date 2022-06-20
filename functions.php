<?php
/**
 * likhun functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package likhun
 */

if ( ! defined( 'LIKHUN_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'LIKHUN_VERSION', '1.0' );
}

if ( ! function_exists( 'likhun_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function likhun_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on likhun, use a find and replace
		 * to change 'likhun' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'likhun', get_template_directory() . '/languages' );

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
		add_image_size( 'likhun-slide-image', 1024, 600, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'likhun' ),
		) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'footer_menu' => esc_html__( 'Footer Menu', 'likhun' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'likhun_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		
	}
endif;
add_action( 'after_setup_theme', 'likhun_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function likhun_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'likhun_content_width', 640 );
}
add_action( 'after_setup_theme', 'likhun_content_width', 0 );

if ( ! function_exists( 'likhun_fonts_url' ) ) :
	/**
	 * Register Google fonts.
	 *
	 * @return string Google fonts URL for the theme.
	 */
	
	function likhun_fonts_url() {
		$font_url = '';
		/*
		 * Translators: If there are characters in your language that are not supported
		 * by Open Sans, translate this to 'off'. Do not translate into your own language.
		 */

		// Collect data from customizer options
		$google_font = get_theme_mod( 'google_font' );

		$primary_font = get_theme_mod( 'primary_font' ) ? get_theme_mod( 'primary_font' ) : $google_font;
	
		if ( 'off' !== _x( 'on', 'Fonts: on or off', 'likhun' ) ) {
			$query_args = array(
				'family' => $primary_font
			);
			$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );
		}
		if(  2 == get_theme_mod( 'display_font' ) ):
			return $font_url;
		else:
			return 0;
		endif;		
	}
endif;
	
// Menu fallback
function likhun_primary_menu_fallback(){
	echo '<ul class="navbar-nav ml-auto main-menu-nav"><li><a href="'.esc_url( admin_url( 'nav-menus.php' ) ).'"></a></li></ul>';
}

/**
 * Enqueue scripts and styles.
 */
function likhun_scripts() {

	/**
	 * Load all CSS files
	 */

	// Bootstrap 
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/lib/bootstrap/css/bootstrap.min.css' );

	// Bootstrap Icon Fonts
	wp_enqueue_style( 'bootstrap-icons', get_template_directory_uri() . '/lib/bootstrap/icons/bootstrap-icons.css' );

	// Theme Google fonts
	if( get_theme_mod( 'display_font' ) == 2 ):
		wp_enqueue_style( 'likhun-fonts', likhun_fonts_url(), array(), null );
	endif;
	
	// Main & RTL Stylesheet
	wp_enqueue_style( 'likhun-style', get_stylesheet_uri(), array(), LIKHUN_VERSION );

	// Responsive file
	wp_enqueue_style( 'likhun-responsive', get_template_directory_uri() . '/css/responsive.css' );

	/**
	 * Load all js files
	 */

	// Bootstrap Script
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/lib/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ), LIKHUN_VERSION, true );
	
	// Masonry Script
	wp_enqueue_script( 'masonry', get_template_directory_uri() . 'masonry.pkgd.min.js', array( 'jquery' ), LIKHUN_VERSION, true );

	// Smooth Scrool Script
	wp_enqueue_script( 'smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array( 'jquery' ), LIKHUN_VERSION, true );

	// Likhun custom js
	wp_enqueue_script( 'likhun-script', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), LIKHUN_VERSION, true );

	// Ajax load post by category
	wp_enqueue_script('likhun-filter', get_template_directory_uri() . '/js/sieve.js', ['jquery'], null, true);
    wp_localize_script( 'likhun-filter', 'filterObj', array(
        'nonce'    => wp_create_nonce( 'filterObj' ),
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Adding Dashicons in WordPress Front-end
	wp_enqueue_style( 'dashicons' );

	/**
	* Customizer inline style
	*/
	$custom_css = '';

	// Collect data from customizer options
	$google_font_family = get_theme_mod( 'google_font_family' );
	$line_height = get_theme_mod( 'line_height' );

	if ( ! empty( $google_font_family ) && ! empty( $line_height ) &&  2 == get_theme_mod( 'display_font' ) ) {
		$custom_css .= '
			body { 
				font-family: ' . esc_attr( $google_font_family ).'
				line-height: ' . esc_attr( $line_height ).'px
			}
		';
	}

	if ( ! empty( $custom_css ) ) {
		wp_add_inline_style( 'likhun-responsive', $custom_css );
	}

}
add_action( 'wp_enqueue_scripts', 'likhun_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Widget additions.
 */
require get_template_directory() . '/inc/widget.php';

/**
 * Botstrap nav additions.
 */
require get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
