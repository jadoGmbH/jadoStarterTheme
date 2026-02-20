<?php
// Menu and Options Page setup
function jado_output_design_custom_properties(): void
{
    $design_fields = [
            'color_dark' => '--color-dark',
            'color_light' => '--color-light',
            'color_main' => '--color-main',
            'color_line' => '--color-line',
            'theme_header_bg' => '--theme-header-bg',
            'theme_header_text' => '--theme-header-text',
            'theme_headline_color' => '--theme-headline-color',
            'theme_content_bg' => '--theme-content-bg',
            'theme_content_text' => '--theme-content-text',
            'theme_footer_bg' => '--theme-footer-bg',
            'theme_footer_text' => '--theme-footer-text',
            'theme_button_bg' => '--theme-button-bg',
            'theme_button_text' => '--theme-button-text',
            'color_link' => '--color-link',
            'color_linkHover' => '--color-linkHover',
            'theme_border_radius' => '--theme-border-radius',
            'theme_topnav_outline' => '--theme-topnav-outline',
            'theme_headline_hyphens' => '--theme-headline-hyphens',
            'theme_text_hyphens' => '--theme-text-hyphens',
            'theme_header_fixed' => '--theme-header-fixed',
            'theme_header_compact' => '--theme-header-compact',
            'theme_show_shadows' => '--theme-show-shadows',
            'theme_margin_bottom' => '--theme-margin-bottom',
            // Neue Variable für die Seiten-Maximalbreite
            'theme_wrap_max_width' => '--theme-wrap-max-width',
    ];

    $styles = "";
    foreach ($design_fields as $option => $css_var) {
        $value = get_option($option);

        if ($option === 'theme_border_radius' || $option === 'theme_margin_bottom' || $option === 'theme_wrap_max_width') {
            // Defaults für px-basierte Variablen
            if ($option === 'theme_border_radius') {
                $default = '0';
            } elseif ($option === 'theme_margin_bottom') {
                $default = '20';
            } else { // theme_wrap_max_width
                $default = '1280';
            }
            $value = ($value === false || $value === '' || $value === null) ? $default : $value;
            $styles .= "  {$css_var}: {$value}px !important;\n";
        } elseif ($option === 'theme_topnav_outline' || $option === 'theme_headline_hyphens' || $option === 'theme_text_hyphens' || $option === 'theme_header_fixed' || $option === 'theme_header_compact' || $option === 'theme_show_shadows') {
            $is_checked = jado_get_checkbox_state($option);

            if ($option === 'theme_topnav_outline') {
                $styles .= "  {$css_var}: " . ($is_checked ? '1px solid var(--color-line)' : 'none') . " !important;\n";
            } elseif ($option === 'theme_header_fixed') {
                $styles .= "  {$css_var}: " . ($is_checked ? 'fixed' : 'scroll') . " !important;\n";
            } elseif ($option === 'theme_header_compact') {
                $styles .= "  {$css_var}: " . ($is_checked ? 'compact' : 'stacked') . " !important;\n";
            } elseif ($option === 'theme_show_shadows') {
                $styles .= "  {$css_var}: " . ($is_checked ? 'rgba(0,0,0,0.1) 0 4px 25px, rgba(0,0,0,0.1) 0 2px 5px' : 'none') . " !important;\n";
            } else {
                $styles .= "  {$css_var}: " . ($is_checked ? 'auto' : 'none') . " !important;\n";
            }
        } elseif ($value !== false && $value !== '' && $value !== null) {
            $styles .= "  {$css_var}: {$value} !important;\n";
        }
    }

    if ($styles !== "" || true) { // Always output if we have defaults
        echo "\n<style id='jado-design-custom-properties'>\n:root, .editor-styles-wrapper {\n{$styles}}\n";
        // Apply hyphens to specific elements based on the variables
        echo "h1, h2, h3, h4, h5, h1 a, h2 a, h3 a, h4 a, h5 a, h1 strong, h2 strong, h3 strong, h4 strong, h5 strong, .sidebar h1, .sidebar h2, .sidebar h3, .sidebar h4, .sidebar h5 { hyphens: var(--theme-headline-hyphens) !important; -webkit-hyphens: var(--theme-headline-hyphens) !important; }\n";
        echo "p, li, strong, .entry-content p, .entry-content li { hyphens: var(--theme-text-hyphens) !important; -webkit-hyphens: var(--theme-text-hyphens) !important; }\n";
        // Force border-radius on elements that might have high specificity or be missed
        if (is_admin()) {
            // Im Backend nur innerhalb des Editors anwenden, um WP-UI Elemente nicht zu beeinflussen
            echo ".editor-styles-wrapper img, .editor-styles-wrapper .wp-block-button__link, .editor-styles-wrapper .wp-block-code, .editor-styles-wrapper .wp-block-verse, .editor-styles-wrapper .wp-block-details, .editor-styles-wrapper .wp-block-table { border-radius: var(--theme-border-radius) !important; }\n";
        } else {
            // Im Frontend auf alle relevanten Elemente anwenden
            echo "#content img, .entry-content img, .nav:not(.top-nav):not(.meta-nav) li, .nav:not(.top-nav):not(.meta-nav) li a, button:not(.header *):not(.footer *), .button:not(.header *):not(.footer *), .wp-block-button__link:not(.header *):not(.footer *), input:not(.header *):not(.footer *), textarea:not(.header *):not(.footer *), .wp-block-code, .wp-block-verse, .post, .cpt, .wp-block-details, .wp-block-table { border-radius: var(--theme-border-radius) !important; }\n";
        }
        // Force TopNav outline/border
        echo ".nav.top-nav li a { border: var(--theme-topnav-outline) !important; }\n";
        // Apply shadows
        echo ".header, #content, .block-editor-iframe__body, .wp-block-details, .wp-block-table { box-shadow: var(--theme-show-shadows) !important; }\n";

        // Apply Footer Colors to Widget Area in Backend
        if (is_admin()) {
            echo "/* Footer Design in Widgets Area Backend */\n";
            echo ".widgets-php .wp-block-widget-area__inner-blocks { background-color: var(--theme-footer-bg) !important; color: var(--theme-footer-text) !important; padding: 20px; }\n";
            // Nur Inhalts-Blöcke (wp-block) auf Footer-Textfarbe setzen – UI bleibt unberührt
            echo ".widgets-php .wp-block, .widgets-php .wp-block * { color: var(--theme-footer-text) !important; }\n";
            // Buttons in Widgets: Farben aus Design-Variablen übernehmen
            echo ".widgets-php .wp-block .wp-block-button__link, .widgets-php .wp-block .wp-element-button { color: var(--theme-button-text) !important; background-color: var(--theme-button-bg) !important; }\n";
            echo ".widgets-php .wp-block input[type='submit'], .widgets-php .wp-block button[type='submit'] { color: var(--theme-button-text) !important; background-color: var(--theme-button-bg) !important; }\n";
            // WordPress UI-Elemente explizit auf Standard zurücksetzen
            echo ".widgets-php .wp-block-widget-area__inner-blocks :is([class*='components-'], .block-editor-block-contextual-toolbar, .block-editor-block-list__block-edit *) { color: initial !important; }\n";
            echo ".widgets-php .editor-styles-wrapper { background-color: var(--theme-footer-bg) !important; }\n";
            echo ".widgets-php .wp-block-widget-area__inner-blocks a { color: var(--theme-footer-text) !important; text-decoration-color: var(--theme-footer-text) !important; }\n";
            // WP UI Buttons (nicht Inhalt): immer Schwarz setzen, nicht Link-Farbe (außer im Header)
            echo ".widgets-php .components-button:not(.edit-widgets-header *), .widgets-php a.components-button:not(.edit-widgets-header *) { color: #1e1e1e !important; }\n";
            echo ".widgets-php .components-button:not(.edit-widgets-header *) svg { fill: #1e1e1e !important; color: #1e1e1e !important; }\n";
            echo ".widgets-php .block-editor-block-contextual-toolbar * { color: initial !important; }\n";
            // .wrap im Backend (z.B. jST Settings) auf 100% Breite halten, nicht durch Frontend-Max-Width begrenzen
            echo "#wpbody-content .wrap { width: 100% !important; max-width: none !important; }\n";
        }

        // Apply global margin-bottom
        echo "#content h1, #content h2, #content h3, #content h4, #content h5, #content p, #content ul, .entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content p, .entry-content ul, .wp-block-columns, .wp-block-image, .wp-block-group, .wp-block-gallery, .wp-block-table, .wp-block-code, .wp-block-verse, .wp-block-details, #content .wp-block-quote, .wp-block-pullquote, .wp-block-cover, .wp-block-media-text { margin-bottom: var(--theme-margin-bottom) !important; }\n";
        // Apply global gap for columns
        echo ".wp-block-columns { gap: var(--theme-margin-bottom) !important; }\n";
        // Maximalbreite der Seite (Wrapper)
        echo ".wrap { max-width: var(--theme-wrap-max-width) !important; }\n";
        // Fixed Header Reset if Option is enabled
        if (jado_get_checkbox_state('theme_header_fixed')) {
            echo "body.scrollDown #fixedHeader.header, body.scrollUp #fixedHeader.header { transform: translate3d(0, 0, 0) !important; transition: none !important; }\n";
        }
        if (jado_get_checkbox_state('theme_header_compact')) {
            echo "#inner-header { flex-direction: row !important; justify-content: space-between !important; align-items: center !important; }\n";
            echo "#inner-header .flex { width: auto !important; margin: 0 !important; }\n";
            echo "#site-navigation { width: auto !important; max-height: none !important; overflow: visible !important; margin: 0 !important; }\n";
            echo ".nav.top-nav { padding-top: 0 !important; margin-top: 0 !important; }\n";
            echo ".nav.top-nav ul { justify-content: flex-end !important; }\n";
            echo "#burger { display: none !important; }\n";
        }
        echo "</style>\n";
    }
}
add_action('wp_head', 'jado_output_design_custom_properties');
add_action('admin_head', 'jado_output_design_custom_properties');

