<?php get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
        <h1 class="archive-title">
            <span><?php _e('Search Results for:', 'bonestheme'); ?></span> <?php echo esc_attr(get_search_query()); ?>
        </h1>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> >
                <header class="entry-header article-header">
                    <h3 class="search-title entry-title"><a href="<?php the_permalink() ?>" rel="bookmark"
                                                            title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p class="byline entry-meta">
                        <?php printf(__('Posted %1$s by %2$s', 'bonestheme'),
                            '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" >' . get_the_time(get_option('date_format')) . '</time>',
                            '<span class="by">by</span> <span class="entry-author author">' . get_the_author_link(get_the_author_meta('ID')) . '</span>'
                        ); ?>
                    </p>
                </header>
                <section class="entry-content">
                    <?php the_excerpt('<span class="read-more">' . __('Read more &raquo;', 'bonestheme') . '</span>'); ?>
                </section>
                <footer class="article-footer">
                    <?php if (get_the_category_list(', ') != ''):
                        printf(__('Filed under: %1$s', 'bonestheme'), get_the_category_list(', '));
                    endif;
                    the_tags('<p class="tags"><span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', '</p>'); ?>
                </footer> <!-- end article footer -->
            </article>
        <?php endwhile; ?>
            <?php //bones_page_navi(); ?>
        <?php else : ?>
            <article id="post-not-found" class="hentry">
                <header class="article-header">
                    <h1>404, Seite nicht gefunden!</h1>
                </header>
            </article>
        <?php endif;
        //get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>
