<?php get_header(); ?>
<div id="content">
    <div id="inner-content" class="wrap">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <section class="entry-content">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </section>
            </div>
        <?php endwhile; endif;
        //get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>
