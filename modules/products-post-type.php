<?php
/*=============================================
=          Create Product Post Type           =
=============================================*/
function product_post_type() {
	register_taxonomy_for_object_type('category', 'Products');
	register_post_type('Products',
		array(
			'labels' => array(
				'name'               => __('Products', 'Products'),
				'singular_name'      => __('Product', 'Products'),
				'add_new'            => __('Add New', 'Products'),
				'add_new_item'       => __('Add New Product', 'Products'),
				'edit'               => __('Edit', 'Products'),
				'edit_item'          => __('Edit Product', 'Products'),
				'new_item'           => __('New Product', 'Products'),
				'view'               => __('View Product', 'Products'),
				'view_item'          => __('View Product', 'Products'),
				'search_items'       => __('Search Product', 'Products'),
				'not_found'          => __('No Product Posts found', 'Products'),
				'not_found_in_trash' => __('No Product Posts found in Trash', 'Products'),
			),
			'public'       => true,
			'hierarchical' => true,
			'has_archive'  => true,
			'supports'     => array(
				'title',
				'editor',
				'thumbnail',
			),
			'can_export' => true,
			'taxonomies' => array(
				'category',
			),
			'menu_icon'         => 'dashicons-welcome-write-blog',
			'capability_type'   => 'post',
			'show_in_nav_menus' => true,
		));
}
add_action('init', 'product_post_type');