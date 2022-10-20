<?php get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
        <div class="entry-content">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="article-header">
                        <h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
                    </header>
                    <section class="entry-content">
                        <?php
                        the_content();
                        ?>
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
</div>
<?php get_footer(); ?>
