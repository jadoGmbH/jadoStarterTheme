<?php
// Menu and Options Page setup
function jado_top_lvl_menu(): void
{
    add_menu_page(
        __('jado Starter Theme Settings', 'jadotheme'),
        __('jST Settings', 'jadotheme'),
        'manage_options',
        'jado_options',
        'jado_options_page_callback',
        'dashicons-admin-generic',
        63
    );
}

add_action('admin_menu', 'jado_top_lvl_menu');

function jado_options_page_callback(): void
{
    // Initializing the options
    jado_initialize_options();

    ?>
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

// Function to initialize options if not set
function jado_initialize_options(): void
{
    $options = [
        'imgQuality',
        'setAltAttrImage',
        'AdminPostThumbnail',
        'enableSVGUploads',
        'gutenberg_full_width',
        'disableGutenbergCustomStyle',
        'disableEmoji',
        'removeXMLRPC',
        //'deactivateXMLSitemap',
        'disableEditorFullscreenDefault',
        'disableAdminBarFrontend',
        'disableEmbedsFrontend',
        'disableComments',
        'encodeEmails',
        'heartbeat',
        'scriptW3C',
        'pageExcerpts',
        'activateJquery',
        'editor_role_menu'
    ];

    foreach ($options as $option) {
        if (get_option($option) === false) {
            $default_value = ($option === 'imgQuality') ? 74 : 'no';
            add_option($option, $default_value);
        }
    }
}

// Register settings and fields
function jado_settings_fields(): void
{
    $option_group = 'jado_options_settings';
    $options = [
        'imgQuality' => __('Image Quality JPG Settings', 'jadotheme'),
        'setAltAttrImage' => __('Set alt attributes for images after upload (based on image)', 'jadotheme'),
        'AdminPostThumbnail' => __('Show featured images in backend', 'jadotheme'),
        'enableSVGUploads' => __('Enable SVG Uploads', 'jadotheme'),
        'gutenberg_full_width' => __('Gutenberg full width', 'jadotheme'),
        'disableGutenbergCustomStyle' => __('Deactivate Gutenberg inline styles', 'jadotheme'),
        'disableEmoji' => __('Disable Emoji', 'jadotheme'),
        'removeXMLRPC' => __('Disable XMLRPC', 'jadotheme'),
        //'deactivateXMLSitemap' => __('Deactivate XML Sitemap', 'jadotheme'),
        'disableEditorFullscreenDefault' => __('Disable Editor Fullscreen Default', 'jadotheme'),
        'disableAdminBarFrontend' => __('Disable Admin Bar in Frontend', 'jadotheme'),
        'disableEmbedsFrontend' => __('Disable Embeds in Frontend', 'jadotheme'),
        'disableComments' => __('Disable Comments', 'jadotheme'),
        'encodeEmails' => __('Encode emails e.g. <br>[email]email@email.com/email]', 'jadotheme'),
        'heartbeat' => __('Disable heartbeat <br>(auto safe etc.)', 'jadotheme'),
        'scriptW3C' => __('Correct script style (delete type=script)', 'jadotheme'),
        'pageExcerpts' => __('Excerpts for pages (for meta descriptions)', 'jadotheme'),
        'activateJquery' => __('Activate jQuery', 'jadotheme'),
        'editor_role_menu' => __('Give Editors Menu access', 'jadotheme')
    ];

    foreach ($options as $option => $label) {
        $sanitize_callback = 'jado_sanitize_checkbox';
        if ($option === 'imgQuality') {
            $sanitize_callback = 'absint';
        }
        register_setting($option_group, $option, ['sanitize_callback' => $sanitize_callback]);

        add_settings_section(
            'jado_section_id',
            '',
            '',
            'jado_options'
        );

        $callback = "jado_{$option}_field";
        add_settings_field(
            $option,
            __($label, 'jadotheme'),
            $callback,
            'jado_options',
            'jado_section_id',
            array(
                'label_for' => $option,
                'name' => $option
            )
        );
    }
}

// Sanitize checkbox values
function jado_sanitize_checkbox($value): string
{
    return 'on' === $value ? 'yes' : 'no';
}

// Field Callback functions
function jado_checkbox_field($args): void
{
    $value = get_option($args['name'], 'no');
    ?>
    <label>
        <input type="checkbox" name="<?php echo $args['name']; ?>" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
    </label>
    <?php
}

function jado_imgQuality_field($args): void
{
    printf(
        '<input type="number" id="%s" name="%s" value="%d" />',
        $args['name'],
        $args['name'],
        get_option($args['name'], 74)
    );
}

// Initialize fields
function jado_gutenberg_full_width_field($args): void
{
    jado_checkbox_field($args);
}

function jado_disableGutenbergCustomStyle_field($args): void
{
    jado_checkbox_field($args);
}

function jado_disableEmoji_field($args): void
{
    jado_checkbox_field($args);
}

function jado_AdminPostThumbnail_field($args): void
{
    jado_checkbox_field($args);
}

function jado_removeXMLRPC_field($args): void
{
    jado_checkbox_field($args);
}

function jado_deactivateXMLSitemap_field($args): void
{
    jado_checkbox_field($args);
}

function jado_disableEditorFullscreenDefault_field($args): void
{
    jado_checkbox_field($args);
}

function jado_enableSVGUploads_field($args): void
{
    jado_checkbox_field($args);
}

function jado_setAltAttrImage_field($args): void
{
    jado_checkbox_field($args);
}

function jado_disableAdminBarFrontend_field($args): void
{
    jado_checkbox_field($args);
}

function jado_disableEmbedsFrontend_field($args): void
{
    jado_checkbox_field($args);
}

function jado_disableComments_field($args): void
{
    jado_checkbox_field($args);
}

function jado_encodeEmails_field($args): void
{
    jado_checkbox_field($args);
}

function jado_heartbeat_field($args): void
{
    jado_checkbox_field($args);
}

function jado_scriptW3C_field($args): void
{
    jado_checkbox_field($args);
}

function jado_pageExcerpts_field($args): void
{
    jado_checkbox_field($args);
}

function jado_activateJquery_field($args): void
{
    jado_checkbox_field($args);
}

function jado_editor_role_menu_field($args): void
{
    jado_checkbox_field($args);
}

// Adding action to initialize settings fields
add_action('admin_init', 'jado_settings_fields');





add_action( 'admin_notices', 'jado_notice' );
function jado_notice(): void
{
    if(
        isset( $_GET[ 'page' ] )
        && 'jado_options' == $_GET[ 'page' ]
        && isset( $_GET[ 'settings-updated' ] )
        && $_GET['settings-updated']
    ) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>
                <strong><?php echo __('Settings saved'); ?></strong>
            </p>
        </div>
        <?php
    }
}




