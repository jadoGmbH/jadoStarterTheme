<?php get_header(); ?>
    <div id="content">
        <div id="inner-content" class="wrap">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
                    <section class="entry-content">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </section>
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