<?php get_header(); ?>
<div id="content">
    <?php if (has_post_thumbnail()) {
        echo '<div class="featuredImage">';
        the_post_thumbnail('featuredImage');
        echo '</div>';
    } ?>
    <div id="inner-content" class="wrap <?php if (has_post_thumbnail()) {
        if (class_exists('WooCommerce')) {
            if (!is_product()) {
                echo 'hasThumb';
            }
        }
    } ?>">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <section id="post-<?php the_ID(); ?>" class="entry-content page">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </section>

        <?php endwhile; endif; ?>
    </div>
</div>
<?php get_footer(); ?>