// Apply settings
function jado_apply_settings(): void
{

    /**  Gutenberg full width alignfull */
    $gutenbergFullWidth = get_option('gutenberg_full_width', 'no');
    if ($gutenbergFullWidth === 'yes') {
        add_theme_support('align-wide');
    }

    /**  Give editor role menu access  */
    $editorRoleMenu = get_option('editor_role_menu', 'no');
    if ($editorRoleMenu == 'yes') {
        $role_object = get_role( 'editor' );
        $role_object->add_cap( 'edit_theme_options' );
        function hide_menu(): void
        {
            if (current_user_can('editor')) {
                remove_submenu_page( 'themes.php', 'themes.php' );
                //remove_submenu_page( 'themes.php', 'widgets.php' );
            }
        }
        add_action('admin_head', 'hide_menu');
    }

    /** disable Emoji  */
    $disableEmoji = get_option('disableEmoji', 'no');
    if ($disableEmoji == 'yes') {
        function jadotheme_disableEmoji(): void
        {
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('wp_print_styles', 'print_emoji_styles');
        }
        add_action('after_setup_theme', 'jadotheme_disableEmoji');
    }


    /** Enable Admin Post Thumbnail on backend  */
    $AdminPostThumbnail = get_option('AdminPostThumbnail', 'no');
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
        function jado_show_post_thumbnail_column($jado_columns, $jado_id): void
        {
            switch ($jado_columns) {
                case 'jado_thumb':
                    if (function_exists('the_post_thumbnail'))
                        the_post_thumbnail('adminFeaturedImage');
                    else
                        echo __('Your theme do not support post thumbnails ...');
                    break;
            }
        }
    }

    /** disable XMLRPC */
    $removeXMLRPC = get_option('removeXMLRPC', 'no');
    if ($removeXMLRPC == 'yes') {
        function remove_xmlrpc_methods($methods): array
        {
            return array();
        }
        add_filter('xmlrpc_methods', 'remove_xmlrpc_methods');
    }


    /** disable admin fullscreen mode default */
    $disableEditorFullscreenDefault = get_option('disableEditorFullscreenDefault', 'no');
    if ($disableEditorFullscreenDefault == 'yes') {
        function jado_disable_editor_fullscreen(): void
        {
            $script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
            wp_add_inline_script('wp-blocks', $script);
        }
        add_action('enqueue_block_editor_assets', 'jado_disable_editor_fullscreen');
    }

    /** enable SVG upload  */
    $enableSVGUploads = get_option('enableSVGUploads', 'no');
    if ($enableSVGUploads == 'yes') {
        function ja_myme_types($mime_types)
        {
            $mime_types['svg'] = 'image/svg+xml';
            return $mime_types;
        }
        add_filter('upload_mimes', 'ja_myme_types', 1, 1);
    }

    /** disable admin bar frontend */
    $disableAdminBarFrontend = get_option('disableAdminBarFrontend', 'no');
    if ($disableAdminBarFrontend == 'yes') {
        add_filter('show_admin_bar', '__return_false');
    }


    /** disable embeds  */
    $disableEmbedsFrontend = get_option('disableEmbedsFrontend', 'no');
    if ($disableEmbedsFrontend == 'yes') {
        function disable_embeds_code_init(): void
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
        function disable_embeds_tiny_mce_plugin($plugins): array
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
    $disableGutenbergCustomStyle = get_option('disableGutenbergCustomStyle', 'no');
    if ($disableGutenbergCustomStyle == 'yes') {
        function disable_gutenberg_custom_enqueue_scripts(): void
        {
            wp_dequeue_style('global-styles');
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
        }
        add_filter('wp_enqueue_scripts', 'disable_gutenberg_custom_enqueue_scripts', 100);
    }


    /** Set alt-attr on upload image */
    $setAltAttrImage = get_option('setAltAttrImage', 'no');
    if ($setAltAttrImage == 'yes') {
        function set_image_alt_on_image_upload($post_ID): void
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
    $disableComments = get_option('disableComments', 'no');
    if ($disableComments == 'yes') {
        function disable_comments_status(): bool
        {
            return false;
        }
        add_filter('comments_open', 'disable_comments_status', 20, 2);
        add_filter('pings_open', 'disable_comments_status', 20, 2);
        function disable_comments_post_types_support(): void
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
        function disable_comments_hide_existing_comments($comments): array
        {
            $comments = array();
            return $comments;
        }
        add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);
        function disable_comments_admin_menu(): void
        {
            remove_menu_page('edit-comments.php');
        }
        add_action('admin_menu', 'disable_comments_admin_menu');
        function disable_menus_admin_bar_render(): void
        {
            global $wp_admin_bar;
            $wp_admin_bar->remove_menu('comments');
        }
        add_action('wp_before_admin_bar_render', 'disable_menus_admin_bar_render');
    }


    /** Emails encode Shortcode! */
    $encodeEmails = get_option('encodeEmails', 'no');
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
    $heartbeat = get_option('heartbeat', 'no');
    if ($heartbeat == 'yes') {
        add_action('init', 'stop_heartbeat', 1);
        function stop_heartbeat(): void
        {
            wp_deregister_script('heartbeat');
        }
    }

    /** activate jQuery */
    $activateJquery = get_option('activateJquery', 'no');
    if ($activateJquery == 'yes') {
        function load_scripts(): void
        {
            wp_enqueue_script('jquery');
        }
        add_action('wp_enqueue_scripts', 'load_scripts');
    }


    /** excerpt for pages */
    $pageExcerpts = get_option('pageExcerpts', 'no');
    if ($pageExcerpts == 'yes') {
        add_action(
            'after_setup_theme',
            function () {
                add_post_type_support( 'page', 'excerpt' );
            }
        );
    }



    /** Script style W3C-Correct */
    $scriptW3C = get_option('scriptW3C', 'no');
    if ($scriptW3C == 'yes') {
        add_action(
            'after_setup_theme',
            function () {
                add_theme_support('html5', ['script', 'style']);
            }
        );

        add_filter('script_loader_tag', 'clean_script_tag');
        function clean_script_tag($input) {
            $input = str_replace("type='text/javascript' ", '', $input);
            return str_replace("'", '"', $input);
        }


        add_filter('style_loader_tag', 'jado_remove_type_attr', 10, 2);
        add_filter('script_loader_tag', 'jado_remove_type_attr', 10, 2);
        function jado_remove_type_attr($tag, $handle) {
            return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
        }
    }

}

add_action('after_setup_theme', 'jado_apply_settings');