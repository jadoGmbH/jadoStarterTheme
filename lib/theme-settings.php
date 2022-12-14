<?php


function jado_top_lvl_menu()
{
    add_menu_page(
        __('Theme Functions', 'jadotheme'),
        __('Theme Functions', 'jadotheme'),
        'manage_options',
        'jado_options',
        'jado_options_page_callback', // this function prints the page content
        'dashicons-admin-generic',
        63
    );
}

add_action('admin_menu', 'jado_top_lvl_menu');


function jado_options_page_callback()
{ ?>
    <div class="wrap">
        <h1><?php echo get_admin_page_title() ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('jado_options_settings');
            do_settings_sections('jado_options');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


add_action('admin_init', 'jado_settings_fields');
function jado_settings_fields()
{
    $page_slug = 'jado_options';
    $option_group = 'jado_options_settings';
    add_settings_section(
        'jado_section_id',
        '',
        '',
        $page_slug
    );
    register_setting($option_group, 'gutenberg_full_width', 'jado_sanitize_checkbox');
    register_setting($option_group, 'disableGutenbergCustomStyle', 'jado_sanitize_checkbox');
    register_setting($option_group, 'disableEmoji', 'jado_sanitize_checkbox');
    register_setting($option_group, 'AdminPostThumbnail', 'jado_sanitize_checkbox');
    register_setting($option_group, 'removeXMLRPC', 'jado_sanitize_checkbox');
    register_setting($option_group, 'deactivateXMLSitemap', 'jado_sanitize_checkbox');
    register_setting($option_group, 'disableEditorFullscreenDefault', 'jado_sanitize_checkbox');
    register_setting($option_group, 'enableSVGUploads', 'jado_sanitize_checkbox');
    register_setting($option_group, 'setAltAttrImage', 'jado_sanitize_checkbox');
    register_setting($option_group, 'disableAdminBarFrontend', 'jado_sanitize_checkbox');
    register_setting($option_group, 'disableEmbedsFrontend', 'jado_sanitize_checkbox');
    register_setting($option_group, 'disableComments', 'jado_sanitize_checkbox');
    register_setting($option_group, 'encodeEmails', 'jado_sanitize_checkbox');
    register_setting($option_group, 'heartbeat', 'jado_sanitize_checkbox');
    register_setting($option_group, 'scriptW3C', 'jado_sanitize_checkbox');
    register_setting($option_group, 'pageExcerpts', 'jado_sanitize_checkbox');
    register_setting($option_group, 'activateJquery', 'jado_sanitize_checkbox');



    register_setting($option_group, 'imgQuality', 'absint');

    add_settings_field(
        'imgQuality',
        __('Upload Image JPG Quality', 'jadotheme'),
        'jado_imageQuality',
        $page_slug,
        'jado_section_id',
        array(
            'label_for' => 'imgQuality',
            'class' => 'blunzi',
            'name' => 'imgQuality'
        )
    );


    add_settings_field(
        'setAltAttrImage',
        __('Enable auto alt-attributes on all Images after upload <br>(based on image name)', 'jadotheme'),
        'jado_setAltAttrImage',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'AdminPostThumbnail',
        __('Enable Post Thumbnail in backend', 'jadotheme'),
        'jado_AdminPostThumbnail',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'enableSVGUploads',
        __('Enable SVG Uploads', 'jadotheme'),
        'jado_enableSVGUploads',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'gutenberg_full_width',
        __('Gutenberg Full width', 'jadotheme'),
        'jado_checkboxGutenbergFullWidth',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'disableGutenbergCustomStyle',
        __('Disable Gutenberg Custom inline Styles', 'jadotheme'),
        'jado_disableGutenbergCustomStyle',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'disableEmoji',
        __('Disable Emoji', 'jadotheme'),
        'jado_disableEmoji',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'disableComments',
        __('Disable Comments', 'jadotheme'),
        'jado_disableComments',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'removeXMLRPC',
        __('Remove XMLRPC', 'jadotheme'),
        'jado_removeXMLRPC',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'disableAdminBarFrontend',
        __('Disable Admin Bar Frontend', 'jadotheme'),
        'jado_disableAdminBarFrontend',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'disableEmbedsFrontend',
        __('Disable Embeds Frontend', 'jadotheme'),
        'jado_disableEmbedsFrontend',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'disableEditorFullscreenDefault',
        __('Disable Editor Fullscreen Default', 'jadotheme'),
        'jado_disableEditorFullscreenDefault',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'encodeEmails',
        __('Encode Emails <br>usage: [email]email@email.de[/email]', 'jadotheme'),
        'jado_encodeEmails',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'heartbeat',
        __('Disable Heartbeat <br>(auto safe etc.)', 'jadotheme'),
        'jado_heartbeat',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'scriptW3C',
        __('Enable correct script style <br>(get rid of type=script etc.)', 'jadotheme'),
        'jado_scriptW3C',
        $page_slug,
        'jado_section_id'
    );



    add_settings_field(
        'pageExcerpts',
        __('Enable excerpts on pages<br>(for meta descriptions)', 'jadotheme'),
        'jado_pageExcerpts',
        $page_slug,
        'jado_section_id'
    );


    add_settings_field(
        'activateJquery',
        __('Enable jQuery', 'jadotheme'),
        'jado_activateJquery',
        $page_slug,
        'jado_section_id'
    );


}


/** image JPG quality  */

function jado_imageQuality($args)
{
    printf(
        '<input type="number" id="%s" name="%s" value="%d" />',
        $args['name'],
        $args['name'],
        get_option($args['name'], 82)
    );
}


function custom_jpeg_quality()
{
    $imageQuality = get_option('imgQuality');
    if ($imageQuality != '') {
        return $imageQuality;
    } else {
        return 82;
    }
}

add_filter('jpeg_quality', 'custom_jpeg_quality');


/**  Gutenberg full width alignfull */

function jado_checkboxGutenbergFullWidth()
{
    $value = get_option('gutenberg_full_width');
    ?>
    <label>
        <input type="checkbox"
               name="gutenberg_full_width" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}
$gutenbergFullWidth = get_option('gutenberg_full_width');
if ($gutenbergFullWidth == 'yes') {
    function jadotheme_gutenbergFullWidth()
    {
        add_theme_support('align-wide');
    }

    add_action('after_setup_theme', 'jadotheme_gutenbergFullWidth');
}


/** disable Emoji  */

function jado_disableEmoji()
{
    $value = get_option('disableEmoji');
    ?>
    <label>
          <input type="checkbox" name="disableEmoji" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}
$disableEmoji = get_option('disableEmoji');
if ($disableEmoji == 'yes') {
    function jadotheme_disableEmoji()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
    }
    add_action('after_setup_theme', 'jadotheme_disableEmoji');
}


