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
        body.toplevel_page_jado_options #wpbody form h2{font-size: 160% !important; padding-top: 2em; border-top: 1px solid #dcdcdc; margin: 2em 0 1em 0; color: #aaa; letter-spacing: 0.05em; font-weight: normal;}
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
                transition: all 300ms ease;
            }
            body.toplevel_page_jado_options tr.swiperjs:hover{
                background: #DBF409 url(<?php echo get_template_directory_uri()?>/lib/img/swiperjs.png) no-repeat 80% center !important;
                background-size: 5em !important;
            }
            body.toplevel_page_jado_options tr.baguettebox{
                background: rgba(255,255,255,0.5) url(<?php echo get_template_directory_uri()?>/lib/img/baguettebox.png) no-repeat 80% center !important;
                background-size: 5em !important;
                transition: all 300ms ease;
            }
            body.toplevel_page_jado_options tr.baguettebox:hover{
                background: #DBF409 url(<?php echo get_template_directory_uri()?>/lib/img/baguettebox.png) no-repeat 80% center !important;
                background-size: 5em !important;
            }
            body.toplevel_page_jado_options table.form-table tbody{display: flex; flex-wrap: wrap;}
            body.toplevel_page_jado_options table.form-table tbody tr:hover{background: #DBF409;}
            body.toplevel_page_jado_options table.form-table tbody tr label{color: #1d2327;}
            body.toplevel_page_jado_options table.form-table tbody tr:hover label{color: black;}
            body.toplevel_page_jado_options table.form-table tbody tr th{padding-left: 20px;width: 600px;}
            body.toplevel_page_jado_options table.form-table tbody tr{flex: 0 0 48%; transition: all 300ms ease;}
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




/* DON'T DELETE THIS CLOSING TAG */ ?>
