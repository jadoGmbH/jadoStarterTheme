<!doctype html>
<html lang="<?php echo get_bloginfo('language'); ?>">
<head>
    <meta charset="utf-8">
    <title>
        <?php
        $description = get_bloginfo("description");
        if ($description != '') {
            $descriptionstring = ' - ' . $description;
        } else {
            $descriptionstring = '';
        }
        if (is_front_page()) {
            echo get_bloginfo("name") . $descriptionstring;
        } else {
            echo get_bloginfo("name") . $descriptionstring . ' - ' . get_the_title();
        } ?>
    </title>
    <meta name="author" content="<?php bloginfo('name'); ?>">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="referrer" content="no-referrer">
    <!-- disable when have password protected sites, or other frontend login sites (woocommerce) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta property="og:url" content="<?php the_permalink(); ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php the_title(); ?>">
    <meta property="og:description" content="<?php echo get_the_excerpt(); ?>">
    <meta name="description" content="<?php echo get_the_excerpt(); ?>">
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
                <a class="logolink" aria-label="<?php echo the_title(); ?>" href="<?php echo home_url(); ?>" rel="nofollow">
                    <?php
                    echo '<div id="logo">';
                    $icon_url = get_site_icon_url(300);
                    if ($icon_url) {
                        echo '<img alt="Website Logo" width="100" height="100" src="' . esc_url($icon_url) . '">';
                    }
                    bloginfo('name');
                    echo '</div>'; ?>
                </a>
                <?php if (get_bloginfo('description')) {
                    echo '<span id="description">';
                    bloginfo('description');
                    echo '</span>';
                } ?>
                <div id="burger">
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
                if (!$user == '') {
                    $userName = $user->user_login;
                }else{
                    $userName = '';
                }
                echo '<div class="shopnav">';
                $cart_count = WC()->cart->get_cart_contents_count();
                $cart_page_url = wc_get_cart_url();
                $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
                if (!$cart_count == '') {
                    echo '<a title="Cart" class="cart" href="' . esc_url($cart_page_url) . '"><span class="iconscart">';
                    echo '<svg width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="cart"><path d="M16.62,35.751L53.34,35.751L61.296,12.799L12.514,12.799" style="fill:none;"/><g transform="matrix(0.923506,0,0,0.923506,1.91218,4.43349)"><circle cx="20.13" cy="53.091" r="4.868" style="fill:none;"/></g><g transform="matrix(0.923506,0,0,0.923506,29.2333,4.43349)"><circle cx="20.13" cy="53.091" r="4.868" style="fill:none;"/></g><path d="M2.505,8.152L11.342,8.152L16.297,35.858L16.297,44.877L52.936,44.877" style="fill:none;"/></g></svg>';
                    echo'<span class="counter"><span class="counternum">' . $cart_count . '</span></span></span></a>';
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
            <nav id="site-navigation">
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