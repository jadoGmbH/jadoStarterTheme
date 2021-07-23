<div id="sidebar1" class="sidebar">
    <?php if (is_active_sidebar('sidebar1')) : ?>
        <?php dynamic_sidebar('sidebar1'); ?>
    <?php else : ?>
        <div class="no-widgets">
            <p>No Widgets active</p>
        </div>
    <?php endif; ?>
</div>
