<?php get_header();
$hasMedia = has_post_thumbnail() || jado_get_featured_video_id(get_the_ID());
$showMedia = $hasMedia && (!class_exists('WooCommerce') || !is_product());
?>
    <main id="content">
        <?php if ($hasMedia): ?>
            <div class="featuredImage">
                <?php echo jado_render_featured_media(get_the_ID(), 'featuredImage'); ?>
            </div>
        <?php endif; ?>
        <div id="inner-content" class="wrap<?php echo $showMedia ? ' hasThumb' : ''; ?>">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('entry-content page'); ?>>
                    <header>
                        <h1><?php the_title(); ?></h1>
                    </header>
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile;
            else : ?>
                <section class="no-content">
                    <p><?php esc_html_e('Sorry, no content available.', 'your-theme-textdomain'); ?></p>
                </section>
            <?php endif; ?>
        </div>
    </main>
<?php get_footer(); ?>
