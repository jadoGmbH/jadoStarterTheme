<?php
// don't load it if you can't comment
if (post_password_required()) {
    return;
}
if (have_comments()) : ?>
    <h3 id="comments-title"
        class="h2"><?php comments_number(__('<span>No</span> Comments', 'jadotheme'), __('<span>One</span> Comment', 'jadotheme'), __('<span>%</span> Comments', 'jadotheme')); ?></h3>
    <section class="commentlist">
        <?php
        wp_list_comments(array(
            'style' => 'div',
            'short_ping' => true,
            'avatar_size' => 40,
            'callback' => 'jado_comments',
            'type' => 'all',
            'reply_text' => __('Reply', 'jadotheme'),
            'page' => '',
            'per_page' => '',
            'reverse_top_level' => null,
            'reverse_children' => ''
        ));
        ?>
    </section>
    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <nav class="navigation comment-navigation">
            <div class="comment-nav-prev"><?php previous_comments_link(__('&larr; Previous Comments', 'jadotheme')); ?></div>
            <div class="comment-nav-next"><?php next_comments_link(__('More Comments &rarr;', 'jadotheme')); ?></div>
        </nav>
    <?php endif;
    if (!comments_open()) : ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'jadotheme'); ?></p>
    <?php endif; endif;
comment_form(); ?>

