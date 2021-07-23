<?php
/*
 * CUSTOM POST TYPE TAXONOMY TEMPLATE
 * For more info: http://codex.wordpress.org/Post_Type_Templates#Displaying_Custom_Taxonomies
*/
get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
        <h1 class="archive-title h2">
            <span><?php _e('Posts Categorized:', 'jadotheme'); ?></span> <?php single_cat_title(); ?></h1>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
                <header class="article-header">
                    <h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark"
                                      title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                    <p class="byline vcard"><?php
                        printf(__('Posted <time class="updated" datetime="%1$s">%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'jadotheme'), get_the_time('Y-m-j'), get_the_time(__('F jS, Y', 'jadotheme')), jado_get_the_author_posts_link(), get_the_term_list(get_the_ID(), 'custom_cat', "", ", ", ""));
                        ?></p>
                </header>
                <section class="entry-content">
                    <?php the_excerpt('<span class="read-more">' . __('Read More &raquo;', 'jadotheme') . '</span>'); ?>
                </section>
            </article>
        <?php endwhile;
        else : ?>
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