/**
 * Register Webdesign settings in Customizer
 */
function jado_customize_register($wp_customize)
{
    // Add Section Webdesign under Website-Informationen (title_tagline)
    $wp_customize->add_section('jado_section_design', [
            'title' => __('Design', 'jadotheme'),
            'priority' => 30, // Default for title_tagline is 20
            'description' => __('Design Settings (also in jST Settings - without live preview)', 'jadotheme'),
    ]);

    $design_fields = [
            'theme_header_bg' => __('Header Background', 'jadotheme'),
            'theme_header_text' => __('Header Text', 'jadotheme'),
            'color_dark' => __('Active Menu Background', 'jadotheme'),
            'color_light' => __('Active Menu Text', 'jadotheme'),
            'color_line' => __('Outline Menu', 'jadotheme'),
            'theme_content_bg' => __('Content Background', 'jadotheme'),
            'theme_headline_color' => __('Headline', 'jadotheme'),
            'theme_content_text' => __('Content Text', 'jadotheme'),
            'color_link' => __('Link Color', 'jadotheme'),
            'color_linkHover' => __('Link Hover Color', 'jadotheme'),
            'theme_button_bg' => __('Button Background', 'jadotheme'),
            'theme_button_text' => __('Button Text', 'jadotheme'),
            'color_main' => __('Bullet & Quote', 'jadotheme'),
            'theme_footer_bg' => __('Footer Background', 'jadotheme'),
            'theme_footer_text' => __('Footer Text', 'jadotheme'),

    ];

    foreach ($design_fields as $id => $label) {
        $wp_customize->add_setting($id, [
                'type' => 'option', // Save to wp_options to maintain compatibility with existing settings page
                'default' => '',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport' => 'refresh',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, [
                'label' => $label,
                'section' => 'jado_section_design',
                'settings' => $id,
        ]));

        // Wenn das aktuelle Feld "Outline Menu" (color_line) ist, füge die gewünschten Felder danach ein
        if ($id === 'color_line') {

            // TopNav Outline Checkbox
            $wp_customize->add_setting('theme_topnav_outline', [
                    'type' => 'option',
                    'default' => '',
                    'transport' => 'refresh',
                    'sanitize_callback' => 'jado_sanitize_customizer_checkbox',
            ]);
            // Filter the value for the control to be boolean
            add_filter('customize_value_theme_topnav_outline', 'jado_customize_value_checkbox');
            $wp_customize->add_control('theme_topnav_outline', [
                    'label' => __('TopNav Links Outline', 'jadotheme'),
                    'section' => 'jado_section_design',
                    'type' => 'checkbox',
            ]);

            // Wrapper Max-Width Range Control
            $wp_customize->add_setting('theme_wrap_max_width', [
                    'type' => 'option',
                    'default' => '1280',
                    'sanitize_callback' => 'absint',
                    'transport' => 'refresh',
            ]);
            $wp_customize->add_control('theme_wrap_max_width', [
                    'label' => __('Site Content max-width (px)', 'jadotheme'),
                    'section' => 'jado_section_design',
                    'type' => 'range',
                    'input_attrs' => [
                            'min' => 320,
                            'max' => 2560,
                            'step' => 20,
                    ],
            ]);

            // Header Fixed Checkbox
            $wp_customize->add_setting('theme_header_fixed', [
                    'type' => 'option',
                    'default' => '',
                    'transport' => 'refresh',
                    'sanitize_callback' => 'jado_sanitize_customizer_checkbox',
            ]);
            // Filter the value for the control to be boolean
            add_filter('customize_value_theme_header_fixed', 'jado_customize_value_checkbox');
            $wp_customize->add_control('theme_header_fixed', [
                    'label' => __('Header Fixed', 'jadotheme'),
                    'section' => 'jado_section_design',
                    'type' => 'checkbox',
            ]);

            // Header Compact Checkbox
            $wp_customize->add_setting('theme_header_compact', [
                    'type' => 'option',
                    'default' => '',
                    'transport' => 'refresh',
                    'sanitize_callback' => 'jado_sanitize_customizer_checkbox',
            ]);
            // Filter the value for the control to be boolean
            add_filter('customize_value_theme_header_compact', 'jado_customize_value_checkbox');
            $wp_customize->add_control('theme_header_compact', [
                    'label' => __('Header Compact', 'jadotheme'),
                    'section' => 'jado_section_design',
                    'type' => 'checkbox',
            ]);

            // Show Shadows Checkbox
            $wp_customize->add_setting('theme_show_shadows', [
                    'type' => 'option',
                    'default' => 'yes',
                    'transport' => 'refresh',
                    'sanitize_callback' => 'jado_sanitize_customizer_checkbox',
            ]);
            // Filter the value for the control to be boolean
            add_filter('customize_value_theme_show_shadows', 'jado_customize_value_checkbox');
            $wp_customize->add_control('theme_show_shadows', [
                    'label' => __('Show Shadows', 'jadotheme'),
                    'section' => 'jado_section_design',
                    'type' => 'checkbox',
            ]);
        }

        // Headlines Hyphens Auto hinter Headline
        if ($id === 'theme_headline_color') {
            $wp_customize->add_setting('theme_headline_hyphens', [
                    'type' => 'option',
                    'default' => '',
                    'transport' => 'refresh',
                    'sanitize_callback' => 'jado_sanitize_customizer_checkbox',
            ]);
            add_filter('customize_value_theme_headline_hyphens', 'jado_customize_value_checkbox');
            $wp_customize->add_control('theme_headline_hyphens', [
                    'label' => __('Headlines Hyphens Auto', 'jadotheme'),
                    'section' => 'jado_section_design',
                    'type' => 'checkbox',
            ]);
        }

        // Spacing (px) hinter Content Background
        if ($id === 'theme_content_bg') {
            $wp_customize->add_setting('theme_margin_bottom', [
                    'type' => 'option',
                    'default' => '20',
                    'sanitize_callback' => 'absint',
                    'transport' => 'refresh',
            ]);
            $wp_customize->add_control('theme_margin_bottom', [
                    'label' => __('Spacing (px)', 'jadotheme'),
                    'section' => 'jado_section_design',
                    'type' => 'range',
                    'input_attrs' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                    ],
            ]);
        }

        // Text Hyphens Auto hinter Content Text
        if ($id === 'theme_content_text') {
            $wp_customize->add_setting('theme_text_hyphens', [
                    'type' => 'option',
                    'default' => '',
                    'transport' => 'refresh',
                    'sanitize_callback' => 'jado_sanitize_customizer_checkbox',
            ]);
            add_filter('customize_value_theme_text_hyphens', 'jado_customize_value_checkbox');
            $wp_customize->add_control('theme_text_hyphens', [
                    'label' => __('Text Hyphens Auto', 'jadotheme'),
                    'section' => 'jado_section_design',
                    'type' => 'checkbox',
            ]);
        }

        // Border Radius (px) hinter Button Background
        if ($id === 'theme_button_bg') {
            $wp_customize->add_setting('theme_border_radius', [
                    'type' => 'option',
                    'default' => '0',
                    'sanitize_callback' => 'absint',
                    'transport' => 'refresh',
            ]);
            $wp_customize->add_control('theme_border_radius', [
                    'label' => __('Border Radius (px)', 'jadotheme'),
                    'section' => 'jado_section_design',
                    'type' => 'range',
                    'input_attrs' => [
                            'min' => 0,
                            'max' => 50,
                            'step' => 1,
                    ],
            ]);
        }
    }

    // Footer: Copyright anzeigen (Standard: aktiv)
    $wp_customize->add_setting('theme_show_copyright', [
            'type' => 'option',
            'default' => 'yes', // standardmäßig angeklickt
            'transport' => 'refresh',
            'sanitize_callback' => 'jado_sanitize_customizer_checkbox',
    ]);
    // Filter für korrekte Checkbox-Anzeige (true/false)
    add_filter('customize_value_theme_show_copyright', 'jado_customize_value_checkbox');
    $wp_customize->add_control('theme_show_copyright', [
            'label' => __('Show Copyright in Footer', 'jadotheme'),
            'section' => 'jado_section_design',
            'type' => 'checkbox',
    ]);
}
add_action('customize_register', 'jado_customize_register');

