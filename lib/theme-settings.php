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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.form-table tr');
            rows.forEach(row => {
                const input = row.querySelector('input, select, textarea');
                if (input) {
                    row.classList.add(input.name);
                }
            });
        });
    </script>
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
        'disableEditorFullscreenDefault',
        'customAdminStyle',
        'disableEmoji',
        'removeXMLRPC',
        'disableEmbedsFrontend',
        'disableComments',
        'encodeEmails',
        'heartbeat',
        'scriptW3C',
        'swiperjs',
        'baguettebox',
        'pageExcerpts',
        'maintenanceMode',
        //'deactivateXMLSitemap',
        'disableAdminBarFrontend',
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

    // Section 1: Media Settings
    add_settings_section(
        'jado_section_media',
        __('Media Settings', 'jadotheme'),
        '',
        'jado_options'
    );

    $media_options = [
        'imgQuality' => __('Image Quality JPG Settings', 'jadotheme'),
        'setAltAttrImage' => __('Set alt attributes for images after upload (based on image)', 'jadotheme'),
        'AdminPostThumbnail' => __('Show featured images in backend', 'jadotheme'),
        'enableSVGUploads' => __('Enable SVG Uploads', 'jadotheme'),
        'swiperjs' => __('Enable SwiperJS for every Gallery Block', 'jadotheme'),
        'baguettebox' => __('Enable Lightbox for every Gallery Block linked to media file', 'jadotheme'),

    ];

    foreach ($media_options as $option => $label) {
        jado_add_settings_field($option_group, 'jado_section_media', $option, $label);
    }

    // Section 2: Gutenberg Settings
    add_settings_section(
        'jado_section_gutenberg',
        __('Gutenberg Settings', 'jadotheme'),
        '',
        'jado_options'
    );

    $gutenberg_options = [
        'gutenberg_full_width' => __('Gutenberg full width', 'jadotheme'),
        'disableGutenbergCustomStyle' => __('Deactivate Gutenberg inline styles', 'jadotheme'),
        'disableEditorFullscreenDefault' => __('Disable Editor Fullscreen Default', 'jadotheme'),
        'customAdminStyle' => __('Better Design for Gutenberg Backend', 'jadotheme')
    ];

    foreach ($gutenberg_options as $option => $label) {
        jado_add_settings_field($option_group, 'jado_section_gutenberg', $option, $label);
    }

    // Section 3: SEO Settings
    add_settings_section(
        'jado_section_seo',
        __('SEO, Security & Performance Settings', 'jadotheme'),
        '',
        'jado_options'
    );

    $seo_options = [
        'disableEmoji' => __('Disable Emoji', 'jadotheme'),
        'removeXMLRPC' => __('Disable XMLRPC', 'jadotheme'),
        'disableEmbedsFrontend' => __('Disable Embeds in Frontend', 'jadotheme'),
        'disableComments' => __('Disable Comments', 'jadotheme'),
        'encodeEmails' => __('Encode emails e.g. <br>[email]email@email.com/email]', 'jadotheme'),
        'heartbeat' => __('Disable heartbeat <br>(auto safe etc.)', 'jadotheme'),
        'scriptW3C' => __('Correct script style (delete type=script)', 'jadotheme'),
        'pageExcerpts' => __('Excerpts for pages (for meta descriptions)', 'jadotheme'),
    ];

    foreach ($seo_options as $option => $label) {
        jado_add_settings_field($option_group, 'jado_section_seo', $option, $label);
    }


    // Section 4: Misc Settings
    add_settings_section(
        'jado_section_misc',
        __('Misc Settings', 'jadotheme'),
        '',
        'jado_options'
    );

    $misc_options = [
        //'deactivateXMLSitemap' => __('Deactivate XML Sitemap', 'jadotheme'),
        'disableAdminBarFrontend' => __('Disable Admin Bar in Frontend', 'jadotheme'),
        'activateJquery' => __('Activate jQuery', 'jadotheme'),
        'editor_role_menu' => __('Give Editors Menu access', 'jadotheme'),
        'maintenanceMode' => __('Activate Maintenance mode', 'jadotheme'),
    ];

    foreach ($misc_options as $option => $label) {
        jado_add_settings_field($option_group, 'jado_section_misc', $option, $label);
    }
}


