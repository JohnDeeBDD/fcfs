<?php

namespace MigratePosts;
// Register Custom Post Type
function manifest() {

$labels = array(
'name'                  => _x( 'manifests', 'Post Type General Name', 'migrate-posts' ),
'singular_name'         => _x( 'manifest', 'Post Type Singular Name', 'migrate-posts' ),
'menu_name'             => __( 'Manifests', 'migrate-posts' ),
'name_admin_bar'        => __( 'Manifest', 'migrate-posts' ),
'archives'              => __( 'Manifest Archives', 'migrate-posts' ),
'attributes'            => __( 'Manifest Attributes', 'migrate-posts' ),
'parent_item_colon'     => __( 'Parent Manifest:', 'migrate-posts' ),
'all_items'             => __( 'All Manifests', 'migrate-posts' ),
'add_new_item'          => __( 'Add New Manifest', 'migrate-posts' ),
'add_new'               => __( 'Add New', 'migrate-posts' ),
'new_item'              => __( 'New Manifest', 'migrate-posts' ),
'edit_item'             => __( 'Edit Manifest', 'migrate-posts' ),
'update_item'           => __( 'Update Manifest', 'migrate-posts' ),
'view_item'             => __( 'View Manifest', 'migrate-posts' ),
'view_items'            => __( 'View Manifests', 'migrate-posts' ),
'search_items'          => __( 'Search Manifest', 'migrate-posts' ),
'not_found'             => __( 'Not found', 'migrate-posts' ),
'not_found_in_trash'    => __( 'Not found in Trash', 'migrate-posts' ),
'featured_image'        => __( 'Featured Image', 'migrate-posts' ),
'set_featured_image'    => __( 'Set featured image', 'migrate-posts' ),
'remove_featured_image' => __( 'Remove featured image', 'migrate-posts' ),
'use_featured_image'    => __( 'Use as featured image', 'migrate-posts' ),
'insert_into_item'      => __( 'Insert into item', 'migrate-posts' ),
'uploaded_to_this_item' => __( 'Uploaded to this item', 'migrate-posts' ),
'items_list'            => __( 'Items list', 'migrate-posts' ),
'items_list_navigation' => __( 'Items list navigation', 'migrate-posts' ),
'filter_items_list'     => __( 'Filter items list', 'migrate-posts' ),
);
$args = array(
'label'                 => __( 'manifest', 'migrate-posts' ),
'description'           => __( 'A list of transactions', 'migrate-posts' ),
'labels'                => $labels,
'supports'              => array( 'title', 'editor', 'custom-fields' ),
'taxonomies'            => array( 'category', 'post_tag' ),
'hierarchical'          => false,
'public'                => false,
'show_ui'               => true,
'show_in_menu'          => true,
'menu_position'         => 5,
'show_in_admin_bar'     => true,
'show_in_nav_menus'     => false,
'can_export'            => false,
'has_archive'           => true,
'exclude_from_search'   => true,
'publicly_queryable'    => false,
'capability_type'       => 'page',
'show_in_rest'          => false,
);
register_post_type( 'manifest', $args );

}
add_action( 'init', 'MigratePosts\manifest', 0 );