/**
 * Zusatz: Logo-Upload in "Website-Informationen" (Site Identity)
 * – getrennt vom Favicon und NICHT unter "Webdesign".
 *
 * Speichert die Bild-URL als Option 'jado_site_logo'.
 */
function jado_customize_site_identity_logo($wp_customize): void
{
    // Setting für Logo (URL)
    $wp_customize->add_setting('jado_site_logo', [
            'type' => 'option',
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'refresh',
    ]);

    // Image-Control in der Standard-Section "Website-Informationen" (title_tagline)
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'jado_site_logo', [
            'label' => __('Logo', 'jadotheme'),
            'description' => __('Upload Logo', 'jadotheme'),
            'section' => 'title_tagline',
            'settings' => 'jado_site_logo',
    ]));

    // Checkbox: Site Title anzeigen (Standard: aktiv)
    $wp_customize->add_setting('jado_keep_site_title', [
            'type' => 'option',
            'default' => 'yes', // standardmäßig angeklickt
            'sanitize_callback' => 'jado_sanitize_customizer_checkbox',
            'transport' => 'refresh',
    ]);

    // Damit der Haken im Customizer korrekt angezeigt wird (true/false)
    add_filter('customize_value_jado_keep_site_title', 'jado_customize_value_checkbox');

    $wp_customize->add_control('jado_keep_site_title', [
            'label' => __('Show Site Title', 'jadotheme'),
            //'description' => __('If deactivated, site title is hidden', 'jadotheme'),
            'section' => 'title_tagline',
            'type' => 'checkbox',
    ]);

    // Checkbox: Site Description anzeigen (Standard: aktiv)
    $wp_customize->add_setting('jado_show_description', [
            'type' => 'option',
            'default' => 'yes', // standardmäßig angeklickt
            'sanitize_callback' => 'jado_sanitize_customizer_checkbox',
            'transport' => 'refresh',
    ]);

    // Damit der Haken im Customizer korrekt angezeigt wird (true/false)
    add_filter('customize_value_jado_show_description', 'jado_customize_value_checkbox');

    $wp_customize->add_control('jado_show_description', [
            'label' => __('Show Description title', 'jadotheme'),
            //'description' => __('If deactivated, site description is hidden', 'jadotheme'),
            'section' => 'title_tagline',
            'type' => 'checkbox',
    ]);
}
// Etwas später als die Core-Registrierung ausführen, damit die Section sicher vorhanden ist
add_action('customize_register', 'jado_customize_site_identity_logo', 11);

/**
 * Zeigt die aktuellen Werte der Range-Slider direkt im Label in Klammern an (z. B. "(1280 px)").
 * Gilt für: Border Radius, Spacing, Site Content max-width.
 * Läuft ausschließlich im Customizer-Controls-Frame.
 */
