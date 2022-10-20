<?php get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
        <div class="entry-content blog">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2 class="h2 entry-title">
                        <a href="<?php the_permalink() ?>" rel="bookmark"
                           title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="byline entry-meta vcard">
                        <?php printf(__('', 'jadotheme') . ' %1$s %2$s',
                            '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" >' . get_the_time(get_option('date_format')) . '</time>',
                            ''
                        ); ?>
                    </p>
                    <section class="entry-content">
                        <p>
                            <?php echo get_the_excerpt();  ?>
                        </p>
                    </section>
                    <a href="<?php the_permalink() ?>" rel="bookmark" class="wp-block-button__link"
                       title="<?php the_title_attribute(); ?>"><?php _e('read more', 'jadotheme'); ?></a>
                    <?php //printf('<p class="footer-category">' . __('filed under', 'jadotheme') . ': %1$s</p>', get_the_category_list(', ')); ?>
                    <?php //the_tags('<p class="footer-tags tags"><span class="tags-title">' . __('Tags:', 'jadotheme') . '</span> ', ', ', '</p>'); ?>
                </article>
            <?php endwhile;
            else : ?>
                <article id="post-not-found" class="hentry">
                    <h1><?php _e('404 - Site not found!', 'jadotheme'); ?></h1>
                </article>
            <?php endif; ?>
            <?php //get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
