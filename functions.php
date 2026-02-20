<?php

load_theme_textdomain('jadotheme', get_template_directory() . '/languages');


/** Theme Functions page */
require_once('lib/theme-settings.php');


/** Activate custom post type Example  */
//require_once('lib/custom-post-types.php'); // enable to get Custom Post Type "products"


function theme_enqueue_styles() {
    $ver = (str_contains($_SERVER["HTTP_HOST"], 'local'))
        ? date('His')
        : '01a';

    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/lib/css/style.css',
        [],
        $ver
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

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



/**
 * Add "Patterns" menu item to the Appearance menu for classic themes.
 */

function jado_add_patterns_menu() {
    add_submenu_page(
        'themes.php',
        __('Patterns', 'default'),
        __('Patterns', 'default'),
        'edit_theme_options',
        'edit.php?post_type=wp_block'
    );
}
add_action('admin_menu', 'jado_add_patterns_menu');



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
            body.toplevel_page_jado_options table.form-table tbody tr.baguettebox label, body.toplevel_page_jado_options table.form-table tbody tr.swiperjs label{max-width: 75%;}
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





/**
 * Featured Video (MP4) as alternative to Featured Image
 * - Adds a meta box on posts and pages to select/upload an MP4 file
 * - Frontend helpers to render video as featured media when present
 */
function jado_add_featured_video_metabox() {
    add_meta_box(
        'jado_featured_video',
        __('Featured Video (MP4)', 'jadotheme'),
        'jado_featured_video_metabox_cb',
        ['post', 'page'],
        'side',
        'low'
    );
}
add_action('add_meta_boxes', 'jado_add_featured_video_metabox');

function jado_featured_video_metabox_cb($post) {
    $video_id = (int) get_post_meta($post->ID, '_jado_featured_video_id', true);
    wp_nonce_field('jado_featured_video_save', 'jado_featured_video_nonce');
    $preview = '';
    if ($video_id) {
        $src = wp_get_attachment_url($video_id);
        if ($src) {
            $poster = has_post_thumbnail($post) ? get_the_post_thumbnail_url($post, 'medium') : '';
            $preview = '<video src="' . esc_url($src) . '" style="max-width:100%;height:auto" ' . ($poster? 'poster="' . esc_url($poster) . '"':'') . ' muted playsinline controls></video>';
        }
    }
    echo '<div id="jado-featured-video-preview">' . $preview . '</div>';
    echo '<input type="hidden" id="jado_featured_video_id" name="jado_featured_video_id" value="' . esc_attr($video_id) . '" />';
    echo '<p class="hide-if-no-js">'
        . '<button type="button" class="button" id="jado_select_featured_video">' . esc_html__('Select MP4', 'jadotheme') . '</button> '
        . '<button type="button" class="button button-link-delete" id="jado_remove_featured_video" ' . ($video_id? '':'disabled') . '>' . esc_html__('Remove', 'jadotheme') . '</button>'
        . '</p>';
}

function jado_save_featured_video_meta($post_id) {
    if (!isset($_POST['jado_featured_video_nonce']) || !wp_verify_nonce($_POST['jado_featured_video_nonce'], 'jado_featured_video_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['jado_featured_video_id'])) {
        $vid = (int) $_POST['jado_featured_video_id'];
        if ($vid > 0) {
            $mime = get_post_mime_type($vid);
            if (strpos((string)$mime, 'video/') === 0) {
                update_post_meta($post_id, '_jado_featured_video_id', $vid);
            } else {
                // only videos allowed
                delete_post_meta($post_id, '_jado_featured_video_id');
            }
        } else {
            delete_post_meta($post_id, '_jado_featured_video_id');
        }
    }
}
add_action('save_post', 'jado_save_featured_video_meta');

function jado_admin_featured_video_assets($hook) {
    if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
    wp_enqueue_media();
    $code = 'jQuery(function($){
        var frame;
        $(document).on("click", "#jado_select_featured_video", function(e){
            e.preventDefault();
            var holder = $("#jado-featured-video-preview");
            if (frame) { frame.open(); return; }
            frame = wp.media({
                title: "' . esc_js(__('Select MP4 video','jadotheme')) . '",
                button: { text: "' . esc_js(__('Use this video','jadotheme')) . '" },
                library: { type: "video" },
                multiple: false
            });
            frame.on("select", function(){
                var attachment = frame.state().get("selection").first().toJSON();
                if (attachment && attachment.mime && attachment.mime.indexOf("video/") === 0) {
                    $("#jado_featured_video_id").val(attachment.id);
                    var v = document.createElement("video");
                    v.src = attachment.url;
                    v.controls = true;
                    v.muted = true;
                    v.playsInline = true;
                    v.style.maxWidth = "100%";
                    v.style.height = "auto";
                    holder.empty().append(v);
                    $("#jado_remove_featured_video").prop("disabled", false);
                }
            });
            frame.open();
        });
        $(document).on("click", "#jado_remove_featured_video", function(){
            $("#jado_featured_video_id").val("");
            $("#jado-featured-video-preview").empty();
            $(this).prop("disabled", true);
        });
    });';
    wp_add_inline_script('jquery-core', $code, 'after');
}
add_action('admin_enqueue_scripts', 'jado_admin_featured_video_assets');

