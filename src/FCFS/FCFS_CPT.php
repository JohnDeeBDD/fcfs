<?php

namespace FCFS;
// Register Custom Post Type
function startupCPT() {

$labels = array(
'name'                  => _x( 'FCFS', 'Post Type General Name', 'FCFS' ),
'singular_name'         => _x( 'FCFS', 'Post Type Singular Name', 'FCFS' ),
'menu_name'             => __( 'FCFS', 'FCFS' ),
'name_admin_bar'        => __( 'FCFS', 'FCFS' ),
'archives'              => __( 'FCFS Archives', 'FCFS' ),
'attributes'            => __( 'FCFS Attributes', 'FCFS' ),
'parent_item_colon'     => __( 'Parent FCFS:', 'FCFS' ),
'all_items'             => __( 'All FCFS', 'FCFS' ),
'add_new_item'          => __( 'Add New FCFS', 'FCFS' ),
'add_new'               => __( 'Add New', 'FCFS' ),
'new_item'              => __( 'New FCFS', 'FCFS' ),
'edit_item'             => __( 'Edit FCFS', 'FCFS' ),
'update_item'           => __( 'Update FCFS', 'FCFS' ),
'view_item'             => __( 'View FCFS', 'FCFS' ),
'view_items'            => __( 'View FCFS', 'FCFS' ),
'search_items'          => __( 'Search FCFS', 'FCFS' ),
'not_found'             => __( 'Not found', 'FCFS' ),
'not_found_in_trash'    => __( 'Not found in Trash', 'FCFS' ),
'featured_image'        => __( 'Featured Image', 'FCFS' ),
'set_featured_image'    => __( 'Set featured image', 'FCFS' ),
'remove_featured_image' => __( 'Remove featured image', 'FCFS' ),
'use_featured_image'    => __( 'Use as featured image', 'FCFS' ),
'insert_into_item'      => __( 'Insert into item', 'FCFS' ),
'uploaded_to_this_item' => __( 'Uploaded to this item', 'FCFS' ),
'items_list'            => __( 'Items list', 'FCFS' ),
'items_list_navigation' => __( 'Items list navigation', 'FCFS' ),
'filter_items_list'     => __( 'Filter items list', 'FCFS' ),
);
$args = array(
'label'                 => __( 'FCFS', 'FCFS' ),
'description'           => __( 'A list of transactions', 'FCFS' ),
'labels'                => $labels,
'supports'              => array( 'title', 'editor', 'custom-fields' ),
'taxonomies'            => array( 'category'),
'hierarchical'          => true,
'public'                => true,
'show_ui'               => true,
'show_in_menu'          => true,
'menu_position'         => 5,
'show_in_admin_bar'     => true,
'show_in_nav_menus'     => true,
'can_export'            => false,
'has_archive'           => false,
'exclude_from_search'   => true,
'publicly_queryable'    => true,
'capability_type'       => 'page',
'show_in_rest'          => false,
);
register_post_type( 'FCFS', $args );

}
add_action( 'init', 'FCFS\startupCPT', 0 );