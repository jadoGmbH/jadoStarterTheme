<!doctype html>
<html lang="<?php echo get_bloginfo('language'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo esc_html(is_front_page() ? get_bloginfo('name') . ' - ' . get_bloginfo('description') : get_the_title() . ' - ' . get_bloginfo('name')); ?></title>
    <meta name="author" content="<?php bloginfo('name'); ?>">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="referrer" content="no-referrer">
    <!-- disable when have password protected sites, or other frontend login sites (woocommerce) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt(), true)); ?>">
    <meta property="og:url" content="<?php the_permalink(); ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php the_title(); ?>">
    <meta property="og:description" content="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt(), true)); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <meta property="og:locale" content="<?php echo get_locale(); ?>">


    <?php
    $business_city          = get_option('business_city');
    $business_street        = get_option('business_street');
    $business_postal_code   = get_option('business_postal_code');
    $business_country       = get_option('business_country');
    $business_contactsite   = get_option('business_contactsite');
    $business_areaserved    = get_option('business_areaserved');
    $business_languages     = get_option('business_languages');
    $business_foundingdate  = get_option('business_foundingdate');
    $icon_url               = get_site_icon_url(300);
    $business_linkedin      = get_option('business_linkedin');
    $business_bluesky       = get_option('business_bluesky');
    $business_mastodon      = get_option('business_mastodon');
    $business_facebook      = get_option('business_facebook');
    $business_googlemaps    = get_option('business_googlemaps');

    if (!empty($business_city)) {

        $sameAs_raw = array_filter([
            $business_linkedin,
            $business_bluesky,
            $business_mastodon,
            $business_facebook,
            $business_googlemaps,
        ]);
        $sameAs = array_values($sameAs_raw);
        if (!empty($sameAs)) {
            $jsonld["sameAs"] = $sameAs;
        }
        $areaServed = [];
        if (!empty($business_areaserved)) {
            $items = explode(',', $business_areaserved);
            $areaServed = array_map(fn($item) => strtoupper(trim($item)), $items);
        }

        $languages = [];
        if (!empty($business_languages)) {
            $items = explode(',', $business_languages);
            $languages = array_map(fn($item) => strtoupper(trim($item)), $items);
        }

        $jsonld = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => get_bloginfo('name'),
            "legalName" => get_bloginfo('name'),
            "url" => home_url(),
            "description" => get_bloginfo('description'),
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => $business_street,
                "postalCode" => $business_postal_code,
                "addressLocality" => $business_city,
                "addressCountry" => $business_country,
            ],
        ];

        if (!empty($icon_url)) {
            $jsonld["logo"] = $icon_url;
        }

        if (!empty($sameAs)) {
            $jsonld["sameAs"] = $sameAs;
        }

        $contact = [
            "@type" => "ContactPoint",
            "contactType" => "customer support",
        ];

        if (!empty($business_contactsite)) {
            $contact["url"] = $business_contactsite;
        }

        if (!empty($areaServed)) {
            $contact["areaServed"] = $areaServed;
        }

        if (!empty($languages)) {
            $contact["availableLanguage"] = $languages;
        }

        $jsonld["contactPoint"] = $contact;

        if (!empty($business_foundingdate)) {
            $jsonld["foundingDate"] = $business_foundingdate;
        }
        ?>
        <script type="application/ld+json">
        <?php echo json_encode($jsonld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
    </script>
        <?php
    }
    ?>


    <?php if (has_post_thumbnail()) { ?>
    <meta property="og:image" content="<?php the_post_thumbnail_url('ogimage'); ?>">
    <?php } ?>
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
    <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
    <?php endif; ?>
    <?php wp_head();
    if (str_contains($_SERVER["HTTP_HOST"], 'local') !== false) {
    $timestamp = 'style.css?v=' . date('His');
    } else {
    $timestamp = 'style.css?v=01a';
    } ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/lib/css/<?php echo $timestamp; ?>">
