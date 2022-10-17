<?php
/*
Author: ja.do GmbH
URL: https://www.ja.do
*/

/** Activate custom post type  */
//require_once( 'lib/custom-post-type.php' );



function jado_head_cleanup()
{
    // category feeds
    // remove_action( 'wp_head', 'feed_links_extra', 3 );
    // post and comment feeds
    // remove_action( 'wp_head', 'feed_links', 2 );
    // EditURI link
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
    add_filter('style_loader_src', 'jado_remove_wp_ver_css_js', 9999);
    add_filter('script_loader_src', 'jado_remove_wp_ver_css_js', 9999);
}


/** remove WP version from RSS */
function jado_rss_version()
{
    return '';
}

/** remove WP version from scripts */

function jado_remove_wp_ver_css_js($src)
{
    if (strpos($src, 'ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}


/** loading jquery */

function jado_loadjquery()
{
    global $wp_styles;
    if (!is_admin()) {
        wp_enqueue_script( 'jquery' );
    }
}


function jado_theme_support()
{
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menus(
        array(
            'topMenu' => __('TopMenu', 'jado'),   // main nav in header
            'footerNav' => __('FooterNav', 'jado') // secondary nav in footer
        )
    );
}


/** ja.do start   */

function jado_start()
{
    add_action('init', 'jado_head_cleanup');
    add_filter('the_generator', 'jado_rss_version');
    //add_action('wp_enqueue_scripts', 'jado_loadjquery', 999);
    jado_theme_support();
    add_action('widgets_init', 'jado_register_sidebars');
}

add_action('after_setup_theme', 'jado_start');



function jado_register_sidebars()
{
    register_sidebar(array(
        'id' => 'sidebar1',
        'name' => __('Sidebar 1', 'jado'),
        'description' => __('first sidebar', 'jado'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));

}



/** dsiable backend menu */


function remove_menus()
{
    global $menu;
    //$restricted = array(__('Beiträge'), __('Links'), __('Medien'), __('Kommentare'), __('Seiten'), __('Werkzeuge'), __('Plugins'));
    $restricted = array(__('Links'), __('Kommentare'), __('Werkzeuge'));
    end($menu);
    while (prev($menu)) {
        $value = explode(' ', $menu[key($menu)][0]);
        if (in_array($value[0] != null ? $value[0] : "", $restricted)) {
            unset($menu[key($menu)]);
        }
    }
}

add_action('admin_menu', 'remove_menus');


/** disable admin bar frontend */

add_filter('show_admin_bar', '__return_false');


/** disable Emoji  */

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/** disable embeds  */

function disable_embeds_code_init()
{
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );
    add_filter( 'embed_oembed_discover', '__return_false' );
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}

add_action('init', 'disable_embeds_code_init', 9999);

function disable_embeds_tiny_mce_plugin($plugins)
{
    return array_diff($plugins, array('wpembed'));
}

function disable_embeds_rewrites($rules)
{
    foreach ($rules as $rule => $rewrite) {
        if (false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }
    return $rules;
}


/** clean up header */

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');




/** custom Image size */

add_image_size('ogimage', 1200, 630, array('center', 'center'));


/** disable RSS Feed   */

function ja_disable_feed()
{
    wp_die(__('Sorry, we don\'t use RSS!'));
}

add_action('do_feed', 'ja_disable_feed', 1);
add_action('do_feed_rdf', 'ja_disable_feed', 1);
add_action('do_feed_rss', 'ja_disable_feed', 1);
add_action('do_feed_rss2', 'ja_disable_feed', 1);
add_action('do_feed_atom', 'ja_disable_feed', 1);



/** disable comments and pingbacks */

function disable_comments_status()
{
    return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);
function disable_comments_post_types_support()
{
    $post_types = get_post_types();
    foreach($post_types as $post_type)
    {
        if (post_type_supports($post_type, 'comments'))
        {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'disable_comments_post_types_support');
function disable_comments_hide_existing_comments($comments)
{
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);
function disable_comments_admin_menu()
{
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');
function disable_menus_admin_bar_render()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'disable_menus_admin_bar_render');




/** enable SVG upload  */

function ja_myme_types($mime_types)
{
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
}
add_filter('upload_mimes', 'ja_myme_types', 1, 1);



/**  Gutenberg full width alignfull */

function jadotheme_gutenwidth()
{
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'jadotheme_gutenwidth');



/** Emails encode Shortcode! */
/** USAGE: [email]email@email.de[/email] */


function jado_hide_email_shortcode( $atts , $content = null ) {
    if ( ! is_email( $content ) ) {
        return;
    }
    return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
}
add_shortcode( 'email', 'jado_hide_email_shortcode' );






/** Admin Login Site Design */

function jado_login_logo() {
    ?>
    <style>
        #login h1 a, .login h1 a {
            background: url(<?php echo get_stylesheet_directory_uri(); ?>/lib/img/jado-logo_login.svg) no-repeat center center;
            background-size: 40%;
            width: 326px;
            height: 67px;
            text-indent: -9999px;
            overflow: hidden;
            padding-bottom: 15px;
            display: block;
        }
        body.login {background-color: #a1a111;}
        .login #backtoblog, .login #nav{text-align: center;}
        .login #backtoblog a, .login #nav a {color: #fff !important;}
        .privacy-policy-page-link{display: none;}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'jado_login_logo' );


/** Login site ja.do Link */

function login_page_footer() { ?>
    <p style="text-align: center;">
        <a style="color: white;" href="https://www.ja.do" target="_blank">www.ja.do</a>
    </p>
<?php }
add_action('login_footer','login_page_footer');




/** disable admin fullscreen mode default */

function jado_disable_editor_fullscreen() {
    $script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
    wp_add_inline_script( 'wp-blocks', $script );
}
add_action( 'enqueue_block_editor_assets', 'jado_disable_editor_fullscreen' );





/**  Custom Excerpt Lenght */
/** USAGE:  the_excerpt_maxlength( 250 ); */

the_excerpt_maxlength(190);
function the_excerpt_maxlength($charlength) {
    $excerpt = get_the_excerpt();
    $charlength++;
    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo ' ...';
    } else {
        echo $excerpt;
    }
}



/** deactivate WP-sitemaps */

//add_filter( 'wp_sitemaps_enabled', '__return_false' );



/** deactivate heartbeat - auto save etc. */

add_action('init', 'stop_heartbeat', 1);
function stop_heartbeat()
{
    wp_deregister_script('heartbeat');
}


/**
 *  Script style W3C-Correct
 */


add_action(
    'after_setup_theme',
    function() {
        add_theme_support( 'html5', [ 'script', 'style' ] );
    }
);



/**
 * WordPress 6.0 Colums Hack
 */

remove_filter( 'render_block', 'wp_render_layout_support_flag' );

add_filter( 'render_block', function( $block_content, $block ) {
    if ( $block['blockName'] === 'core/group' ) {
        return $block_content;
    }
    if ( $block['blockName'] === 'core/columns' ) {
        return $block_content;
    }
    if ( $block['blockName'] === 'core/column' ) {
        return $block_content;
    }
    return wp_render_layout_support_flag( $block_content, $block );
}, 10, 2 );


/**
 * disable XMLRPC
 */


function remove_xmlrpc_methods($methods) {
    return array();
}
add_filter( 'xmlrpc_methods', 'remove_xmlrpc_methods' );



/** disable gutenberg frontend styles  */

function disable_gutenberg_wp_enqueue_scripts() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    //wp_dequeue_style( 'global-styles' ); // disable global inline styles
    //wp_dequeue_style('wc-block-style'); // disable woocommerce frontend block styles
    //wp_dequeue_style('storefront-gutenberg-blocks'); // disable storefront frontend block styles
}
add_filter('wp_enqueue_scripts', 'disable_gutenberg_wp_enqueue_scripts', 100);



/** image quality  */

function custom_jpeg_quality() {
    return 70;
}
add_filter( 'jpeg_quality', 'custom_jpeg_quality' );



/** Post Thumbnails at Admin Panel for POSTS and PAGES */

add_image_size( 'adminFeaturedImage', 120, 120, false );

add_filter('manage_posts_columns', 'jado_add_post_admin_thumbnail_column', 2);
add_filter('manage_pages_columns', 'jado_add_post_admin_thumbnail_column', 2);

function jado_add_post_admin_thumbnail_column($jado_columns){
    $jado_columns['jado_thumb'] = __('Featured Image');
    return $jado_columns;
}

add_action('manage_posts_custom_column', 'jado_show_post_thumbnail_column', 7, 2);
add_action('manage_pages_custom_column', 'jado_show_post_thumbnail_column', 7, 2);

function jado_show_post_thumbnail_column($jado_columns, $jado_id){
    switch($jado_columns){
        case 'jado_thumb':
            if( function_exists('the_post_thumbnail') )
                echo the_post_thumbnail( 'adminFeaturedImage' );
            else
                echo 'your theme does not support featured images ...';
            break;
    }
}











/* DON'T DELETE THIS CLOSING TAG */ ?>