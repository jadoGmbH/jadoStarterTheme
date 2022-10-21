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
            'name' => __('Products', 'jadotheme'),
            'singular_name' => __('Product', 'jadotheme'),
            'all_items' => __('All Products', 'jadotheme'),
            'add_new' => __('New Product', 'jadotheme'),
            'add_new_item' => __('Add New Product', 'jadotheme'),
            'edit' => __('Edit', 'jadotheme'),
            'edit_item' => __('Edit Product', 'jadotheme'),
            'new_item' => __('New Product', 'jadotheme'),
            'view_item' => __('View Product', 'jadotheme'),
            'search_items' => __('Search Products', 'jadotheme'),
            'not_found' => __('Nothing found in the Database.', 'jadotheme'),
            'not_found_in_trash' => __('Nothing found in Trash', 'jadotheme'),
            'parent_item_colon' => ''
        ),
            'description' => __('Products Post Type', 'jadotheme'),
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


register_taxonomy('custom_cat',
    array('custom_type'),
    array('hierarchical' => true,
        'labels' => array(
            'name' => __('Product categories', 'jadotheme'),
            'singular_name' => __('Product category', 'jadotheme'),
            'search_items' => __('Search Product category', 'jadotheme'),
            'all_items' => __('All Product categories', 'jadotheme'),
            'parent_item' => __('Parent Product category', 'jadotheme'),
            'parent_item_colon' => __('Parent Product category:', 'jadotheme'),
            'edit_item' => __('Edit Product category', 'jadotheme'),
            'update_item' => __('Update Product category', 'jadotheme'),
            'add_new_item' => __('New Product category', 'jadotheme'),
            'new_item_name' => __('New Product category name', 'jadotheme')
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
            'name' => __('Products Tags', 'jadotheme'),
            'singular_name' => __('Product Tag', 'jadotheme'),
            'search_items' => __('Search Produkt Tags', 'jadotheme'),
            'all_items' => __('All Product Tags', 'jadotheme'),
            'parent_item' => __('Parent Product Tag', 'jadotheme'),
            'parent_item_colon' => __('Parent Product Tag:', 'jadotheme'),
            'edit_item' => __('Edit Product Tag', 'jadotheme'),
            'update_item' => __('Update Product Tag', 'jadotheme'),
            'add_new_item' => __('Add New Product Tag', 'jadotheme'),
            'new_item_name' => __('New Product Tag Name', 'jadotheme')
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
    )
);


?>
