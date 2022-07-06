<?php get_header(); ?>
    <div id="content">
        <div id="inner-content" class="wrap">
            <div class="entry-content">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <section class="entry-content">
                            <h1 class="page-title"><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        </section>
                    </article>
                <?php endwhile;
                else : ?>
                    <article id="post-not-found" class="hentry">
                        <h1>404 - Site not found!</h1>
                    </article>
                <?php endif; ?>
                <?php //get_sidebar(); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>