</head>
<body <?php body_class(); ?>>
<div id="container">
    <header id="header" class="header">
        <div id="inner-header" class="wrap">
            <?php
            if (has_nav_menu('MetaNav')) {
            wp_nav_menu(array(
            'container' => false,
            'container_class' => 'menu',
            'menu' => 'MetaNav',
            'menu_class' => 'nav meta-nav',
            'theme_location' => 'MetaNav',
            'depth' => 0
            ));
            }
            ?>
            <div class="flex">
                <a class="logolink" aria-label="<?php echo the_title(); ?>" href="<?php echo home_url(); ?>">
                    <?php
                    echo '<div id="logo">';
                    if ($icon_url) {
                    echo '<img alt="' . esc_attr(get_bloginfo('name')) . ' Logo" width="100" height="100" src="' . esc_url($icon_url) . '">';
                    }
                    bloginfo('name');
                    echo '</div>'; ?>
                </a>
                <?php if (get_bloginfo('description')) {
                echo '<span id="description">';
                bloginfo('description');
                echo '</span>';
                } ?>
                <button id="burger" class="burger" aria-expanded="false" aria-controls="site-navigation"
                        aria-label="Open Menu">
                    <div class="cheese c1"></div>
                    <div class="cheese c2"></div>
                    <div class="cheese c3"></div>
            </div>
        </div>
        <?php
        if (class_exists('WooCommerce')) {
        $user = wp_get_current_user();
        $firstName = get_user_meta($user->ID, 'first_name', true);
        $lastName = get_user_meta($user->ID, 'last_name', true);
        $user = get_user_by('id', $user->ID);
        if (!empty($user)) {
        $userName = $user->user_login;
        }else{
        $userName = '';
        }
        echo '<div class="shopnav">';
        $cart_count = WC()->cart->get_cart_contents_count();
        $cart_page_url = wc_get_cart_url();
        $shop_page_url = get_permalink(wc_get_page_id('shop'));
        if (!$cart_count == '') {
        echo '<a title="Cart" class="cart" href="' . esc_url($cart_page_url) . '"><span class="iconscart">';
        echo '<svg width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="cart"><path d="M16.62,35.751L53.34,35.751L61.296,12.799L12.514,12.799" style="fill:none;"/><g transform="matrix(0.923506,0,0,0.923506,1.91218,4.43349)"><circle cx="20.13" cy="53.091" r="4.868" style="fill:none;"/></g><g transform="matrix(0.923506,0,0,0.923506,29.2333,4.43349)"><circle cx="20.13" cy="53.091" r="4.868" style="fill:none;"/></g><path d="M2.505,8.152L11.342,8.152L16.297,35.858L16.297,44.877L52.936,44.877" style="fill:none;"/></g></svg>';
        echo '<span class="counter"><span class="counternum">' . $cart_count . '</span></span></span></a>';
        } else {
        echo '<a title="Cart" class="cart" href="' . esc_url($shop_page_url) . '"><span class="iconscart">';
        echo '<svg width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="cart"><path d="M16.62,35.751L53.34,35.751L61.296,12.799L12.514,12.799" style="fill:none;"/><g transform="matrix(0.923506,0,0,0.923506,1.91218,4.43349)"><circle cx="20.13" cy="53.091" r="4.868" style="fill:none;"/></g><g transform="matrix(0.923506,0,0,0.923506,29.2333,4.43349)"><circle cx="20.13" cy="53.091" r="4.868" style="fill:none;"/></g><path d="M2.505,8.152L11.342,8.152L16.297,35.858L16.297,44.877L52.936,44.877" style="fill:none;"/></g></svg>';
        echo '</span></a>';
        }
        echo '<a title="Account Login" class="shopuser';
        if (!$userName == '') {
        echo ' loggedin';
        } else {
        echo ' loggedout';
        }
        echo '" href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '">';
        echo '<svg width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;"><g transform="matrix(3.18737,0,0,3.18737,-6.15237,-6.35643)"><path d="M20,21L20,19C20,16.806 18.194,15 16,15L8,15C5.806,15 4,16.806 4,19L4,21" style="fill:none;fill-rule:nonzero;"/></g><g transform="matrix(3.18737,0,0,3.18737,-6.15237,-6.35643)"><circle cx="12" cy="7" r="4" style="fill:none;"/></g></svg>';
        if ($userName == '') {
        echo 'login';
        } elseif ($firstName == '') {
        echo $userName;
        } elseif (!$firstName == '') {
        echo $firstName . ' ' . $lastName;
        }
        echo '</a>';
        echo '</div>';
        }
        ?>
        <nav id="site-navigation" class="wrap">
            <?php wp_nav_menu(array(
            'container' => false,
            'container_class' => 'menu',
            'menu' => 'TopNav',
            'menu_class' => 'nav top-nav',
            'theme_location' => 'TopNav',
            'depth' => 0
            )); ?>
        </nav>
</div>
</header>