function jado_customize_dynamic_labels_script(): void
{
    // Hinweis: Kein vorzeitiges Return per is_admin().
    // In einigen Setups kann is_admin() im Customizer-Controls-Frame unerwartet false sein.
    // Der folgende Inline-Script-Block prüft selbst auf wp.customize und arbeitet nur dort.
    ?>
    <script>
        (function () {
            // Wartet, bis das Customizer-Controls-DOM bereit ist
            function onReady(fn){
                if (document.readyState === 'complete' || document.readyState === 'interactive') {
                    setTimeout(fn, 0);
                } else {
                    document.addEventListener('DOMContentLoaded', fn);
                }
            }

            onReady(function(){
                // Nur im Customizer-Controls-Fenster ausführen
                if (!(window.wp && wp.customize)) return;
                var targets = [
                    { id: 'theme_border_radius', unit: 'px' },
                    { id: 'theme_margin_bottom', unit: 'px' },
                    { id: 'theme_wrap_max_width', unit: 'px' }
                ];

                function updateTitle(titleEl, value, unit){
                    if (!titleEl) return;
                    // Basis-Titel nur einmal merken (ohne evtl. vorhandene Klammern)
                    if (!titleEl.dataset.baseTitle) {
                        titleEl.dataset.baseTitle = (titleEl.textContent || '')
                            .replace(/\s*\(.*\)\s*$/, '')
                            .trim();
                    }
                    var base = titleEl.dataset.baseTitle || '';
                    titleEl.textContent = base + ' (' + value + ' ' + unit + ')';
                }

                function wireControl(target){
                    var wrap = document.getElementById('customize-control-' + target.id);
                    if (!wrap) return;
                    var input = wrap.querySelector('input[type="range"]');
                    var titleEl = wrap.querySelector('.customize-control-title');
                    if (!input || !titleEl) return;

                    // Initial setzen
                    updateTitle(titleEl, input.value, target.unit);

                    // Beim Schieben aktualisieren
                    input.addEventListener('input', function(ev){
                        updateTitle(titleEl, ev.target.value, target.unit);
                    });

                    // Auch auf programmatische Änderungen durch den Customizer reagieren
                    if (window.wp && wp.customize) {
                        wp.customize(target.id, function(setting){
                            setting.bind(function(val){
                                updateTitle(titleEl, val, target.unit);
                            });
                        });
                    }
                }

                targets.forEach(wireControl);
            });
        })();
    </script>
    <?php
}
add_action('customize_controls_print_footer_scripts', 'jado_customize_dynamic_labels_script');

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
        document.addEventListener('DOMContentLoaded', function () {
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

function jado_initialize_options(): void
{

    $business_info_options = [
            'business_street',
            'business_postal_code',
            'business_city',
            'business_country',
            'business_contactsite',
            'business_areaserved',
            'business_languages',
            'business_telephone',
            'business_email',
            'business_whatsapp',
            'business_foundingdate',
            'business_linkedin',
            'business_bluesky',
            'business_youtube',
            'business_mastodon',
            'business_facebook',
            'business_instagram',
            'business_googlemaps',
            'business_show_social_footer',
    ];

    $design_options = [
            'color_dark',
            'color_light',
            'color_main',
            'color_line',
            'theme_header_bg',
            'theme_header_text',
            'theme_content_bg',
            'theme_headline_color',
            'theme_content_text',
            'theme_footer_bg',
            'theme_footer_text',
            'theme_button_bg',
            'theme_button_text',
            'color_link',
            'color_linkHover',
            'theme_border_radius',
            'theme_wrap_max_width',
            'theme_topnav_outline',
            'theme_headline_hyphens',
            'theme_text_hyphens',
            'theme_header_fixed',
            'theme_header_compact',
            'theme_show_shadows',
            'theme_margin_bottom'
    ];

    $all_options = array_merge($business_info_options, $design_options);

    foreach ($all_options as $option) {
        $default = '';
        if ($option === 'theme_border_radius') {
            $default = '0';
        } elseif ($option === 'theme_margin_bottom') {
            $default = '20';
        } elseif ($option === 'theme_wrap_max_width') {
            $default = '1280';
        } elseif ($option === 'theme_show_shadows') {
            $default = 'yes';
        }

        if (get_option($option) === false) {
            add_option($option, $default);
        }
    }

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
            'hideWPUser',
            'permissionPolicyHeader',
            'referrerHeaderPolicy',
            'crossOriginRessourcePolicy',
            'crossOriginOpenPolicy',
            'xFrameOptionsHeader',
            'xxssProtection',
            'xContentTypeOptions',
            'strictTransportSecurity',
            'delayLoginAttempts',
            'cacheControlHeader',
            'scriptW3C',
            'swiperjs',
            'baguettebox',
            'pageExcerpts',
            'maintenanceMode',
            'disableAdminBarFrontend',
            'activateJquery',
            'editor_role_menu'
    ];

    foreach ($options as $option) {
        $default_value = ($option === 'imgQuality') ? 74 : 'no';
        if (get_option($option) === false) {
            add_option($option, $default_value);
        }
    }
}
add_action('after_setup_theme', 'jado_initialize_options');

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
            'disableGutenbergCustomStyle' => __('Deactivate Gutenberg inline styles - they are already loaded by jST', 'jadotheme'),
            'disableEditorFullscreenDefault' => __('Disable Editor Fullscreen Default', 'jadotheme'),
            'customAdminStyle' => __('Design for Gutenberg Backend', 'jadotheme')
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
            'encodeEmails' => __('Encode emails e.g. [email]email@email.com/email]', 'jadotheme'),
            'heartbeat' => __('Disable heartbeat (auto safe etc.)', 'jadotheme'),
            'scriptW3C' => __('Correct script style (delete type=script)', 'jadotheme'),
            'pageExcerpts' => __('Excerpts for pages (for meta descriptions)', 'jadotheme'),
            'hideWPUser' => __('Hide WP User in Code', 'jadotheme'),
            'permissionPolicyHeader' => __('Add permission policy header (disallow: geolocation, microphone, camera)', 'jadotheme'),
            'referrerHeaderPolicy' => __('Add referrer policy header', 'jadotheme'),
            'crossOriginRessourcePolicy' => __('Add cross origin ressource policy header (same-origin)', 'jadotheme'),
            'crossOriginOpenPolicy' => __('Add cross origin opener policy header (same-origin)', 'jadotheme'),
            'xFrameOptionsHeader' => __('Add x-frame options header (same-origin)', 'jadotheme'),
            'xxssProtection' => __('X-XSS-Protection (mode block)', 'jadotheme'),
            'xContentTypeOptions' => __('X-Content-Type-Options (no sniff)', 'jadotheme'),
            'strictTransportSecurity' => __('Strict-Transport-Security (max-age=31536000; includeSubDomains; preload)', 'jadotheme'),
            'delayLoginAttempts' => __('Delay login attempts (30s)', 'jadotheme'),
            'cacheControlHeader' => __('Set cache for 1 day (not for logged in users)', 'jadotheme'),
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

    // Section 5: Business Information
    add_settings_section(
            'jado_section_business',
            __('Business Information – Social media Icons and LD+JSON (SEO)', 'jadotheme'),
            '',
            'jado_options'
    );

    $business_fields = [
            'business_street' => __('Street and Number', 'jadotheme'),
            'business_postal_code' => __('Postal Code', 'jadotheme'),
            'business_city' => __('City', 'jadotheme'),
            'business_country' => __('Country (2-digit code, e.g. DE)', 'jadotheme'),
            'business_contactsite' => __('Contact Site (URL)', 'jadotheme'),
            'business_areaserved' => __('Area Served (e.g. DE, UK, PT)', 'jadotheme'),
            'business_languages' => __('Spoken Languages (e.g. DE, EN)', 'jadotheme'),
            'business_foundingdate' => __('Founding Date (e.g.: 2011)', 'jadotheme'),
            'business_telephone' => __('Telephone (e.g.: +49 1234 56789)', 'jadotheme'),
            'business_email' => __('Email address (e.g.: info@example.com)', 'jadotheme'),
            'business_whatsapp' => __('WhatsApp number (e.g.: +49123456789)', 'jadotheme'),
            'business_linkedin' => __('Linkedin (URL)', 'jadotheme'),
            'business_bluesky' => __('Bluesky (URL)', 'jadotheme'),
            'business_youtube' => __('Youtube (URL)', 'jadotheme'),
            'business_mastodon' => __('Mastodon (URL)', 'jadotheme'),
            'business_facebook' => __('Facebook (URL)', 'jadotheme'),
            'business_instagram' => __('Instagram (URL)', 'jadotheme'),
            'business_googlemaps' => __('Google Maps (URL)', 'jadotheme'),
    ];

    register_setting($option_group, 'business_show_social_footer', ['sanitize_callback' => 'jado_sanitize_checkbox']);
    add_settings_field(
            'business_show_social_footer',
            __('Show Social Media Icons in Footer', 'jadotheme'),
            'jado_checkbox_field',
            'jado_options',
            'jado_section_business',
            [
                    'label_for' => 'business_show_social_footer',
                    'name' => 'business_show_social_footer'
            ]
    );


    foreach ($business_fields as $option => $label) {
        register_setting($option_group, $option, ['sanitize_callback' => 'sanitize_text_field']);
        add_settings_field(
                $option,
                $label,
                'jado_text_field_callback',
                'jado_options',
                'jado_section_business',
                [
                        'label_for' => $option,
                        'name' => $option
                ]
        );
    }

    // Section 6: Webdesign Settings
    add_settings_section(
            'jado_section_design',
            __('Design', 'jadotheme') . ' – <a href="' . admin_url('customize.php?autofocus[section]=jado_section_design') . '">' . __('Live-Vorschau im Customizer', 'jadotheme') . '</a>',
            '',
            'jado_options'
    );

    $design_fields = [
            'theme_header_bg' => __('Header Background', 'jadotheme'),
            'theme_header_text' => __('Header Text', 'jadotheme'),
            'color_dark' => __('Active Menu Background', 'jadotheme'),
            'color_light' => __('Active Menu Text', 'jadotheme'),
            'color_line' => __('Outline Menu', 'jadotheme'),
            'theme_headline_color' => __('Headline Color', 'jadotheme'),
            'color_main' => __('Bullet & Quote', 'jadotheme'),
            'theme_content_bg' => __('Content Background', 'jadotheme'),
            'theme_content_text' => __('Content Text', 'jadotheme'),
            'theme_footer_bg' => __('Footer Background', 'jadotheme'),
            'theme_footer_text' => __('Footer Text', 'jadotheme'),
            'theme_button_bg' => __('Button Background', 'jadotheme'),
            'theme_button_text' => __('Button Text', 'jadotheme'),
            'color_link' => __('Link Color', 'jadotheme'),
            'color_linkHover' => __('Link Hover Color', 'jadotheme'),
    ];

    foreach ($design_fields as $option => $label) {
        register_setting($option_group, $option, ['sanitize_callback' => 'sanitize_hex_color']);
        add_settings_field(
                $option,
                $label,
                'jado_color_field_callback',
                'jado_options',
                'jado_section_design',
                [
                        'label_for' => $option,
                        'name' => $option
                ]
        );

        // TopNav Outline hinter Outline Menu (color_line)
        if ($option === 'color_line') {
            register_setting($option_group, 'theme_topnav_outline', ['sanitize_callback' => 'jado_sanitize_checkbox']);
            add_settings_field(
                    'theme_topnav_outline',
                    __('TopNav Links Outline', 'jadotheme'),
                    'jado_checkbox_field',
                    'jado_options',
                    'jado_section_design',
                    [
                            'label_for' => 'theme_topnav_outline',
                            'name' => 'theme_topnav_outline'
                    ]
            );
        }

        // Headline Hyphens hinter Headline Color
        if ($option === 'theme_headline_color') {
            register_setting($option_group, 'theme_headline_hyphens', ['sanitize_callback' => 'jado_sanitize_checkbox']);
            add_settings_field(
                    'theme_headline_hyphens',
                    __('Headlines Hyphens Auto', 'jadotheme'),
                    'jado_checkbox_field',
                    'jado_options',
                    'jado_section_design',
                    [
                            'label_for' => 'theme_headline_hyphens',
                            'name' => 'theme_headline_hyphens'
                    ]
            );
        }

        // Spacing hinter Content Background
        if ($option === 'theme_content_bg') {
            register_setting($option_group, 'theme_margin_bottom', ['sanitize_callback' => 'absint']);
            add_settings_field(
                    'theme_margin_bottom',
                    __('Spacing (px)', 'jadotheme'),
                    'jado_range_field_callback',
                    'jado_options',
                    'jado_section_design',
                    [
                            'label_for' => 'theme_margin_bottom',
                            'name' => 'theme_margin_bottom',
                            'min' => 0,
                            'max' => 100
                    ]
            );
        }

        // Text Hyphens hinter Content Text
        if ($option === 'theme_content_text') {
            register_setting($option_group, 'theme_text_hyphens', ['sanitize_callback' => 'jado_sanitize_checkbox']);
            add_settings_field(
                    'theme_text_hyphens',
                    __('Text Hyphens Auto', 'jadotheme'),
                    'jado_checkbox_field',
                    'jado_options',
                    'jado_section_design',
                    [
                            'label_for' => 'theme_text_hyphens',
                            'name' => 'theme_text_hyphens'
                    ]
            );
        }

        // Border Radius hinter Button Background
        if ($option === 'theme_button_bg') {
            register_setting($option_group, 'theme_border_radius', ['sanitize_callback' => 'absint']);
            add_settings_field(
                    'theme_border_radius',
                    __('Border Radius (px)', 'jadotheme'),
                    'jado_range_field_callback',
                    'jado_options',
                    'jado_section_design',
                    [
                            'label_for' => 'theme_border_radius',
                            'name' => 'theme_border_radius',
                            'min' => 0,
                            'max' => 50
                    ]
            );
        }
    }

    // Site Content max-width Range
    register_setting($option_group, 'theme_wrap_max_width', ['sanitize_callback' => 'absint']);
    add_settings_field(
            'theme_wrap_max_width',
            __('Site Content max-width (px)', 'jadotheme'),
            'jado_range_field_callback',
            'jado_options',
            'jado_section_design',
            [
                    'label_for' => 'theme_wrap_max_width',
                    'name' => 'theme_wrap_max_width',
                    'min' => 320,
                    'max' => 2560,
                    'step' => 20
            ]
    );

    // Header Fixed
    register_setting($option_group, 'theme_header_fixed', ['sanitize_callback' => 'jado_sanitize_checkbox']);
    add_settings_field(
            'theme_header_fixed',
            __('Header Fixed', 'jadotheme'),
            'jado_checkbox_field',
            'jado_options',
            'jado_section_design',
            [
                    'label_for' => 'theme_header_fixed',
                    'name' => 'theme_header_fixed'
            ]
    );

    // Header Compact
    register_setting($option_group, 'theme_header_compact', ['sanitize_callback' => 'jado_sanitize_checkbox']);
    add_settings_field(
            'theme_header_compact',
            __('Header Compact', 'jadotheme'),
            'jado_checkbox_field',
            'jado_options',
            'jado_section_design',
            [
                    'label_for' => 'theme_header_compact',
                    'name' => 'theme_header_compact'
            ]
    );

    // Show Shadows
    register_setting($option_group, 'theme_show_shadows', ['sanitize_callback' => 'jado_sanitize_checkbox']);
    add_settings_field(
            'theme_show_shadows',
            __('Show Shadows', 'jadotheme'),
            'jado_checkbox_field',
            'jado_options',
            'jado_section_design',
            [
                    'label_for' => 'theme_show_shadows',
                    'name' => 'theme_show_shadows'
            ]
    );

    function jado_checkbox_field_callback($args)
    {
        $option = get_option($args['name'], '');
        $is_checked = ($option === '1' || $option === 'yes' || $option === 1 || $option === true);
        ?>
        <input type="checkbox" id="<?php echo esc_attr($args['name']); ?>" name="<?php echo esc_attr($args['name']); ?>"
               value="1" <?php checked($is_checked, true); ?> />
        <label for="<?php echo esc_attr($args['name']); ?>"><?php esc_html_e('Yes', 'jadotheme'); ?></label>
        <?php
    }
}

