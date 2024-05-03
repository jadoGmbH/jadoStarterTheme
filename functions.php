<?php

load_theme_textdomain('jadotheme', TEMPLATEPATH . '/languages');


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
            //background-color: #ffffff;
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
        #adminmenu div.wp-menu-image.dashicons-admin-generic:before {
            color: #e1f200 !important;
        }

        @media only screen and (min-width: 768px) {
            .form-table tbody tr:nth-child(even) {
                clear: left;
            }

            .form-table tbody tr {
                width: 48%;
                float: left;
            }

            .form-table tbody th label {
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




/* DON'T DELETE THIS CLOSING TAG */ ?>