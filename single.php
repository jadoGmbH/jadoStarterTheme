<?php get_header(); ?>
    <main id="content">
        <?php $hasMedia = has_post_thumbnail() || jado_get_featured_video_id(get_the_ID());
        if ($hasMedia) {
            echo '<div class="featuredImage">';
            echo jado_render_featured_media(get_the_ID(), 'featuredImage');
            echo '</div>';
        } ?>
        <div id="inner-content" class="wrap <?php if ($hasMedia) { if (class_exists('WooCommerce')) { if (!is_product()) { echo 'hasThumb'; } } } ?>">
            <div class="entry-content">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <section class="entry-content">
                            <h1 class="page-title"><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        </section>
                    </article>
                <?php endwhile;
                else : ?>
                    <article id="post-not-found" class="hentry">
                        <h1><?php __('404 - Site not found!', 'jadotheme'); ?></h1>
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </main>
<?php get_footer(); ?>
