<?php

load_theme_textdomain('jadotheme', get_template_directory() . '/languages');


/** Theme Functions page */
require_once('lib/theme-settings.php');


/** Activate custom post type Example  */
//require_once('lib/custom-post-types.php'); // enable to get Custom Post Type "products"


function jado_head_cleanup()
{
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
}


function jado_theme_support()
{
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menus(
        array(
            'TopNav' => 'TopNav',
            'FooterNav' => 'FooterNav',
            'MetaNav' => 'MetaNav'
        )
    );
}


/** start cleanup  */

function jado_start()
{
    add_action('init', 'jado_head_cleanup');
    add_filter('the_generator', 'jado_rss_version');
    jado_theme_support();
}

add_action('after_setup_theme', 'jado_start');


function jado_register_sidebars()
{
    register_sidebar(
        array(
            'id' => 'widget-area',
            'name' => 'Widget Area',
            'description' => 'Widget Area',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>',
        ));
}

add_action('widgets_init', 'jado_register_sidebars');


/** Admin Login Site Design */

function jado_login_css()
{
    ?>
    <style>
        #login h1{
            position: relative;
        }

        #login h1 a {
            background: url(<?php echo get_stylesheet_directory_uri(); ?>/lib/img/jado-logo_login.svg) no-repeat center center;
            background-size: 40%;
            width: 326px;
            height: 67px;
            text-indent: -9999px;
            overflow: hidden;
            padding-bottom: 15px;
            display: block;
        }

        #login h1:after{
            content: 'Starter Theme';
            position: absolute;
            top: 100%;
            left: 0.5em;
            color: black;
            font-weight: normal;
            text-transform: uppercase;
            font-size: 40%;
            letter-spacing: 2px;
            opacity: 0.6;
            width: 100%;
            display: inline-block;
        }

        body.login {
            background-color: rgba(0,0,0,0.05);
        }

        #loginform{
            margin-top: 50px;
            border-radius: 1em;
        }

        .login #nav {
            text-align: center;
        }

        .privacy-policy-page-link, .language-switcher, #backtoblog {
            display: none;
        }
    </style>
<?php }

add_action('login_enqueue_scripts', 'jado_login_css');

/** Login site github Link */

function change_wp_login_url() {
    return 'https://github.com/jadoGmbH/jadoStarterTheme/';
}
add_filter('login_headerurl', 'change_wp_login_url');

/** Login site jado Link */

function login_page_footer()
{ ?>
    <p style="text-align: center; padding-top: 2em;">
        <a href="https://www.ja.do" target="_blank">jado GmbH</a>
    </p>
<?php }

add_action('login_footer', 'login_page_footer');


/** Admin Design */

function jado_admin_CSS()
{
    ?>
    <style>
        .accordion-section-title button.accordion-trigger{height: 3em !important;}

        #adminmenu div.wp-menu-image.dashicons-admin-generic:before, #adminmenu div.wp-menu-image.dashicons-images-alt2:before {
            color: #e1f200 !important;
        }

        body.toplevel_page_jado_options #wpbody form h2{padding-top: 2em; border-top: 1px solid #dcdcdc; margin: 2em 0 1em 0; color: #aaa; text-transform: uppercase; letter-spacing: 0.1em;}
        body.toplevel_page_jado_options table.form-table tbody tr{background: rgba(255,255,255,0.5); display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between; border-right: 1px solid #dcdcdc;}
        body.toplevel_page_jado_options table.form-table tbody tr td{padding-right: 20px; display: flex; align-items: center; margin: 0;}
        body.toplevel_page_jado_options table.form-table tbody th[scope="row"]{display: flex; align-items: center;}

        @media only screen and (min-width: 768px) {
            body.toplevel_page_jado_options .form-table tbody tr:nth-child(even) {
                clear: left;
                border-right: none;
            }

            body.toplevel_page_jado_options tr.swiperjs{
                background: rgba(255,255,255,0.5) url(<?php echo get_template_directory_uri()?>/lib/img/swiperjs.png) no-repeat 80% center !important;
                background-size: 5em !important;
            }
            body.toplevel_page_jado_options tr.swiperjs:hover{
                background: rgba(255,255,255,1) url(<?php echo get_template_directory_uri()?>/lib/img/swiperjs.png) no-repeat 80% center !important;
                background-size: 5em !important;
            }

            body.toplevel_page_jado_options tr.baguettebox{
                background: rgba(255,255,255,0.5) url(<?php echo get_template_directory_uri()?>/lib/img/baguettebox.png) no-repeat 80% center !important;
                background-size: 5em !important;
            }
            body.toplevel_page_jado_options tr.baguettebox:hover{
                background: rgba(255,255,255,1) url(<?php echo get_template_directory_uri()?>/lib/img/baguettebox.png) no-repeat 80% center !important;
                background-size: 5em !important;
            }

            body.toplevel_page_jado_options table.form-table tbody{display: flex; flex-wrap: wrap;}
            body.toplevel_page_jado_options table.form-table tbody tr:hover{background: rgba(255,255,255,1);}
            body.toplevel_page_jado_options table.form-table tbody tr th{padding-left: 20px;width: 260px;}
            body.toplevel_page_jado_options table.form-table tbody tr{flex: 0 0 48%;}
            body.toplevel_page_jado_options .form-table tbody tr {
                width: 46%;
                float: left;
            }
            body.toplevel_page_jado_options .form-table tbody th label {
                display: block;
            }
        }
    </style>
<?php }