/** Enable Admin Post Thumbnail on backend  */

function jado_AdminPostThumbnail()
{
    $value = get_option('AdminPostThumbnail');
    ?>
    <label>
        <input type="checkbox"
               name="AdminPostThumbnail" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}
$AdminPostThumbnail = get_option('AdminPostThumbnail');
if ($AdminPostThumbnail == 'yes') {
    add_image_size('adminFeaturedImage', 120, 120, false);
    add_filter('manage_posts_columns', 'jado_add_post_admin_thumbnail_column', 2);
    add_filter('manage_pages_columns', 'jado_add_post_admin_thumbnail_column', 2);
    function jado_add_post_admin_thumbnail_column($jado_columns)
    {
        $jado_columns['jado_thumb'] = __('Featured Image');
        return $jado_columns;
    }

    add_action('manage_posts_custom_column', 'jado_show_post_thumbnail_column', 7, 2);
    add_action('manage_pages_custom_column', 'jado_show_post_thumbnail_column', 7, 2);
    function jado_show_post_thumbnail_column($jado_columns, $jado_id)
    {
        switch ($jado_columns) {
            case 'jado_thumb':
                if (function_exists('the_post_thumbnail'))
                    the_post_thumbnail('adminFeaturedImage');
                else
                    echo __('your theme does not support featured images ...');
                break;
        }
    }
}


