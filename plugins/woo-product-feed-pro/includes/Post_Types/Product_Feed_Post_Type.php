<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Post_Types;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * Product_Feed Post Type.
 *
 * @since 13.3.5
 */
class Product_Feed_Post_Type extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Register Product Feed CPT.
     *
     * @since 13.3.5
     * @access public
     */
    public function register_post_type() {

        $labels = array(
            'name'               => __( 'Product Feeds', 'woo-product-feed-pro' ),
            'singular_name'      => __( 'Product Feed', 'woo-product-feed-pro' ),
            'menu_name'          => __( 'Product Feeds', 'woo-product-feed-pro' ),
            'parent_item_colon'  => __( 'Parent Product Feed', 'woo-product-feed-pro' ),
            'all_items'          => __( 'Product Feeds', 'woo-product-feed-pro' ),
            'view_item'          => __( 'View Product Feed', 'woo-product-feed-pro' ),
            'add_new_item'       => __( 'Add Product Feed', 'woo-product-feed-pro' ),
            'add_new'            => __( 'New Product Feed', 'woo-product-feed-pro' ),
            'edit_item'          => __( 'Edit Product Feed', 'woo-product-feed-pro' ),
            'update_item'        => __( 'Update Product Feed', 'woo-product-feed-pro' ),
            'search_items'       => __( 'Search Product Feed', 'woo-product-feed-pro' ),
            'not_found'          => __( 'No Product Feed found', 'woo-product-feed-pro' ),
            'not_found_in_trash' => __( 'No Product Feeds found in Trash', 'woo-product-feed-pro' ),
        );

        $args = array(
            'label'               => __( 'Product Feed', 'woo-product-feed-pro' ),
            'description'         => __( 'Product Feed CPT', 'woo-product-feed-pro' ),
            'labels'              => $labels,
            'query_var'           => true,
            'rewrite'             => false,
            'can_export'          => true,
            'exclude_from_search' => true,
            'hierarchical'        => false,
            'taxonomies'          => array(),
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'public'              => false,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
            'show_in_rest'        => false, // Disable default REST for Order Form Custom Post Type.
        );

        register_post_type(
            Product_Feed::POST_TYPE,
            /**
             * Filters the arguments for registering the `adt_feed` custom post type.
             *
             * @param array $args   Array of arguments for registering a post type.
             * @param array $labels Array of labels for the post type.
             *
             * @since 13.3.5
             */
            apply_filters( 'adt_product_feed_cpt_args', $args, $labels )
        );

        /**
         * Action hook to run after registering the `adt_feed` custom post type.
         *
         * @param string $post_type The post type name.
         *
         * @since 13.3.5
         */
        do_action( 'adt_after_register_adt_product_feed_post_type', Product_Feed::POST_TYPE );
    }

    /**
     * Registers the `adt_feed` custom post type.
     *
     * @since 13.3.5
     */
    public function run() {
        // Register Product Feed CPT.
        add_action( 'init', array( $this, 'register_post_type' ) );
    }
}
