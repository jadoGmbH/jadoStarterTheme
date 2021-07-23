<?php
add_action('after_switch_theme', 'jado_flush_rewrite_rules');
function jado_flush_rewrite_rules()
{
    flush_rewrite_rules();
}

function custom_post_example()
{
    register_post_type('custom_type',
        array('labels' => array(
            'name' => __('Produkte', 'jadotheme'),
            'singular_name' => __('Produkt', 'jadotheme'),
            'all_items' => __('Alle Produkte', 'jadotheme'),
            'add_new' => __('Neues Produkt', 'jadotheme'),
            'add_new_item' => __('Add New Custom Type', 'jadotheme'),
            'edit' => __('Bearbeiten', 'jadotheme'),
            'edit_item' => __('Edit Post Types', 'jadotheme'),
            'new_item' => __('New Post Type', 'jadotheme'),
            'view_item' => __('View Post Type', 'jadotheme'),
            'search_items' => __('Search Post Type', 'jadotheme'),
            'not_found' => __('Nothing found in the Database.', 'jadotheme'),
            'not_found_in_trash' => __('Nothing found in Trash', 'jadotheme'),
            'parent_item_colon' => ''
        ),
            'description' => __('Example custom post type', 'jadotheme'),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 3,
            'menu_icon' => 'dashicons-visibility', //dashicons-welcome-view-site
            'rewrite' => array('slug' => 'produkt', 'with_front' => false),
            'has_archive' => 'produkte',
            'capability_type' => 'post',
			'show_in_rest' => true, // Gutenberg enable
			'hierarchical' => false,
            //'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
			'supports' => array('title', 'editor', 'author', 'thumbnail',  'custom-fields', 'revisions')
        )
    );

}

add_action('init', 'custom_post_example');

/*
register_taxonomy('custom_cat',
    array('custom_type'),
    array('hierarchical' => true,
        'labels' => array(
            'name' => __('Produkt Kategorien', 'jadotheme'),
            'singular_name' => __('Produkt Kategorie', 'jadotheme'),
            'search_items' => __('Search Produkt Kategorien', 'jadotheme'),
            'all_items' => __('Alle Produkt Kategorien', 'jadotheme'),
            'parent_item' => __('Parent Produkt Kategorien', 'jadotheme'),
            'parent_item_colon' => __('Parent Produkt Kategorie:', 'jadotheme'),
            'edit_item' => __('Produkt Kategorie Bearbeiten', 'jadotheme'),
            'update_item' => __('Update Produkt Kategorie', 'jadotheme'),
            'add_new_item' => __('Neue Produkt Kategorie', 'jadotheme'),
            'new_item_name' => __('Neue Produkt Kategorie Name', 'jadotheme')
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'custom-slug'),
    )
);

register_taxonomy('custom_tag',
    array('custom_type'),
    array('hierarchical' => false,
        'labels' => array(
            'name' => __('Produkt Tags', 'jadotheme'),
            'singular_name' => __('Produkt Tag', 'jadotheme'),
            'search_items' => __('Search Produkt Tags', 'jadotheme'),
            'all_items' => __('Alle Produkt Tags', 'jadotheme'),
            'parent_item' => __('Parent Custom Tag', 'jadotheme'),
            'parent_item_colon' => __('Parent Custom Tag:', 'jadotheme'),
            'edit_item' => __('Edit Custom Tag', 'jadotheme'),
            'update_item' => __('Update Custom Tag', 'jadotheme'),
            'add_new_item' => __('Add New Custom Tag', 'jadotheme'),
            'new_item_name' => __('New Custom Tag Name', 'jadotheme')
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
    )
);
*/

?>