function jado_add_settings_field($option_group, $section_id, $option, $label)
{
    $sanitize_callback = 'jado_sanitize_checkbox';
    if ($option === 'imgQuality') {
        $sanitize_callback = 'absint';
    }
    register_setting($option_group, $option, ['sanitize_callback' => $sanitize_callback]);

    $callback = "jado_{$option}_field";
    add_settings_field(
        $option,
        __($label, 'jadotheme'),
        $callback,
        'jado_options',
        $section_id,
        array(
            'label_for' => $option,
            'name' => $option
        )
    );
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
        <input type="checkbox"
               name="<?php echo $args['name']; ?>" <?php checked($value, 'yes') ?> /> <?php echo __('Yes', 'jadotheme'); ?>
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

function jado_swiperjs_field($args): void
{
    jado_checkbox_field($args);
}

function jado_baguettebox_field($args): void
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

function jado_customAdminStyle_field($args): void
{
    jado_checkbox_field($args);
}

function jado_pageExcerpts_field($args): void
{
    jado_checkbox_field($args);
}

function jado_maintenanceMode_field($args): void
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


add_action('admin_notices', 'jado_notice');
function jado_notice(): void
{
    if (
        isset($_GET['page'])
        && 'jado_options' == $_GET['page']
        && isset($_GET['settings-updated'])
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


    /** Theeme Full Site Editor */


    $gutenbergFullSiteEditing = get_option('gutenbergFullSiteEditing', 'no');
    if ($gutenbergFullSiteEditing === 'yes') {
        function jst_theme_setup()
        {
            add_theme_support('block-templates');
            add_theme_support( 'block-template-parts' );
        }

        add_action('after_setup_theme', 'jst_theme_setup');
    }






    /**  Give editor role menu access  */
    $editorRoleMenu = get_option('editor_role_menu', 'no');
    if ($editorRoleMenu == 'yes') {
        $role_object = get_role('editor');
        $role_object->add_cap('edit_theme_options');
        function hide_menu(): void
        {
            if (current_user_can('editor')) {
                remove_submenu_page('themes.php', 'themes.php');
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
        add_action('init', 'jado_add_excerpts_to_pages');
        function jado_add_excerpts_to_pages()
        {
            add_post_type_support('page', 'excerpt');
        }
    }


    /** Maintenance Mode **/
    $maintenance = get_option('maintenanceMode', 'no');
    if ($maintenance == 'yes') {
        add_action('template_redirect', 'maintenance_mode');
        function maintenance_mode()
        {
            if (!current_user_can('edit_themes') || !is_user_logged_in()) {
                include get_template_directory() . '/lib/maintenance.php';
                exit;
            }
        }
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

        function remove_type_attributes($tag)
        {
            return preg_replace("/\s*type=['\"]text\/(javascript|css)['\"]/", '', $tag);
        }

        add_filter('script_loader_tag', 'remove_type_attributes');
        add_filter('style_loader_tag', 'remove_type_attributes');
        function buffer_start()
        {
            ob_start('buffer_callback');
        }

        function buffer_end()
        {
            ob_end_flush();
        }

        function buffer_callback($buffer)
        {
            $buffer = preg_replace("/\s*type=['\"]text\/(javascript|css)['\"]/", '', $buffer);
            return $buffer;
        }

        add_action('wp_head', 'buffer_start', 1);
        add_action('wp_footer', 'buffer_end', 1);
        add_action('admin_head', 'buffer_start', 1);
        add_action('admin_footer', 'buffer_end', 1);
    }


    /** Swiper JS Plugin */

    $swiperjs = get_option('swiperjs', 'no');
    if ($swiperjs == 'yes') {
        function register_settings()
        {
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_speed');
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_delay');
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_pagination');
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_navigation');
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_autoplay');
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_lazy');
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_slides_per_view');
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_space_between');
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_effect');
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_navigation_color');
            add_menu_page(
                __('Gallery Settings', 'jadotheme'),
                __('Gallery Settings', 'jadotheme'),
                'manage_options',
                'gallery-swiperjs-settings',
                __NAMESPACE__ . '\settings_page_html',
                'dashicons-images-alt2',
                64
            );
        }

        add_action('admin_menu', __NAMESPACE__ . '\register_settings');

        function settings_page_html()
        {
            if (!current_user_can('manage_options')) {
                return;
            }
            ?>
            <div class="wrap">
                <h1><?php echo _e('Gallery Block SwiperJS Settings', 'jadotheme'); ?> </h1>
                <h3><strong><?php echo _e('Setting options for all gallery blocks that are automatically converted to SwiperJS sliders when this plugin is activated', 'jadotheme'); ?> </strong></h3>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('gallery_swiperjs_options');
                    do_settings_sections('gallery_swiperjs_options');
                    ?>
                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_effect"><?php echo _e('Effect:', 'jadotheme'); ?></label>
                            </th>
                            <td>
                                <select id="gallery_swiperjs_effect" name="gallery_swiperjs_effect">
                                    <option value="slide" <?php selected(get_option('gallery_swiperjs_effect', 'slide'), 'slide'); ?>>
                                        Slide
                                    </option>
                                    <option value="fade" <?php selected(get_option('gallery_swiperjs_effect', 'slide'), 'fade'); ?>>
                                        Fade
                                    </option>
                                    <option value="cube" <?php selected(get_option('gallery_swiperjs_effect', 'slide'), 'cube'); ?>>
                                        Cube
                                    </option>
                                    <option value="coverflow" <?php selected(get_option('gallery_swiperjs_effect', 'slide'), 'coverflow'); ?>>
                                        Coverflow
                                    </option>
                                    <option value="cards" <?php selected(get_option('gallery_swiperjs_effect', 'slide'), 'cards'); ?>>
                                        Cards
                                    </option>
                                    <option value="flip" <?php selected(get_option('gallery_swiperjs_effect', 'slide'), 'flip'); ?>>
                                        Flip
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_speed"><?php echo _e('Speed (in ms):', 'jadotheme'); ?></label>
                            </th>
                            <td><input type="number" id="gallery_swiperjs_speed" name="gallery_swiperjs_speed"
                                       value="<?php echo esc_attr(get_option('gallery_swiperjs_speed', 300)); ?>"/></td>
                        </tr>
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_pagination"><?php echo _e('Enable Pagination:', 'jadotheme'); ?></label>
                            </th>
                            <td><input type="checkbox" id="gallery_swiperjs_pagination"
                                       name="gallery_swiperjs_pagination"
                                       value="1" <?php checked(1, get_option('gallery_swiperjs_pagination', 0)); ?> />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_navigation"><?php echo _e('Enable Navigation:', 'jadotheme'); ?></label>
                            </th>
                            <td><input type="checkbox" id="gallery_swiperjs_navigation"
                                       name="gallery_swiperjs_navigation"
                                       value="1" <?php checked(1, get_option('gallery_swiperjs_navigation', 0)); ?> />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_autoplay"><?php echo _e('Enable Autplay:', 'jadotheme'); ?></label>
                            </th>
                            <td><input type="checkbox" id="gallery_swiperjs_autoplay" name="gallery_swiperjs_autoplay"
                                       value="1" <?php checked(1, get_option('gallery_swiperjs_autoplay', 0)); ?> />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_delay"><?php echo _e('Autoplay Delay (in ms):', 'jadotheme'); ?></label>
                            </th>
                            <td><input type="number" id="gallery_swiperjs_delay" name="gallery_swiperjs_delay"
                                       value="<?php echo esc_attr(get_option('gallery_swiperjs_delay', 3000)); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_slides_per_view"><?php echo _e('Slides per view:', 'jadotheme'); ?></label>
                            </th>
                            <td>
                                <select id="gallery_swiperjs_slides_per_view" name="gallery_swiperjs_slides_per_view">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php selected($i, get_option('gallery_swiperjs_slides_per_view', 1)); ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_space_between"><?php echo _e('Space between Slides (in px):', 'jadotheme'); ?></label>
                            </th>
                            <td><input type="number" id="gallery_swiperjs_space_between"
                                       name="gallery_swiperjs_space_between"
                                       value="<?php echo esc_attr(get_option('gallery_swiperjs_space_between', 0)); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_navigation_color"><?php echo _e('Color for Navigation/Pagniation:', 'jadotheme'); ?></label>
                            </th>
                            <td><input type="text" id="gallery_swiperjs_navigation_color"
                                       name="gallery_swiperjs_navigation_color"
                                       value="<?php echo esc_attr(get_option('gallery_swiperjs_navigation_color', '#000000')); ?>"
                                       class="color-picker"/></td>
                        </tr>
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_lazy"><?php echo _e('Enable Lazyload:', 'jadotheme'); ?></label>
                            </th>
                            <td><input type="checkbox" id="gallery_swiperjs_lazy" name="gallery_swiperjs_lazy"
                                       value="1" <?php checked(1, get_option('gallery_swiperjs_lazy', 0)); ?> /></td>
                        </tr>
                    </table>
                    <?php submit_button(); ?>
                </form>
            </div>
            <?php
        }

        function register_assets()
        {
            wp_register_style('swiperjs-css', get_template_directory_uri() . '/lib/css/swiperjs-min.css', [], '11.1.9');
            wp_register_script('swiperjs', get_template_directory_uri() . '/lib/js/swiperjs-min.js', [], '11.1.9', true);
            $speed = get_option('gallery_swiperjs_speed', 400);
            $delay = get_option('gallery_swiperjs_delay', 5000);
            $pagination = get_option('gallery_swiperjs_pagination', 0);
            $navigation = get_option('gallery_swiperjs_navigation', 0);
            $autoplay = get_option('gallery_swiperjs_autoplay', 0);
            $lazy = get_option('gallery_swiperjs_lazy', 0);
            $slidesPerView = get_option('gallery_swiperjs_slides_per_view', 1);
            $spaceBetween = get_option('gallery_swiperjs_space_between', 0);
            $effect = get_option('gallery_swiperjs_effect', 'slide');
            $navigationColor = esc_attr(get_option('gallery_swiperjs_navigation_color', '#000000'));
            $swiper_options = "
        autoHeight: true,
        loop: true,
        keyboard: {enabled: true,},
        speed: {$speed},
        slidesPerView: {$slidesPerView},
        spaceBetween: {$spaceBetween},
        effect: '$effect',
        hashNavigation: {watchState: true,}
    ";
            if ($autoplay) {
                $swiper_options .= ",
        autoplay: {
            delay: {$delay}
        }
        ";
            } else {
                $swiper_options .= ",
        autoplay: false
        ";
            }
            if ($lazy) {
                $swiper_options .= ",
        lazy: true
        ";
            } else {
                $swiper_options .= ",
        lazy: false
        ";
            }
            $dom_elements = '';
            if ($pagination) {
                $swiper_options .= ",
        pagination: {
            el: '.swiper-pagination'
        }
        ";
                $dom_elements .= "<div class=\'swiper-pagination\'></div>";
            }
            if ($navigation) {
                $swiper_options .= ",
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        }
        ";
                $dom_elements .= "<div class=\'swiper-button-next\'></div><div class=\'swiper-button-prev\'></div>";
            }

            wp_add_inline_style('swiperjs-css', "
        .wp-block-gallery{overflow: hidden; position: relative;}
        .swiper-pagination-bullet-active {
            background-color: {$navigationColor} !important;
        }
        .swiper-button-next, .swiper-button-prev {
            color: {$navigationColor} !important;
        }
    ");

            wp_add_inline_script('swiperjs', "
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swiper !== 'undefined') {
                let galleries = document.querySelectorAll('.wp-block-gallery');
                galleries.forEach(function(gallery) {
                    let images = gallery.querySelectorAll('.blocks-gallery-item, .wp-block-image');
                    if (images.length > 0) {
                        let wrapper = document.createElement('div');
                        wrapper.classList.add('swiper-wrapper');
                        images.forEach(function(image, index) {
                            image.classList.add('swiper-slide');
                            image.setAttribute('data-hash', 'slide' + (index + 1));
                            wrapper.appendChild(image);
                        });
                        gallery.innerHTML = '';
                        gallery.appendChild(wrapper);
                        gallery.insertAdjacentHTML('beforeend', '{$dom_elements}');
                        new Swiper(gallery, {
                            {$swiper_options}
                        });
                    }
                });
            } else {
                console.error('SwiperJS is not loaded or defined.');
            }
        });
    ", 'after');
        }
        add_action('wp_enqueue_scripts', __NAMESPACE__ . '\register_assets');
        function admin_enqueue_scripts($hook) {
            if ($hook === 'toplevel_page_gallery-swiperjs-settings') {
                wp_enqueue_style('wp-color-picker');
                wp_enqueue_script('custom-script', get_template_directory_uri() . '/lib/js/admin-script.js', array('wp-color-picker'), false, true);
                wp_add_inline_script('custom-script', "jQuery(document).ready(function($){ $('.color-picker').wpColorPicker();});");
            }
        }
        add_action('admin_enqueue_scripts', 'admin_enqueue_scripts');

        function enqueue_assets()
        {
            $swiperjs_enqueue_assets = apply_filters('swiperjs_enqueue_assets',
                has_block('core/gallery') ||
                has_block('core/image') ||
                has_block('core/media-text') ||
                get_post_gallery() ||
                has_block('coblocks/gallery-masonry') ||
                has_block('coblocks/gallery-stacked') ||
                has_block('coblocks/gallery-collage') ||
                has_block('coblocks/gallery-offset') ||
                has_block('coblocks/gallery-stacked') ||
                has_block('meow-gallery/gallery') ||
                has_block('generateblocks/image')
            );

            if ($swiperjs_enqueue_assets) {
                wp_enqueue_script('swiperjs');
                wp_enqueue_style('swiperjs-css');
            }
        }

        add_action('wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets');
    }


    /** Baguettebox */

    $baguettebox = get_option('baguettebox', 'no');
    if ($baguettebox == 'yes') {
        function register_b_assets() {
            wp_register_style( 'baguettebox-css', get_template_directory_uri() . '/lib/css/baguetteBox-min.css', [], '1.12.0' );
            wp_register_script( 'baguettebox', get_template_directory_uri() . '/lib/js/baguetteBox-min.js', [], '1.12.0', true );
            $baguettebox_selector = apply_filters( 'baguettebox_selector', '.wp-block-gallery,:not(.wp-block-gallery)>.wp-block-image,.wp-block-media-text__media,.gallery,.wp-block-coblocks-gallery-masonry,.wp-block-coblocks-gallery-stacked,.wp-block-coblocks-gallery-collage,.wp-block-coblocks-gallery-offset,.wp-block-coblocks-gallery-stacked,.mgl-gallery,.gb-block-image' );
            $baguettebox_filter = apply_filters( 'baguettebox_filter',  '/.+\.(gif|jpe?g|png|webp|svg|avif|heif|heic|tif?f|)($|\?)/i' );
            $baguettebox_ignoreclass = apply_filters( 'baguettebox_ignoreclass', 'no-lightbox' );

            wp_add_inline_script( 'baguettebox', 'window.addEventListener("load", function() {baguetteBox.run("' . $baguettebox_selector . '",{captions:function(t){var e=t.parentElement.classList.contains("wp-block-image")||t.parentElement.classList.contains("wp-block-media-text__media")?t.parentElement.querySelector("figcaption"):t.parentElement.parentElement.querySelector("figcaption,dd");return!!e&&e.innerHTML},filter:' . $baguettebox_filter . ',ignoreClass:"' . $baguettebox_ignoreclass . '"});});' );

        }
        add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\register_b_assets' );

        function enqueue_b_assets() {
            $baguettebox_enqueue_b_assets = apply_filters( 'baguettebox_enqueue_b_assets',
                has_block( 'core/gallery' ) ||
                has_block( 'core/image' ) ||
                has_block( 'core/media-text' ) ||
                get_post_gallery() ||
                has_block( 'coblocks/gallery-masonry' ) ||
                has_block( 'coblocks/gallery-stacked' ) ||
                has_block( 'coblocks/gallery-collage' ) ||
                has_block( 'coblocks/gallery-offset' ) ||
                has_block( 'coblocks/gallery-stacked' ) ||
                has_block( 'meow-gallery/gallery' ) ||
                has_block( 'generateblocks/image' )
            );

            if ( $baguettebox_enqueue_b_assets ) {
                wp_enqueue_script( 'baguettebox' );
                wp_enqueue_style( 'baguettebox-css' );
            }
        }
        add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_b_assets' );
    }



    /** Better Gutenberg Styles Admin - NOT WORKING IN WP 6.7 anymore - iframes */
    $customAdminStyle = get_option('customAdminStyle', 'no');
    if ($customAdminStyle == 'yes') {
        add_theme_support('editor-styles');
        add_editor_style('lib/css/editor-styles.css' );

    }

}

add_action('after_setup_theme', 'jado_apply_settings');