<?php
/**
 * Prespa LMS functions and definitions
 *
 * @since 1.0.0
 */

define( 'PRESPA_THEME_VIDEO_GUIDE', 'https://www.youtube.com/watch?v=6C5SgEG1vak' );
define( 'PRESPA_THEME_LOGO_URL', get_stylesheet_directory_uri() . '/admin/img/theme-logo.jpg' );

/**
 * Register child theme's styles
 */
function prespa_lms_enqueue_theme_styles() {
	wp_enqueue_style( 'prespa-lms-styles', get_stylesheet_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
}

add_action( 'wp_enqueue_scripts', 'prespa_lms_enqueue_theme_styles' );

/**
 * Registers block patterns categories, and type.
 */
function prespa_lms_register_block_patterns() {
	$block_pattern_categories = array(
		'prespa-lms' => array( 'label' => esc_html__( 'Prespa LMS', 'prespa-lms' ) ),
	);

	$block_pattern_categories = apply_filters( 'prespa_lms_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}
}

add_action( 'init', 'prespa_lms_register_block_patterns', 9 );

// Change theme defaults in the customizer preview
function prespa_lms_customize_register( $wp_customize ) {
	$primary_accent_color_setting   = $wp_customize->get_setting( 'primary_accent_color' );
	$secondary_accent_color_setting = $wp_customize->get_setting( 'secondary_accent_color' );
	$body_bgr_color_setting         = $wp_customize->get_setting( 'body_bgr_color' );
	$content_layout_setting         = $wp_customize->get_setting( 'content_layout' );
	$header_button_text             = $wp_customize->get_setting( 'header_button_text' );

	if ( $primary_accent_color_setting ) {
		$primary_accent_color_setting->default = '#356df1';
	}

	if ( $body_bgr_color_setting ) {
		$body_bgr_color_setting->default = '#f8f8f8';
	}

	if ( $secondary_accent_color_setting ) {
		$secondary_accent_color_setting->default = '#f5f5f5';
	}

	if ( $header_button_text ) {
		$header_button_text->default = '';
	}
}

add_action( 'customize_register', 'prespa_lms_customize_register', 999, 1 );

// Overwrite parent theme customizer defaults
function prespa_customizer_values( $value ) {
	$defaults = array(
		'primary_accent_color'   => '#356df1',
		'secondary_accent_color' => '#f5f5f5',
		'body_bgr_color'         => '#f8f8f8',
		'headings_text_color'      => '#404040',
		'link_headings_text_color' => '#404040',
		'content_layout'         => 'seperate_containers',
		'header_button_text'     => '',
		'has_secondary_menu'     => true,
		'header-menu-position'   => 'static',
		'woo_btn_bgr_color'      => '',
		'woo_btn_text_color'     => '',
	);
	// Return the value from the theme mod, or fallback to the default
	return get_theme_mod( $value, $defaults[ $value ] );
}

// Disable dark mode option from parent theme
function prespa_lms_remove_dark_mode_setting( $wp_customize ) {
	$wp_customize->remove_section( 'night_mode' );
}

add_action( 'customize_register', 'prespa_lms_remove_dark_mode_setting', 20 );

function prespa_primary_menu_dark_mode_markup() {
	return null;
}

function prespa_starter_content_setup() {
	$default_page_content = '
	<!-- wp:pattern {"slug":"prespa-lms/header"} /-->
	<!-- wp:pattern {"slug":"prespa-lms/cards"} /-->
	<!-- wp:pattern {"slug":"prespa-lms/features"} /-->
	<!-- wp:pattern {"slug":"prespa-lms/courses"} /-->
	<!-- wp:pattern {"slug":"prespa-lms/categories"} /-->
	<!-- wp:pattern {"slug":"prespa-lms/lessons"} /-->
	<!-- wp:pattern {"slug":"prespa-lms/faq"} /-->
	<!-- wp:pattern {"slug":"prespa-lms/banner"} /-->
	';

	add_theme_support(
		'starter-content',
		array(
			'posts'     => array(
				'home'  => array(
					'post_type'    => 'page',
					'post_title'   => _x( 'Home', 'Theme starter content', 'prespa-travel' ),
					'post_content' => $default_page_content,
				),
				'blog'
			),
			'options'   => array(
                'show_on_front'  => 'page',
                'page_on_front'  => '{{home}}',
                'page_for_posts' => '{{blog}}'
            ),
			'nav_menus' => array(
                'menu-1' => array(
                    'name'  => __( 'Primary', 'prespa-travel' ),
                    'items' => array(
                        'page_home',
                        'page_blog',
                    ),
                ),
            )
		)
	);
}

require get_stylesheet_directory() . '/tgm/plugin-activation.php';
require get_stylesheet_directory() . '/tgm/recommended-plugins.php';