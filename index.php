<?php get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?>>
                <header class="article-header">
                    <h2 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark"
                                                  title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="byline entry-meta vcard">
                        <?php printf(__('Posted', 'bonestheme') . ' %1$s %2$s',
                            '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" >' . get_the_time(get_option('date_format')) . '</time>',
                            '<span class="by">' . __('by', 'bonestheme') . '</span> <span class="entry-author author">' . get_the_author_link(get_the_author_meta('ID')) . '</span>'
                        ); ?>
                    </p>
                </header>
                <section class="entry-content">
                    <?php the_content(); ?>
                </section>
                <footer class="article-footer">
                    <?php //printf('<p class="footer-category">' . __('filed under', 'bonestheme') . ': %1$s</p>', get_the_category_list(', ')); ?>
                    <?php //the_tags('<p class="footer-tags tags"><span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', '</p>'); ?>
                </footer>
            </article>
        <?php endwhile; ?>
            <?php //bones_page_navi(); ?>
        <?php else : ?>
            <article id="post-not-found" class="hentry">
                <header class="article-header">
                    <h1>404, Seite nicht gefunden!</h1>
                </header>
            </article>
        <?php endif; ?>
        <?php //get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>
