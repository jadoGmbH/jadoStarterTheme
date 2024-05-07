<?php get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
        <?php
        the_archive_title('<h1 class="page-title">', '</h1>');
        the_archive_description('<div class="taxonomy-description">', '</div>');
        if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header article-header">
                    <h3 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark"
                                                  title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p class="byline entry-meta vcard">
                        <?php printf(__('Posted', 'jadotheme') . ' %1$s %2$s',
                            '<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" >' . get_the_time(get_option('date_format')) . '</time>',
                            '<span class="by">' . __('by', 'jadotheme') . '</span> <span class="entry-author author">' . get_the_author_link() . '</span>'
                        ); ?>
                    </p>
                </header>
                <section class="entry-content">
                    <?php the_post_thumbnail('medium'); ?>
                    <?php the_excerpt(); ?>
                </section>
            </article>
        <?php endwhile;
            else : ?>
            <article id="post-not-found" class="hentry">
                <header class="article-header">
                    <h1><?php __('404 - Site not found!', 'jadotheme'); ?></h1>
                </header>
            </article>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>