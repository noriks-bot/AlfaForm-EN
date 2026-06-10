<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Factoriess
 */

namespace AdTribes\PFP\Factories;

use WP_Query;
use AdTribes\PFP\Helpers\Product_Feed_Helper;

/**
 * For querying order forms.
 *
 * @since 13.3.5
 */
class Product_Feed_Query extends WP_Query {

    /**
     * The context for the query.
     *
     * @since 13.3.5
     * @var string
     */
    protected $context;

    /**
     * Order forms query constructor.
     *
     * @param string|array $query   Should be the same with WP_Query.
     * @param string       $context The context for the query.
     */
    public function __construct( $query = '', $context = 'view' ) {
        $query = wp_parse_args( $query );

        $query['post_type'] = Product_Feed::POST_TYPE;

        $this->context = $context;

        parent::__construct( $query );
    }

    /**
     * Customize the posts results.
     *
     * @since 13.3.5
     * @return array
     */
    public function get_posts() {
        parent::get_posts();

        if ( ! in_array( $this->get( 'fields' ), array( 'ids', 'id=>parent' ), true ) ) {
            $this->posts = array_map(
                function ( $post ) {
                    return Product_Feed_Helper::get_product_feed( $post, $this->context );
                },
                $this->posts
            );
        }
        return $this->posts;
    }
}
