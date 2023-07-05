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
    <header id="headerfixed" class="header">
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
                <a class="logolink" href="<?php echo home_url(); ?>" rel="nofollow">
                    <?php echo '<h1 id="logo">';
                    bloginfo('name');
                    echo '</h1>'; ?>
                </a>
                <?php if (get_bloginfo('description')) {
                    echo '<span id="description">' . bloginfo('description') . '</span>';
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
                    echo '<a title="Cart" class="cart" href="' . esc_url($cart_page_url) . '"><span class="iconscart"><span class="counter"><span class="counternum">' . $cart_count . '</span></span></span></a>';
                } else {
                    echo '<a title="Cart" class="cart" href="' . esc_url($shop_page_url) . '"><span class="iconscart"></span></a>';
                }

                    echo '<a title="Account Login" class="shopuser';
                if (!$userName == '') {
                    echo ' loggedin';
                } else {
                    echo ' loggedout';
                }
                echo '" href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '">';
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