<?php
/**
 * Eduhap functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Eduhap
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eduhap_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Eduhap, use a find and replace
		* to change 'eduhap' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'eduhap', get_template_directory() . '/languages' );

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
		 * Set woocommerce support  
		 * 
		 */
		add_theme_support( 'woocommerce' );		
		
	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'eduhap_testi', 300,300, true );
	add_image_size( 'eduhap_team', 350,350, true );
	add_image_size( 'eduhap_blog', 800,550, true );
	add_image_size( 'eduhap_course', 416,257, true );
	add_image_size( 'eduhap_course_two', 170,170, true );
	add_image_size( 'eduhap_shop', 700,700, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'eduhap' ),
			'menu-2' => esc_html__( 'Top', 'eduhap' ),
			'menu-3' => esc_html__( 'Footer', 'eduhap' ),
		)
	);

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
			'eduhap_custom_background_args',
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
add_action( 'after_setup_theme', 'eduhap_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eduhap_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eduhap_content_width', 640 );
}
add_action( 'after_setup_theme', 'eduhap_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eduhap_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'eduhap' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'eduhap' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);	
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer One Left', 'eduhap' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'eduhap' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h4 class="widget-title text-gray">',
			'after_title'   => '</h4>',
		)
	);	
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Two Left', 'eduhap' ),
			'id'            => 'sidebar-3',
			'description'   => esc_html__( 'Add widgets here.', 'eduhap' ),
			'before_widget' => ' ',
			'after_widget'  => ' ',
			'before_title'  => '<h4 class="widget-title text-gray">',
			'after_title'   => '</h4>',
		)
	);	
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Right', 'eduhap' ),
			'id'            => 'sidebar-4',
			'description'   => esc_html__( 'Add widgets here.', 'eduhap' ),
			'before_widget' => '<div id="%1$s" class="col-lg-4 col-xl-4 col-sm-4 col-md-4 "><div class="footer-widget footer_menu_area mb-5 mb-lg-0">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'eduhap_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function eduhap_scripts() {
	
	// Add CSS Files	
	wp_enqueue_style('google-font-kumbh-Sans' , '//fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;500;600;700;800;900&display=swap');
	wp_enqueue_style('google-font-Questrial' , '//fonts.googleapis.com/css2?family=Questrial:wght@400;500;600;700;800;900&display=swap');
	wp_enqueue_style('bootstrap' , get_template_directory_uri(). '/assets/vendors/bootstrap/bootstrap.css');
	wp_enqueue_style('mobile-menu' , get_template_directory_uri(). '/assets/css/mobile-menu.css');
	wp_enqueue_style('YouTubePopUp' , get_template_directory_uri(). '/assets/css/YouTubePopUp.css');
	wp_enqueue_style('fontawesome' , get_template_directory_uri(). '/assets/vendors/fontawesome/css/all.css');
	wp_enqueue_style('flaticon' , get_template_directory_uri(). '/assets/vendors/flaticon/flaticon.css');
	wp_enqueue_style('animate' , get_template_directory_uri(). '/assets/vendors/animate-css/animate.css');
	wp_enqueue_style('owl-carousel' , get_template_directory_uri(). '/assets/vendors/owl/assets/owl.carousel.min.css');
	wp_enqueue_style('owl-theme' , get_template_directory_uri(). '/assets/vendors/owl/assets/owl.theme.default.min.css');
	wp_enqueue_style('eduhap-main-style' , get_template_directory_uri(). '/assets/css/style.css');
	wp_enqueue_style('eduhap-responsive' , get_template_directory_uri(). '/assets/css/responsive.css');		
	wp_enqueue_style( 'eduhap-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'eduhap-style', 'rtl', 'replace' );

	// Load JS Files
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap.js', array('jquery'), '6987', true );
	wp_enqueue_script( 'waypoint', get_template_directory_uri() . '/assets/vendors/counterup/waypoint.js', array('jquery'), '6987', true );
	wp_enqueue_script( 'mobile-menu', get_template_directory_uri() . '/assets/js/mobile-menu.js', array('jquery'), '6987', true );
	wp_enqueue_script( 'YouTubePopUp', get_template_directory_uri() . '/assets/js/YouTubePopUp.jquery.js', array('jquery'), '6987', true );
	wp_enqueue_script( 'counterup', get_template_directory_uri() . '/assets/vendors/counterup/jquery.counterup.min.js', array('jquery'), '6987', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/vendors/jquery.isotope.js', array('jquery'), '6987', true );
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/assets/vendors/imagesloaded.js', array('jquery'), '6987', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/vendors/owl/owl.carousel.min.js', array('jquery'), '6987', true );
	wp_enqueue_script( 'eduhap-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '6987', true );

	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eduhap_scripts' );


function eduhap_default_menu(){ ?>
	<ul class="navbar-nav mx-auto">                  
		<li><a href="<?php echo admin_url('nav-menus.php'); ?>"><?php esc_html_e( 'Set Your Menu', 'eduhap' ); ?></a></li>
	</ul>
<?php	
}

// Main_menu
function eduhap_main_menu() {
		wp_nav_menu( array(
		'theme_location'    => 'menu-1',
		'depth'             => 5,
		'container'         => false,
		'menu_class'        => 'navbar-nav mx-auto',
		'fallback_cb'       => 'eduhap_default_menu',
		
		)
	); 	
}

// top_menu
function eduhap_top_menu() {
		wp_nav_menu( array(
		'theme_location'    => 'menu-2',
		'depth'             => 5,
		'container'         => false,
		'menu_class'        => '',
		'fallback_cb'       => 'eduhap_navwalker::fallback',
		
		)
	); 	
}


// Footer_menu
function eduhap_footer_menu() {
		wp_nav_menu( array(
		'theme_location'    => 'menu-3',
		'depth'             => 5,
		'container'         => false,
		'menu_class'        => 'list-inline footer-contact text-lg-end text-center mt-4 mt-lg-0',
		'fallback_cb'       => 'eduhap_navwalker::fallback',
		
		)
	); 	
}

// wp kses
function eduhap_wp_kses($val){
	return wp_kses($val, array(
	
	'p' => array(),
	'span' => array('class' => array(),'id' => array()),
	'div' => array(),
	'strong' => array(),
	'em' => array(),
	'b' => array(),
	'br' => array(),
	'h1' => array(),
	'h2' => array(),
	'h3' => array(),
	'h4' => array(),
	'h5' => array(),
	'h6' => array(),
	'i'=> array('class' => array(),'id' => array()),
	'div'=> array('class' => array(),'id' => array()),
	'ul'=> array('class' => array(),'id' => array()),
	'li'=> array('class' => array(),'id' => array()),
	'a'=> array('href' => array(),'target' => array()),
	'iframe'=> array('src' => array(),'height' => array(),'width' => array()),
	
	), '');
}

// modify search widget
function eduhap_my_search_form( $form ) {
	$form = '
		
			
		<form method="get" id="searchform" class="search-form" action="' . esc_url(home_url( '/' )) . '" >
			<input type="text" value="' . esc_attr(get_search_query()) . '" name="s" id="s" class="form-control search_field" placeholder="' . esc_attr__('Enter Keyword ...' , 'eduhap') .'">
			<button class="search-submit" type="submit"><i class="fa fa-search"></i></button>
		</form>
			
		
        ';
	return $form;
}
add_filter( 'get_search_form', 'eduhap_my_search_form' );

// Header search widget
function eduhap_header_search_form() {
?>
		
		<form action="<?php echo esc_url(home_url( '/' )); ?>" class="header-form ms-3">
			<input type="text" class="form-control" name="s" id="s" placeholder="<?php echo esc_attr__('search' , 'eduhap'); ?>">
			<i class="fa fa-search"></i>
		</form>	
<?php
}


// comment list modify

function eduhap_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

	<div class="media">

		<?php echo get_avatar( $comment, 95 ); ?>

		<div class="media-body">
			<h5 class="mt-0"><?php comment_author_link() ?> <span><?php echo esc_html(get_comment_date('F j, Y')); ?></span>  <div class="reply-link"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?></div></h5>
			<?php if ($comment->comment_approved == '0') : ?>
			<p><em><?php esc_html_e('Your comment is awaiting moderation.','eduhap'); ?></em></p>
			<?php endif; ?>
			<?php comment_text(); ?>	
		</div>
	</div>
									
</li>


<?php } 

// comment box title change
add_filter( 'comment_form_defaults', 'eduhap_remove_comment_form_allowed_tags' );
function eduhap_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	$defaults['comment_notes_before'] = '';
	return $defaults;

}

function eduhap_comment_reform ($arg) {

$arg['title_reply'] = esc_html__('Write your comment Here','eduhap');
$arg['comment_field'] = '<div class="row"><div class="form-group col-md-12"><textarea id="comment" class="comment_field form-control" name="comment" cols="77" rows="3" placeholder="'. esc_attr__("Write your Comment", "eduhap").'" aria-required="true"></textarea></div></div>';


return $arg;

}
add_filter('comment_form_defaults','eduhap_comment_reform');

// comment form modify

function eduhap_modify_comment_form_fields($fields){
	$commenter = wp_get_current_commenter();
	$req	   = get_option( 'require_name_email' );

	$fields['author'] = '<div class="row"><div class="form-group col-md-4"><input type="text" name="author" id="author" value="'. esc_attr( $commenter['comment_author'] ) .'" placeholder="'. esc_attr__("Your Name *", "eduhap").'" size="22" tabindex="1"'. ( $req ? 'aria-required="true"' : '' ).' class="input-name form-control" /></div>';

	$fields['email'] = '<div class="form-group col-md-4"><input type="text" name="email" id="email" value="'. esc_attr( $commenter['comment_author_email'] ) .'" placeholder="'.esc_attr__("Your Email *", "eduhap").'" size="22" tabindex="2"'. ( $req ? 'aria-required="true"' : '' ).' class="input-email form-control"  /></div>';
	
	$fields['url'] = '<div class="form-group col-md-4"><input type="text" name="url" id="url" value="'. esc_attr( $commenter['comment_author_url'] ) .'" placeholder="'. esc_attr__("Website", "eduhap").'" size="22" tabindex="2"'. ( $req ? 'aria-required="false"' : '' ).' class="input-url form-control"  /></div></div>';

	return $fields;
}
add_filter('comment_form_default_fields','eduhap_modify_comment_form_fields');

function eduhap_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'eduhap_move_comment_field_to_bottom' );

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
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Navwalker
 */
require get_template_directory() . '/inc/navwalker.php';

/**
 * eduhap-functions
 */
require get_template_directory() . '/inc/eduhap-functions.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
* class-tgm-plugin-activation
*/
 
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
 
/**
* required-plugin
*/
 
require get_template_directory() . '/inc/required-plugin.php';
  
/**
* demo_install
*/
 
require get_template_directory() . '/inc/demo_install.php';
 
 
/**
* eduhap_user_profile_fields
*/
 
 
function eduhap_user_profile_fields( $methods ) {
    $methods['designation'] = 'Designation';
    $methods['facebook_link'] = 'Facebook Link';
    $methods['twitter_link'] = 'Twitter Link';
    $methods['linkedin_link'] = 'Linkedin Link';
    $methods['youtube_link'] = 'Youtube Link';
    return $methods;
}
add_action( 'user_contactmethods', 'eduhap_user_profile_fields' );


/*
 * Set post views count using post meta
 */
function eduhap_setPostViews($postID) {
    $countKey = 'post_views_count';
    $count = get_post_meta($postID, $countKey, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $countKey);
        add_post_meta($postID, $countKey, '0');
    }else{
        $count++;
        update_post_meta($postID, $countKey, $count);
    }
}