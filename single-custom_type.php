<?php
/*
 * CUSTOM POST TYPE TEMPLATE
 *
 * This is the custom post type post template. If you edit the post type name, you've got
 * to change the name of this template to reflect that name change.
 *
 * For Example, if your custom post type is "register_post_type( 'bookmarks')",
 * then your single template should be single-bookmarks.php
 *
 * Be aware that you should rename 'custom_cat' and 'custom_tag' to the appropiate custom
 * category and taxonomy slugs, or this template will not finish to load properly.
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates
*/
?>

<?php get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
                    <header class="article-header">
                        <h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
                        <p class="byline vcard"><?php
                            printf(__('Posted <time class="updated" datetime="%1$s">%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'jadotheme'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link(get_the_author_meta('ID')), get_the_term_list($post->ID, 'custom_cat', ' ', ', ', ''));
                            ?></p>
                    </header>
                    <section class="entry-content">
                        <?php
                        the_content();
//                        wp_link_pages(array(
//                            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'jadotheme') . '</span>',
//                            'after' => '</div>',
//                            'link_before' => '<span>',
//                            'link_after' => '</span>',
//                        ));
                        ?>
                    </section> <!-- end article section -->
                    <footer class="article-footer">
                        <p class="tags"><?php echo get_the_term_list(get_the_ID(), 'custom_tag', '<span class="tags-title">' . __('Custom Tags:', 'jadotheme') . '</span> ', ', ') ?></p>
                    </footer>
                    <?php //comments_template(); ?>
                </article>
            <?php endwhile; ?>

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
