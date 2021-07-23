<!doctype html>

<html lang="<?php
$sprache = get_bloginfo('language');
$sprachekurz = substr("$sprache", 0, 2);
echo $sprachekurz; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php if (is_front_page()) {
            echo bloginfo('name');
        } else {
            echo bloginfo('name') . '' . wp_title('–');
        }; ?>
    </title>

<!--    <meta name="geo.position" content="47.9955;7.8522">-->
<!--    <meta name="ICBM" content="47.9955, 7.8522">-->
<!--    <meta name="geo.placename" content="Seefeld">-->
<!--    <meta name="geo.region" content="DE-BY">-->


    <meta name="author" content="<?php bloginfo('name'); ?>">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="referrer" content="no-referrer">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"> <!-- iphone landscape full width -->

    <meta property="og:url" content="<?php the_permalink(); ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php the_title(); ?>"/>
    <meta property="og:description" content="<?php the_excerpt(); ?>"/>
    <meta property="og:image" content="<?php the_post_thumbnail_url('full'); ?>"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:url" content="<?php the_permalink(); ?>">
    <meta name="twitter:title" content="<?php the_title(); ?>"/>
    <meta name="twitter:image" content="<?php the_post_thumbnail_url('large'); ?>">
    <meta name="description" content="<?php the_excerpt(); ?>"/>

    <?php
    if ((strpos($_SERVER["HTTP_HOST"], 'local') !== false) || (strpos($_SERVER["HTTP_HOST"], 'ja.do') !== false)) {
        $timestamp = 'style.css?v=' . date('His');
    }
    else {
        $timestamp = 'style.css';
    }
    ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/lib/css/<?php echo $timestamp; ?>">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="container">
    <header id="headerfixed" class="header show">
        <div id="inner-header" class="wrap">
            <?php if (!is_front_page()) {
                echo '<a class="logolink" href="' . home_url() . '" rel="nofollow">';
            }; ?>
            <span id="logo"><?php bloginfo('name'); ?></span>
            <?php if (!is_front_page()) {
                echo '</a>';
            }; ?>
            <span id="description"><?php bloginfo('description'); ?></span>
            <div id="burger">
                <div class="cheese c1"></div>
                <div class="cheese c2"></div>
                <div class="cheese c3"></div>
            </div>
            <nav id="site-navigation">
                <?php wp_nav_menu(array(
                    'container' => false,
                    'container_class' => 'menu',
                    'menu' => __('MainMenu', 'jado'),
                    'menu_class' => 'nav top-nav',
                    'theme_location' => 'MainMenu',
                    'depth' => 0
                )); ?>
            </nav>
        </div>
    </header>