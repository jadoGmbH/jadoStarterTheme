<!doctype html>
<html lang="<?php echo get_bloginfo('language'); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
    $description = get_bloginfo("description");
    if ($description != '') {
        $descriptionstring = ' - ' . $description;
    } else {
        $descriptionstring = '';
    }
    if (is_front_page()) {
        echo '<title>' . get_bloginfo("name") . $descriptionstring . '</title>';
    } else {
        echo '<title>' . get_bloginfo("name") . $descriptionstring . ' - ' . get_the_title() . '</title>';
    } ?>
    <meta name="author" content="<?php bloginfo('name'); ?>">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <!--<meta name="referrer" content="no-referrer"> enable when not have password protected sites, or other frontend login sites (woocommerce) -->
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
            <div class="flex">
                <a class="logolink" href="<?php echo home_url(); ?>" rel="nofollow">
                    <?php echo '<h1 id="logo">';
                    echo bloginfo('name');
                    echo '</h1>'; ?>
                </a>
                <span id="description"><?php bloginfo('description'); ?></span>
                <div id="burger">
                    <div class="cheese c1"></div>
                    <div class="cheese c2"></div>
                    <div class="cheese c3"></div>
                </div>
            </div>
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