<?php
/* * Theme Name : Quality
 * Theme Core Functions and Codes
 */
/* * Includes reqired resources here* */
define('QUALITY_TEMPLATE_DIR_URI', get_template_directory_uri());
define('QUALITY_TEMPLATE_DIR', get_template_directory());
define('QUALITY_THEME_FUNCTIONS_PATH', QUALITY_TEMPLATE_DIR . '/functions');
define('QUALITY_THEME_OPTIONS_PATH', QUALITY_TEMPLATE_DIR_URI . '/functions/theme_options');

require( QUALITY_THEME_FUNCTIONS_PATH . '/menu/new_Walker.php'); //NEW Walker Class Added.  
require( QUALITY_THEME_FUNCTIONS_PATH . '/menu/default_menu_walker.php');

require_once( QUALITY_THEME_FUNCTIONS_PATH . '/scripts/scripts.php');     //Theme Scripts And Styles    

require( QUALITY_THEME_FUNCTIONS_PATH . '/commentbox/comment-function.php'); //Comment Handling
require( QUALITY_THEME_FUNCTIONS_PATH . '/widget/custom-sidebar.php'); //Sidebar Registration
//Customizer
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-pro-feature.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-general.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-slider.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-copyright.php');

require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-blog.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer-archive.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer_recommended_plugin.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/customizer/customizer_import_data.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/font/font.php');
require( QUALITY_THEME_FUNCTIONS_PATH . '/breadcrumbs/breadcrumbs.php');
require_once('theme_setup_data.php');
require( QUALITY_TEMPLATE_DIR . '/class-tgm-plugin-activation.php');

require( QUALITY_THEME_FUNCTIONS_PATH . '/template-tags.php');

function quality_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'required' => false,
        ),
        array(
            'name' => 'Webriti Companion',
            'slug' => 'webriti-companion',
            'required' => false,
        ),
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'has_notices' => true, // Show admin notices or not.
        'dismissable' => true, // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false, // Automatically activate plugins after installation or not.
        'message' => '', // Message to output right before the plugins table.
    );

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'quality_register_required_plugins');

//$repeater_path = trailingslashit(get_template_directory()) . '/functions/customizer-repeater/functions.php';
//if (file_exists($repeater_path)) {
//    require_once( $repeater_path );
//}

//wp title tag starts here
function quality_head($title, $sep) {
    global $paged, $page;
    if (is_feed())
        return $title;
    // Add the site name.
    $title .= get_bloginfo('name');
    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description');
    if ($site_description && ( is_home() || is_front_page() ))
        $title = "$title $sep $site_description";
    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2)
        $title = "$title $sep " . sprintf(esc_html_e('Page', 'quality'), max($paged, $page));
    return $title;
}

add_filter('wp_title', 'quality_head', 10, 2);

add_action('after_setup_theme', 'quality_setup');

function quality_setup() {
    require_once('child_theme_compatible.php');  
    //content width
    if (!isset($content_width))
        $content_width = 700; //In PX

        
// Load text domain for translation-ready
    load_theme_textdomain('quality', QUALITY_TEMPLATE_DIR . '/languages');
    add_theme_support('post-thumbnails'); //supports featured image
    // This theme uses wp_nav_menu() in one location.
    register_nav_menu('primary', __('Primary Menu', 'quality')); //Navigation
    // theme support    
    add_theme_support('automatic-feed-links');

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    //Title tag
    add_theme_support("title-tag");

    // woocommerce support
    add_theme_support('woocommerce');

    // Woocommerce Gallery Support
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    //Custom logo

    add_theme_support('custom-logo', array(
        'height' => 49,
        'width' => 153,
        'flex-height' => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    require_once('theme_setup_data.php');
    // setup admin pannel defual data for index page        
    $quality_pro_options = quality_theme_data_setup();

    //About Theme
    $theme = wp_get_theme(); // gets the current theme
    if ('Quality' == $theme->name || 'Quality blue' == $theme->name || 'Quality green' == $theme->name || 'Quality orange' == $theme->name) {
        if (is_admin()) {
            require get_template_directory() . '/admin/admin-init.php';
        }
    }
}

// Read more tag to formatting in blog page 
function quality_new_content_more($more) {
    global $post;
    return '<p><a href="' . esc_url(get_permalink()) . "#more-{$post->ID}\" class=\"more-link\">" . esc_html__('Read More', 'quality') . "</a></p>";
}

add_filter('the_content_more_link', 'quality_new_content_more');

function quality_customizer_css() {
    wp_enqueue_style('quality-customizer-info', QUALITY_TEMPLATE_DIR_URI . '/css/pro-feature.css');
}

add_action('admin_init', 'quality_customizer_css');

add_filter("the_excerpt", "quality_add_class_to_excerpt");

function quality_add_class_to_excerpt($excerpt) {
    return str_replace('<p', '<p class="qua-blog-post-description"', $excerpt);
}

if (!function_exists('wp_body_open')) {

    function wp_body_open() {
        do_action('wp_body_open');
    }

}
the_tags();
//customizer sanitize_callback checkbox box function
function quality_sanitize_checkbox($checked) {
    // Boolean check.
    return ( ( isset($checked) && true == $checked ) ? 1 : 0 );
}

    //radio box sanitization function
    function quality_sanitize_radio($input, $setting) {

        $input = sanitize_key($input);

        $choices = $setting->manager->get_control($setting->id)->choices;

        //return if valid 
        return ( array_key_exists($input, $choices) ? $input : $setting->default );
    }
    
    
    add_filter('wp_get_attachment_image_attributes', function($attr) {
    if (isset($attr['class']) && 'custom-logo' === $attr['class'])
        $attr['class'] = 'custom-logo';
    return $attr;
});

add_filter('get_custom_logo', 'quality_change_logo_class');

function quality_change_logo_class($html) {
    $html = str_replace('custom-logo-link', 'navbar-brand', $html);
    return $html;
}

//Custom CSS compatibility
$quality_pro_options = quality_theme_data_setup();
$current_options = wp_parse_args(get_option('quality_pro_options', array()), $quality_pro_options);
if ($current_options['webrit_custom_css'] != '' && $current_options['webrit_custom_css'] != 'nomorenow') {
    $css = '';
    $css .= $current_options['webrit_custom_css'];
    $css .= (string) wp_get_custom_css(get_stylesheet());
    $current_options['webrit_custom_css'] = 'nomorenow';
    update_option('quality_pro_options', $current_options);
    wp_update_custom_css_post($css, array());
}