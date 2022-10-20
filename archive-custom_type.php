<?php get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
        <h1 class="archive-title h2"><?php post_type_archive_title(); ?></h1>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?>>
                <header class="article-header">
                    <h3 class="h2">
                        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                </header>
                <section class="entry-content">
                    <?php the_excerpt(); ?>
                </section>
            </article>
        <?php endwhile;
        else : ?>
            <article id="post-not-found" class="hentry">
                <header class="article-header">
                    <h1><?php __('404 - Site not found!'); ?></h1>
                </header>
            </article>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>