function jado_text_field_callback($args): void
{
    $value = esc_attr(get_option($args['name'], ''));
    printf(
            '<input type="text" id="%1$s" name="%1$s" value="%2$s" class="regular-text" />',
            $args['name'],
            $value
    );
}

function jado_color_field_callback($args): void
{
    $value = esc_attr(get_option($args['name'], ''));
    printf(
            '<input type="text" id="%1$s" name="%1$s" value="%2$s" class="jado-color-field" />',
            $args['name'],
            $value
    );
}

function jado_range_field_callback($args): void
{
    $value = get_option($args['name'], 0);
    $min = isset($args['min']) ? $args['min'] : 0;
    $max = isset($args['max']) ? $args['max'] : 100;
    $step = isset($args['step']) ? $args['step'] : 1;
    printf(
            '<input type="range" id="%1$s" name="%1$s" value="%2$s" min="%3$s" max="%4$s" step="%5$s" oninput="this.nextElementSibling.value = this.value" /> <output>%2$s</output> px',
            $args['name'],
            $value,
            $min,
            $max,
            $step
    );
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
    if ($value === '1' || $value === 1 || $value === 'on' || $value === true || $value === 'yes') {
        return 'yes';
    }
    return 'no';
}

/**
 * Sanitize checkbox for Customizer
 * Customizer checkbox expects a boolean or 1/0, but we store 'yes'/'no' for consistency
 */