/** disable XMLRPC */

function jado_removeXMLRPC()
{
    $value = get_option('removeXMLRPC');
    ?>
    <label>
        <input type="checkbox"
               name="removeXMLRPC" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$removeXMLRPC = get_option('removeXMLRPC');
if ($removeXMLRPC == 'yes') {
    function remove_xmlrpc_methods($methods)
    {
        return array();
    }

    add_filter('xmlrpc_methods', 'remove_xmlrpc_methods');
}


/** disable admin fullscreen mode default */

function jado_disableEditorFullscreenDefault()
{
    $value = get_option('disableEditorFullscreenDefault');
    ?>
    <label>
        <input type="checkbox"
               name="disableEditorFullscreenDefault" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}


$disableEditorFullscreenDefault = get_option('disableEditorFullscreenDefault');
if ($disableEditorFullscreenDefault == 'yes') {
    function jado_disable_editor_fullscreen()
    {
        $script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
        wp_add_inline_script('wp-blocks', $script);
    }

    add_action('enqueue_block_editor_assets', 'jado_disable_editor_fullscreen');
}


/** enable SVG upload  */

function jado_enableSVGUploads()
{
    $value = get_option('enableSVGUploads');
    ?>
    <label>
        <input type="checkbox"
               name="enableSVGUploads" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$enableSVGUploads = get_option('enableSVGUploads');
if ($enableSVGUploads == 'yes') {
    function ja_myme_types($mime_types)
    {
        $mime_types['svg'] = 'image/svg+xml';
        return $mime_types;
    }

    add_filter('upload_mimes', 'ja_myme_types', 1, 1);
}


/** disable admin bar frontend */

function jado_disableAdminBarFrontend()
{
    $value = get_option('disableAdminBarFrontend');
    ?>
    <label>
        <input type="checkbox"
               name="disableAdminBarFrontend" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$disableAdminBarFrontend = get_option('disableAdminBarFrontend');
if ($disableAdminBarFrontend == 'yes') {
    add_filter('show_admin_bar', '__return_false');
}


/** disable embeds  */

function jado_disableEmbedsFrontend()
{
    $value = get_option('disableEmbedsFrontend');
    ?>
    <label>
        <input type="checkbox"
               name="disableEmbedsFrontend" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$disableEmbedsFrontend = get_option('disableEmbedsFrontend');
if ($disableEmbedsFrontend == 'yes') {
    function disable_embeds_code_init()
    {
        remove_action('rest_api_init', 'wp_oembed_register_route');
        add_filter('embed_oembed_discover', '__return_false');
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');
        add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
        remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
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
}


/** disable gutenberg frontend custom styles  */


function jado_disableGutenbergCustomStyle()
{
    $value = get_option('disableGutenbergCustomStyle');
    ?>
    <label>
        <input type="checkbox"
               name="disableGutenbergCustomStyle" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$disableGutenbergCustomStyle = get_option('disableGutenbergCustomStyle');
if ($disableGutenbergCustomStyle == 'yes') {
    function disable_gutenberg_custom_enqueue_scripts()
    {
        wp_dequeue_style('global-styles');
    }

    add_filter('wp_enqueue_scripts', 'disable_gutenberg_custom_enqueue_scripts', 100);
}


/** Set alt-attr on upload image */

function jado_setAltAttrImage()
{
    $value = get_option('setAltAttrImage');
    ?>
    <label>
        <input type="checkbox"
               name="setAltAttrImage" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$setAltAttrImage = get_option('setAltAttrImage');

if ($setAltAttrImage == 'yes') {
    function set_image_alt_on_image_upload($post_ID)
    {
        if (wp_attachment_is_image($post_ID)) {
            $jado_image_title = get_post($post_ID)->post_title;
            $jado_image_title = preg_replace('%\s*[-_\s]+\s*%', ' ', $jado_image_title);
            $jado_image_title = ucwords(strtolower($jado_image_title));
            $jado_image_meta = array(
                'ID' => $post_ID,
                'post_title' => $jado_image_title,
                'post_excerpt' => $jado_image_title,
                'post_content' => $jado_image_title,
            );
            update_post_meta($post_ID, '_wp_attachment_image_alt', $jado_image_title);
            wp_update_post($jado_image_meta);
        }
    }

    add_action('add_attachment', 'set_image_alt_on_image_upload', 109);
}


/** disable comments and pingbacks  */


function jado_disableComments()
{
    $value = get_option('disableComments');
    ?>
    <label>
        <input type="checkbox"
               name="disableComments" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$disableComments = get_option('disableComments');
if ($disableComments == 'yes') {
    function disable_comments_status()
    {
        return false;
    }
    add_filter('comments_open', 'disable_comments_status', 20, 2);
    add_filter('pings_open', 'disable_comments_status', 20, 2);
    function disable_comments_post_types_support()
    {
        $post_types = get_post_types();
        foreach ($post_types as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
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
}


/** Emails encode Shortcode! */

function jado_encodeEmails()
{
    $value = get_option('encodeEmails');
    ?>
    <label>
        <input type="checkbox"
               name="encodeEmails" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$encodeEmails = get_option('encodeEmails');
if ($encodeEmails == 'yes') {
    function jado_hide_email_shortcode($atts, $content = null)
    {
        if (!is_email($content)) {
            return;
        }
        return '<a href="mailto:' . antispambot($content) . '">' . antispambot($content) . '</a>';
    }

    add_shortcode('email', 'jado_hide_email_shortcode');
}


/** deactivate heartbeat - auto save etc. */

function jado_heartbeat()
{
    $value = get_option('heartbeat');
    ?>
    <label>
        <input type="checkbox" name="heartbeat" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$heartbeat = get_option('heartbeat');
if ($heartbeat == 'yes') {
    add_action('init', 'stop_heartbeat', 1);
    function stop_heartbeat()
    {
        wp_deregister_script('heartbeat');
    }
}




/** activate jQuery */

function jado_activateJquery()
{
    $value = get_option('activateJquery');
    ?>
    <label>
        <input type="checkbox" name="activateJquery" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$activateJquery = get_option('activateJquery');
if ($activateJquery == 'yes') {
    function load_scripts(){
        wp_enqueue_script('jquery');
    }
    add_action('wp_enqueue_scripts', 'load_scripts');
}









/** excerpt for pages */


function jado_pageExcerpts()
{
    $value = get_option('pageExcerpts');
    ?>
    <label>
        <input type="checkbox" name="pageExcerpts" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$pageExcerpts = get_option('pageExcerpts');
if ($pageExcerpts == 'yes') {
    add_action(
        'after_setup_theme',
        function () {
            add_post_type_support( 'page', 'excerpt' );
        }
    );
}




/** Script style W3C-Correct */

function jado_scriptW3C()
{
    $value = get_option('scriptW3C');
    ?>
    <label>
        <input type="checkbox" name="scriptW3C" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

$scriptW3C = get_option('scriptW3C');
if ($scriptW3C == 'yes') {
    add_action(
        'after_setup_theme',
        function () {
            add_theme_support('html5', ['script', 'style']);
        }
    );
}









function jado_sanitize_checkbox($value)
{
    return 'on' === $value ? 'yes' : 'no';
}







add_action( 'admin_notices', 'jado_notice' );
function jado_notice() {
    if(
        isset( $_GET[ 'page' ] )
        && 'jado_options' == $_GET[ 'page' ]
        && isset( $_GET[ 'settings-updated' ] )
        && true == $_GET[ 'settings-updated' ]
    ) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>
                <strong><?php echo __('Settings saved'); ?></strong>
            </p>
        </div>

        <div class="notice notice-error is-dismissible">
            <p>
                <strong><?php echo __('Please note: Settings are not saved the first time, only the second time saved - we are working on this!'); ?></strong>
            </p>
        </div>
        <?php
    }
}
?>