add_action('admin_enqueue_scripts', 'jado_admin_CSS');


/** Custom Backend footer Text */

function custom_admin_footer()
{
    echo '<a href="https://github.com/jadoGmbH/jadoStarterTheme">jado Starter Theme</a> ';
    echo __('by');
    echo ' <a href="https://www.ja.do" target="_blank">jado</a>';
}

add_filter('admin_footer_text', 'custom_admin_footer');


/** disable backend menu */

function remove_menus()
{
    global $menu;
    //$restricted = array(__('Dashboard', 'jadotheme'), __('Posts', 'jadotheme'), __('Media', 'jadotheme'), __('Links', 'jadotheme'), __('Pages', 'jadotheme'), __('Appearance', 'jadotheme'), __('Tools', 'jadotheme'), __('Users', 'jadotheme'), __('Settings', 'jadotheme'), __('Comments', 'jadotheme'), __('Plugins', 'jadotheme'));
    $restricted = array(__('Links', 'jadotheme'));
    end($menu);
    while (prev($menu)) {
        $value = explode(' ', $menu[key($menu)][0]);
        if (in_array($value[0] != null ? $value[0] : "", $restricted)) {
            unset($menu[key($menu)]);
        }
    }
}

add_action('admin_menu', 'remove_menus');


/** custom Image size */

add_image_size('ogimage', 1200, 630, array('center', 'center'));
add_image_size('featuredImage', 2000, 1400, array('center', 'center'));



/** woocommerce style */

if (class_exists('WooCommerce')) {
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');

    function ca_deregister_woocommerce_block_styles() {
        wp_deregister_style( 'wc-blocks-style' );
        wp_dequeue_style( 'wc-blocks-style' );
    }
    add_action( 'enqueue_block_assets', 'ca_deregister_woocommerce_block_styles' );
}



add_action( 'after_setup_theme', 'theme_add_woocommerce_support' );
function theme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}





/** Hide WP-Users */

function block_author_enumeration() {
    if (is_admin()) {
        return;
    }

    if (isset($_GET['author'])) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('init', 'block_author_enumeration');

function disable_json_user_enumeration($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    return $endpoints;
}
add_filter('rest_endpoints', 'disable_json_user_enumeration');



/** Permission-Policy-Header */


function set_permissions_policy_header($headers) {
    $headers['Permissions-Policy'] = 'geolocation=(), microphone=(), camera=()';
    return $headers;
}
add_filter('wp_headers', 'set_permissions_policy_header');


/** Referrer-Header-Policy */

function set_referrer_policy($headers) {
    $headers['Referrer-Policy'] = 'strict-origin-when-cross-origin';
    return $headers;
}
add_filter('wp_headers', 'set_referrer_policy');


/** Cross-Origin-Resource-Policy */

function set_corp_header($headers) {
    $headers['Cross-Origin-Resource-Policy'] = 'same-origin';
    return $headers;
}
add_filter('wp_headers', 'set_corp_header');



/** Cross-Origin-Open-Policy */

function set_coop_header($headers) {
    $headers['Cross-Origin-Opener-Policy'] = 'same-origin';
    return $headers;
}
add_filter('wp_headers', 'set_coop_header');


/** X-Frame-Options-Header - iFrames on other Sites */

function set_x_frame_options($headers) {
    $headers['X-Frame-Options'] = 'SAMEORIGIN';
    return $headers;
}
add_filter('wp_headers', 'set_x_frame_options');


/** X-XSS-Protection */

function set_x_xss_protection($headers) {
    $headers['X-XSS-Protection'] = '1; mode=block';
    return $headers;
}
add_filter('wp_headers', 'set_x_xss_protection');


/** X-Content-Type-Options */

function set_x_content_type_options($headers) {
    $headers['X-Content-Type-Options'] = 'nosniff';
    return $headers;
}
add_filter('wp_headers', 'set_x_content_type_options');


/** Strict-Transport-Security */

function set_hsts_header($headers) {
    if (is_ssl()) {
        $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains; preload';
    }
    return $headers;
}
add_filter('wp_headers', 'set_hsts_header');


/** Delay between login attempts */

function custom_login_delay() {
    sleep(20); // Delay 20 Seconds between login attempts
}

add_action('wp_login_failed', 'custom_login_delay');




/* DON'T DELETE THIS CLOSING TAG */ ?>