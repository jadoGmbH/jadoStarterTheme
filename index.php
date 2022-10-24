<?php get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
        <div class="entry-content blog">
            <div class="posts">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <a rel="bookmark" href="<?php echo get_the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) {
                                echo '<div class="postimg">';
                                the_post_thumbnail('medium');
                                echo '</div>';
                            } ?>
                            <div class="postcontent <?php if (!has_post_thumbnail()) {
                                echo 'noimg';
                            } ?>">
                                <h2 class="h2 entry-title">
                                    <?php the_title(); ?>
                                </h2>
                                <p class="byline entry-meta">
                                    <?php printf(__('', 'jadotheme') . ' %1$s %2$s',
                                        '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" >' . get_the_time(get_option('date_format')) . '</time>',
                                        ''
                                    ); ?>
                                </p>
                                <p>
                                    <?php echo get_the_excerpt(); ?>
                                </p>
                            </div>
                        </a>
                        <div class="postcontent">
                            <?php //printf('<p class="post-category">' . __('Category:', 'jadotheme') . ' %1$s</p>', get_the_category_list(', ')); ?>
                            <?php //the_tags('<p class="post-tags"><span class="tags-title">' . __('Tags:', 'jadotheme') . '</span> ', ', ', '</p>'); ?>
                        </div>
                    </article>
                <?php endwhile;
                else : ?>
                    <article id="post-not-found" class="hentry">
                        <h1><?php _e('404 - Site not found!', 'jadotheme'); ?></h1>
                    </article>
                <?php endif; ?>
            </div>
            <?php //get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
