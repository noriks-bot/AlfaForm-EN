<?php

defined( 'ABSPATH' ) || exit();

/**
 * @package PaymentPlugins\Admin
 */
class WC_Stripe_Admin_Product_Edit {

	//bulk_actions-edit-product
	public static function init() {
		add_filter( 'bulk_actions-edit-product', array( __CLASS__, 'product_bulk_actions' ) );
		add_action( 'handle_bulk_actions-edit-product', array( __CLASS__, 'process_bulk_actions' ), 10, 3 );
	}

	public static function product_bulk_actions( $actions ) {
		$actions['wc_stripe_delete'] = __( 'Delete Stripe Options', 'woo-stripe-payment' );

		return $actions;
	}

	public static function process_bulk_actions( $redirect, $doaction, $post_ids ) {
		if ( $doaction === 'wc_stripe_delete' && current_user_can( 'manage_woocommerce' ) ) {
			$gateways = array_filter( WC()->payment_gateways()->payment_gateways(), function ( $gateway ) {
				return $gateway instanceof \WC_Payment_Gateway_Stripe && $gateway->supports( 'wc_stripe_product_checkout' );
			} );
			// delete the Stripe options for the $post_ids
			foreach ( $post_ids as $id ) {
				$product = wc_get_product( $id );
				if ( $product ) {
					foreach ( $gateways as $gateway ) {
						$option = new WC_Stripe_Product_Gateway_Option( $product, $gateway );
						$product->delete_meta_data( $option->get_id() );
					}
					$product->delete_meta_data( \WC_Stripe_Constants::PRODUCT_GATEWAY_ORDER );
					$product->delete_meta_data( \WC_Stripe_Constants::BUTTON_POSITION );
					$product->save();
				}
			}
		}

		return $redirect;
	}

}

WC_Stripe_Admin_Product_Edit::init();