// Helper: return featured video attachment id or 0
function jado_get_featured_video_id($post_id = null){
    $post_id = $post_id ? $post_id : get_the_ID();
    return (int) get_post_meta($post_id, '_jado_featured_video_id', true);
}

// Render featured media (video if available, otherwise image). Returns HTML string.
function jado_render_featured_media($post_id = null, $size = 'featuredImage'){
    $post_id = $post_id ? $post_id : get_the_ID();
    $vid = jado_get_featured_video_id($post_id);
    if ($vid) {
        $src = wp_get_attachment_url($vid);
        if ($src) {
            $poster = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, $size) : '';
            $attrs = 'autoplay muted loop playsinline';
            $poster_attr = $poster ? ' poster="' . esc_url($poster) . '"' : '';
            return '<video class="featured-video" src="' . esc_url($src) . '"' . $poster_attr . ' ' . $attrs . '></video>';
        }
    }
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail($post_id, $size);
    }
    return '';
}


/**
 * Apache .htaccess Browser Caching (svg, js, css, webp, jpg, png, woff2)
 * - Adds/removes a marker block in .htaccess using WordPress insert_with_markers
 * - Controlled via option 'htaccessCaching' (checkbox in SEO/Performance section)
 */
if (!function_exists('jado_is_apache')) {
    function jado_is_apache(): bool
    {
        if (function_exists('apache_get_version')) {
            return true;
        }
        $sw = isset($_SERVER['SERVER_SOFTWARE']) ? strtolower((string) $_SERVER['SERVER_SOFTWARE']) : '';
        return strpos($sw, 'apache') !== false;
    }
}

if (!function_exists('jado_write_htaccess_caching')) {
    function jado_write_htaccess_caching(bool $enable): bool
    {
        if (!jado_is_apache()) {
            return false; // Only for Apache
        }
        $htaccess = ABSPATH . '.htaccess';

        // Ensure file exists or can be created
        if (!file_exists($htaccess)) {
            if (!is_writable(ABSPATH)) {
                return false;
            }
            @touch($htaccess);
        }
        if (!is_writable($htaccess)) {
            return false;
        }

        if (!function_exists('insert_with_markers')) {
            require_once ABSPATH . 'wp-admin/includes/misc.php';
        }

        $marker = 'jST Caching';
        $lines = [];
        if ($enable) {
            $lines = [
                '<IfModule mod_expires.c>',
                'ExpiresActive On',
                'ExpiresDefault "access plus 1 month"',
                'ExpiresByType image/svg+xml "access plus 1 year"',
                'ExpiresByType image/webp "access plus 1 year"',
                'ExpiresByType image/jpeg "access plus 1 year"',
                'ExpiresByType image/png "access plus 1 year"',
                'ExpiresByType font/woff2 "access plus 1 year"',
                'ExpiresByType text/css "access plus 1 year"',
                'ExpiresByType application/javascript "access plus 1 year"',
                '</IfModule>',
                '<IfModule mod_headers.c>',
                'FileETag None',
                '<FilesMatch "\.(?:svg|js|css|webp|jpe?g|png|woff2)$">',
                'Header set Cache-Control "public, max-age=31536000, immutable"',
                '</FilesMatch>',
                '</IfModule>',
            ];
        }

        return (bool) insert_with_markers($htaccess, $marker, $lines);
    }
}

// Apply when option toggles
function jado_update_option_htaccess_caching($old_value, $value, $option): void
{
    $enable = ($value === '1' || $value === 'yes' || $value === 1 || $value === true);
    jado_write_htaccess_caching($enable);
}
add_action('update_option_htaccessCaching', 'jado_update_option_htaccess_caching', 10, 3);

// Also try to enforce on admin init (e.g., after theme activation)
add_action('admin_init', function () {
    $val = get_option('htaccessCaching', '');
    if ($val !== '' && $val !== null) {
        $enable = ($val === '1' || $val === 'yes' || $val === 1 || $val === true);
        jado_write_htaccess_caching($enable);
    }
});
