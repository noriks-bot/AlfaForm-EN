<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Helpers\Helper;
?>
<p>
    <?php esc_html_e( 'Create filter and rules so exactly the right products end up in your product feed. These filters and rules are only eligable for the current product feed you are configuring and will not be used for other feeds.', 'woo-product-feed-pro' ); ?>
</p>
<p>
    <?php echo wp_kses_post( __( '<strong>Filters:</strong> Exclude or include products that meet certain conditions.', 'woo-product-feed-pro' ) ); ?>
    <strong>
        <i>
            <a href="<?php echo esc_url( Helper::get_utm_url( 'how-to-create-filters-for-your-product-feed', 'pfp', 'filtersandrulesnotice', 'createfilters' ) ); ?>" target="_blank">
                <?php esc_html_e( 'Detailed information and filter examples', 'woo-product-feed-pro' ); ?>
            </a>
        </i>
    </strong>
    or 
    <strong>
        <i>
            <a href="<?php echo esc_url( Helper::get_utm_url( 'create-a-product-feed-for-one-specific-category', 'pfp', 'filtersandrulesnotice', 'createfeedforspecificcategory' ) ); ?>" target="_blank">
                <?php esc_html_e( 'Create a product feed for just 1 category', 'woo-product-feed-pro' ); ?>
            </a>
        </i>
    </strong>
    <br/>
    <?php echo wp_kses_post( __( 'Change attribute values based on other attribute values or conditions.', 'woo-product-feed-pro' ) ); ?>
    <strong>
        <i>
            <a href="<?php echo esc_url( Helper::get_utm_url( 'how-to-create-rules', 'pfp', 'filtersandrulesnotice', 'createrules' ) ); ?>" target="_blank">
                <?php esc_html_e( 'Detailed information about rules and some examples', 'woo-product-feed-pro' ); ?>
            </a>
        </i>
    </strong>
</p>
<p><?php esc_html_e( 'Order of execution: the filters and rules will be executed in the order of creation.', 'woo-product-feed-pro' ); ?></p>