function jado_sanitize_customizer_checkbox($value)
{
    return ($value === true || $value === '1' || $value === 1 || $value === 'yes') ? 'yes' : 'no';
}

/**
 * Ensures that checkboxes in the Customizer show the correct state
 */
function jado_customize_value_checkbox($value)
{
    // Special handling for theme_show_shadows which is true by default
    if (($value === '' || $value === false || $value === null) && str_contains(current_filter(), 'theme_show_shadows')) {
        return true;
    }
    return ($value === 'yes' || $value === '1' || $value === 1 || $value === true) ? true : false;
}

/**
 * Ensures that checkboxes show the correct state
 */
function jado_get_checkbox_state($option_name)
{
    $value = get_option($option_name);

    // Default states
    if ($value === false || $value === '' || $value === null) {
        if ($option_name === 'theme_show_shadows') {
            return true;
        }
        return false;
    }

    return ($value === 'yes' || $value === '1' || $value === 1 || $value === true);
}

// Field Callback functions
function jado_checkbox_field($args): void
{
    $is_checked = jado_get_checkbox_state($args['name']);
    ?>
    <label>
        <input type="checkbox"
               name="<?php echo esc_attr($args['name']); ?>" value="1" <?php checked($is_checked, true) ?> /> <?php echo __('Yes', 'jadotheme'); ?>
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


function jado_hideWPUser_field($args): void
{
    jado_checkbox_field($args);
}

function jado_permissionPolicyHeader_field($args): void
{
    jado_checkbox_field($args);
}

function jado_referrerHeaderPolicy_field($args): void
{
    jado_checkbox_field($args);
}

function jado_crossOriginRessourcePolicy_field($args): void
{
    jado_checkbox_field($args);
}

function jado_crossOriginOpenPolicy_field($args): void
{
    jado_checkbox_field($args);
}

function jado_xFrameOptionsHeader_field($args): void
{
    jado_checkbox_field($args);
}

function jado_xxssProtection_field($args): void
{
    jado_checkbox_field($args);
}

function jado_xContentTypeOptions_field($args): void
{
    jado_checkbox_field($args);
}

function jado_strictTransportSecurity_field($args): void
{
    jado_checkbox_field($args);
}

function jado_delayLoginAttempts_field($args): void
{
    jado_checkbox_field($args);
}

function jado_cacheControlHeader_field($args): void
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
    if (jado_get_checkbox_state('gutenberg_full_width')) {
        add_theme_support('align-wide');
    }


    /** Theeme Full Site Editor */


    $gutenbergFullSiteEditing = get_option('gutenbergFullSiteEditing', '');
    if ($gutenbergFullSiteEditing === 'yes') {
        function jst_theme_setup()
        {
            add_theme_support('block-templates');
            add_theme_support('block-template-parts');
        }

        add_action('after_setup_theme', 'jst_theme_setup');
    }


    /**  Give editor role menu access  */
    if (jado_get_checkbox_state('editor_role_menu')) {
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
    if (jado_get_checkbox_state('disableEmoji')) {
        function disable_emojis()
        {
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('admin_print_scripts', 'print_emoji_detection_script');
            remove_action('wp_print_styles', 'print_emoji_styles');
            remove_action('admin_print_styles', 'print_emoji_styles');
            remove_filter('the_content_feed', 'wp_staticize_emoji');
            remove_filter('comment_text_rss', 'wp_staticize_emoji');
            remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
            add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
        }

        add_action('init', 'disable_emojis');

        function disable_emojis_tinymce($plugins)
        {
            if (is_array($plugins)) {
                return array_diff($plugins, array('wpemoji'));
            } else {
                return array();
            }
        }
    }


    /** Enable Admin Post Thumbnail on backend  */
    if (jado_get_checkbox_state('AdminPostThumbnail')) {
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
    if (jado_get_checkbox_state('removeXMLRPC')) {
        function remove_xmlrpc_methods($methods): array
        {
            return array();
        }

        add_filter('xmlrpc_methods', 'remove_xmlrpc_methods');
    }


    /** disable admin fullscreen mode default */
    if (jado_get_checkbox_state('disableEditorFullscreenDefault')) {
        function jado_disable_editor_fullscreen(): void
        {
            $script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
            wp_add_inline_script('wp-blocks', $script);
        }

        add_action('enqueue_block_editor_assets', 'jado_disable_editor_fullscreen');
    }

    /** enable SVG upload  */
    if (jado_get_checkbox_state('enableSVGUploads')) {
        function ja_myme_types($mime_types)
        {
            $mime_types['svg'] = 'image/svg+xml';
            return $mime_types;
        }

        add_filter('upload_mimes', 'ja_myme_types', 1, 1);
    }

    /** disable admin bar frontend */
    if (jado_get_checkbox_state('disableAdminBarFrontend')) {
        add_filter('show_admin_bar', '__return_false');
    }


    /** disable embeds  */
    if (jado_get_checkbox_state('disableEmbedsFrontend')) {
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
    if (jado_get_checkbox_state('disableGutenbergCustomStyle')) {
        function disable_gutenberg_custom_enqueue_scripts(): void
        {
            wp_dequeue_style('global-styles');
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
        }

        add_filter('wp_enqueue_scripts', 'disable_gutenberg_custom_enqueue_scripts', 100);
    }


    /** Set alt-attr on upload image */
    if (jado_get_checkbox_state('setAltAttrImage')) {
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
    if (jado_get_checkbox_state('disableComments')) {
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
    if (jado_get_checkbox_state('encodeEmails')) {
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
    if (jado_get_checkbox_state('heartbeat')) {
        add_action('init', 'stop_heartbeat', 1);
        function stop_heartbeat(): void
        {
            wp_deregister_script('heartbeat');
        }
    }

    /** activate jQuery */
    if (jado_get_checkbox_state('activateJquery')) {
        function load_scripts(): void
        {
            wp_enqueue_script('jquery');
        }

        add_action('wp_enqueue_scripts', 'load_scripts');
    }


    /** excerpt for pages */
    if (jado_get_checkbox_state('pageExcerpts')) {
        add_action('init', 'jado_add_excerpts_to_pages');
        function jado_add_excerpts_to_pages()
        {
            add_post_type_support('page', 'excerpt');
        }
    }


    /** Hide WP Users  */
    if (jado_get_checkbox_state('hideWPUser')) {
        function block_author_enumeration()
        {
            if (is_admin()) {
                return;
            }
            if (isset($_GET['author'])) {
                wp_redirect(home_url());
                exit;
            }
        }

        add_action('init', 'block_author_enumeration');
        function disable_json_user_enumeration($endpoints)
        {
            if (isset($endpoints['/wp/v2/users'])) {
                unset($endpoints['/wp/v2/users']);
            }
            return $endpoints;
        }

        add_filter('rest_endpoints', 'disable_json_user_enumeration');
    }


    add_action('init', 'register_custom_security_headers');

    function register_custom_security_headers()
    {

    /** Permission-Policy-Header */
    if (get_option('permissionPolicyHeader', '') === 'yes') {
        add_filter('wp_headers', 'set_permissions_policy_header');
    }

    /** Referrer-Header-Policy */
    if (get_option('referrerHeaderPolicy', '') === 'yes') {
        add_filter('wp_headers', 'set_referrer_policy');
    }

    /** Cross-Origin-Resource-Policy */
    if (get_option('crossOriginRessourcePolicy', '') === 'yes') {
        add_filter('wp_headers', 'set_corp_header');
    }

    /** Cross-Origin-Open-Policy */
    if (get_option('crossOriginOpenPolicy', '') === 'yes') {
        add_filter('wp_headers', 'set_coop_header');
        add_filter('wp_headers', 'set_coep_header');
    }

    /** X-Frame-Options-Header */
    if (get_option('xFrameOptionsHeader', '') === 'yes') {
        add_filter('wp_headers', 'set_x_frame_options');
    }

    /** X-XSS-Protection */
    if (get_option('xxssProtection', '') === 'yes') {
        add_filter('wp_headers', 'set_x_xss_protection');
    }

    /** X-Content-Type-Options */
    if (get_option('xContentTypeOptions', '') === 'yes') {
        add_filter('wp_headers', 'set_x_content_type_options');
    }

    /** Strict-Transport-Security */
    if (get_option('strictTransportSecurity', '') === 'yes') {
        add_filter('wp_headers', 'set_hsts_header');
    }
    }


    /** Permission-Policy-Header */
    $permissionPolicyHeader = get_option('permissionPolicyHeader', '');
    if ($permissionPolicyHeader == 'yes') {
        function set_permissions_policy_header($headers)
        {
            $headers['Permissions-Policy'] = 'geolocation=(), microphone=(), camera=()';
            return $headers;
        }
    }


    /** Referrer-Header-Policy */
    $referrerHeaderPolicy = get_option('referrerHeaderPolicy', '');
    if ($referrerHeaderPolicy == 'yes') {
        function set_referrer_policy($headers)
        {
            $headers['Referrer-Policy'] = 'strict-origin-when-cross-origin';
            return $headers;
        }
    }

    /** Cross-Origin-Resource-Policy */
    $crossOriginRessourcePolicy = get_option('crossOriginRessourcePolicy', '');
    if ($crossOriginRessourcePolicy == 'yes') {
        function set_corp_header($headers)
        {
            $headers['Cross-Origin-Resource-Policy'] = 'same-origin';
            return $headers;
        }
    }

    /** Cross-Origin-Open-Policy */
    $crossOriginOpenPolicy = get_option('crossOriginOpenPolicy', '');
    if ($crossOriginOpenPolicy == 'yes') {
        function set_coop_header($headers)
        {
            $headers['Cross-Origin-Opener-Policy'] = 'same-origin';
            return $headers;
        }

        function set_coep_header($headers)
        {
            $headers['Cross-Origin-Embedder-Policy'] = 'require-corp';
            return $headers;
        }
    }


    /** X-Frame-Options-Header - iFrames on other Sites */
    $xFrameOptionsHeader = get_option('xFrameOptionsHeader', '');
    if ($xFrameOptionsHeader == 'yes') {
        function set_x_frame_options($headers)
        {
            $headers['X-Frame-Options'] = 'SAMEORIGIN';
            return $headers;
        }
    }

    /** X-XSS-Protection */
    $xxssProtection = get_option('xxssProtection', '');
    if ($xxssProtection == 'yes') {
        function set_x_xss_protection($headers)
        {
            $headers['X-XSS-Protection'] = '1; mode=block';
            return $headers;
        }
    }

    /** X-Content-Type-Options */
    $xContentTypeOptions = get_option('xContentTypeOptions', '');
    if ($xContentTypeOptions == 'yes') {
        function set_x_content_type_options($headers)
        {
            $headers['X-Content-Type-Options'] = 'nosniff';
            return $headers;
        }
    }

    /** Strict-Transport-Security */
    $strictTransportSecurity = get_option('strictTransportSecurity', '');
    if ($strictTransportSecurity == 'yes') {
        function set_hsts_header($headers)
        {
            if (is_ssl()) {
                $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains; preload';
            }
            return $headers;
        }
    }

    /** Delay between login attempts */
    $delayLoginAttempts = get_option('delayLoginAttempts', '');
    if ($delayLoginAttempts == 'yes') {
        function custom_login_delay()
        {
            sleep(30);
        }

        add_action('wp_login_failed', 'custom_login_delay');
    }


    /** Cache Control Header  */
    $cacheControlHeader = get_option('cacheControlHeader', '');
    if ($cacheControlHeader == 'yes') {
        add_action('send_headers', 'custom_cache_control_header');
        function custom_cache_control_header()
        {
            if (!is_user_logged_in()) {
                header('Cache-Control: public, max-age=86400');
            } else {
                header('Cache-Control: no-cache, must-revalidate, max-age=0');
            }
        }

        add_action('save_post', 'custom_invalidate_cache_on_save', 10, 3);
        function custom_invalidate_cache_on_save($post_ID, $post, $update)
        {
            if (function_exists('wp_cache_clear_cache')) {
                wp_cache_clear_cache();
            }
        }
    }


    /** maintenance mode  */
    if (jado_get_checkbox_state('maintenanceMode')) {
        add_action('template_redirect', 'maintenance_mode');
        function maintenance_mode()
        {
            if (!is_user_logged_in()) {
                include get_template_directory() . '/lib/maintenance.php';
                exit;
            }
        }
    }


    /** Script style W3C-Correct */
    if (jado_get_checkbox_state('scriptW3C')) {
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
            if (ob_get_level() > 0) {
                ob_end_flush();
            }
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

    if (jado_get_checkbox_state('swiperjs')) {
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
            register_setting('gallery_swiperjs_options', 'gallery_swiperjs_hash_navigation');
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
                <h3>
                    <strong><?php echo _e('Setting options for all gallery blocks that are automatically converted to SwiperJS sliders when this plugin is activated', 'jadotheme'); ?> </strong>
                </h3>
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
                        <tr>
                            <th scope="row"><label
                                        for="gallery_swiperjs_hash_navigation"><?php echo _e('Enable #Hash in URL', 'jadotheme'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" id="gallery_swiperjs_hash_navigation"
                                       name="gallery_swiperjs_hash_navigation"
                                       value="1" <?php checked(1, get_option('gallery_swiperjs_hash_navigation', 0)); ?> />
                            </td>
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
            $hashNavigation = get_option('gallery_swiperjs_hash_navigation', 0);
            $swiper_options = "
        autoHeight: true,
        loop: true,
        keyboard: {enabled: true,},
        speed: {$speed},
        slidesPerView: {$slidesPerView},
        spaceBetween: {$spaceBetween},
        effect: '$effect'";
            if ($hashNavigation) {
                $swiper_options .= ",\n        hashNavigation: {watchState: true,}\n    ";
            }
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

            $data_hash_js = $hashNavigation ? "image.setAttribute('data-hash', 'slide' + (index + 1));" : "";
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
                            {$data_hash_js}
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
        function admin_enqueue_scripts($hook)
        {
            if ($hook === 'toplevel_page_jado_options') {
                wp_enqueue_style('wp-color-picker');
                wp_enqueue_script('jado-admin-script', get_template_directory_uri() . '/lib/js/admin-script.js', array('wp-color-picker'), false, true);
            }
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
                add_filter('style_loader_tag', function ($html, $handle) {
                    if ($handle === 'swiperjs-css') {
                        $html = str_replace(
                                "rel='stylesheet'",
                                "rel='stylesheet' media='print' onload=\"this.onload=null;this.media='all';\"",
                                $html
                        );
                    }
                    return $html;
                }, 10, 2);
            }
        }

        add_action('wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets');
    }


    /** Baguettebox */
    if (jado_get_checkbox_state('baguettebox')) {
        function register_b_assets()
        {
            wp_register_style('baguettebox-css', get_template_directory_uri() . '/lib/css/baguetteBox-min.css', [], '1.12.0');
            wp_register_script('baguettebox', get_template_directory_uri() . '/lib/js/baguetteBox-min.js', [], '1.12.0', true);
            $baguettebox_selector = apply_filters('baguettebox_selector', '.wp-block-gallery,:not(.wp-block-gallery)>.wp-block-image,.wp-block-media-text__media,.gallery,.wp-block-coblocks-gallery-masonry,.wp-block-coblocks-gallery-stacked,.wp-block-coblocks-gallery-collage,.wp-block-coblocks-gallery-offset,.wp-block-coblocks-gallery-stacked,.mgl-gallery,.gb-block-image');
            $baguettebox_filter = apply_filters('baguettebox_filter', '/.+\.(gif|jpe?g|png|webp|svg|avif|heif|heic|tif?f|)($|\?)/i');
            $baguettebox_ignoreclass = apply_filters('baguettebox_ignoreclass', 'no-lightbox');
            wp_add_inline_script('baguettebox', 'window.addEventListener("load", function() {baguetteBox.run("' . $baguettebox_selector . '",{captions:function(t){var e=t.parentElement.classList.contains("wp-block-image")||t.parentElement.classList.contains("wp-block-media-text__media")?t.parentElement.querySelector("figcaption"):t.parentElement.parentElement.querySelector("figcaption,dd");return!!e&&e.innerHTML},filter:' . $baguettebox_filter . ',ignoreClass:"' . $baguettebox_ignoreclass . '"});});');
        }

        add_action('wp_enqueue_scripts', __NAMESPACE__ . '\register_b_assets');

        function enqueue_b_assets()
        {
            $baguettebox_enqueue_b_assets = apply_filters('baguettebox_enqueue_b_assets',
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

            if ($baguettebox_enqueue_b_assets) {
                wp_enqueue_script('baguettebox');
                wp_enqueue_style('baguettebox-css');
            }
        }

        add_action('wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_b_assets');
    }


    /** Better Gutenberg Styles Admin */
    $customAdminStyle = get_option('customAdminStyle', '');
    if ($customAdminStyle == 'yes') {
        add_theme_support('editor-styles');
        add_editor_style('lib/css/style.css');
    }

}

add_action('after_setup_theme', 'jado_apply_settings');
