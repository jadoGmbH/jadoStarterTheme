<?php
/*
 Template Name: Custom Loop
 *
*/
get_header(); ?>
<main id="content">
    <div id="inner-content" class="wrap">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <section class="entry-content">
                    <h1><?php the_title(); ?></h1>
                    <div class="cpt-container">
                        <?php
                        $loop = new WP_Query(array('post_type' => 'custom_type'));
                        if ($loop->have_posts()) :
                            while ($loop->have_posts()) : $loop->the_post();
                                ?>
                                <div class="cpt <?php if (has_term('sold', 'custom_cat')) { // custom categories
                                    echo 'sold';
                                } ?>">
                                    <a rel="bookmark" href="<?php echo get_the_permalink(); ?>">
                                        <?php if (has_post_thumbnail()) {
                                            echo '<div class="cptimg">';
                                            the_post_thumbnail('medium');
                                            echo '</div>';
                                        } ?>
                                        <div class="cptcontent <?php if (!has_post_thumbnail()) {
                                            echo 'noimg';
                                        } ?>">
                                            <h2><?php echo get_the_title(); ?></h2>
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </a>

                                </div>
                            <?php
                            endwhile;
                        endif;
                        wp_reset_postdata(); ?>
                    </div>
                    <?php the_content(); ?>
                </section>
            </div>
        <?php endwhile; endif; ?>
    </div>
</main>
<?php get_footer(); ?>
