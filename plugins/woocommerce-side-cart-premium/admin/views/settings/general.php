<?php

$menus 			= (array) wp_get_nav_menus();

$menuOptions 	= array(
	'none' 	=> 'Select menu'
);

foreach ($menus as $menuObj ) {
	$menuOptions[ $menuObj->slug ] = $menuObj->name;
}


if( function_exists('xoo_el') ){
	$loginPopupTxt 		= '<a href="'.admin_url( 'admin.php?page=easy-login-woocommerce-settings' ).'" target="_blank">Plugin Settings</a>';
}
else{
	$loginPopupAction 	= xoo_wsc_admin_settings()->is_plugin_installed('easy-login-woocommerce') ? 'Activate Plugin' : 'Install Plugin'; 
	$loginPopupTxt 		= 'This feature requires our separate login/register popup plugin.<br>
							<div class="xoo-wsc-el-links">
								<a target="nolink" class="xoo-wsc-el-install">'.$loginPopupAction.'</a>
								<a href="https://wordpress.org/plugins/easy-login-woocommerce/" target="_blank">Plugin Link</a>
							</div>
							';
}



$settings = array(

	/***** Shortcode ****/

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Add to menu',
		'id' 			=> 'shbk-menu',
		'section_id' 	=> 'sh_bk',
		'args' 			=> array(
			'options' 	=> $menuOptions
		),
		'default' 	=> 'none',
	),

	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Show',
		'id' 			=> 'shbk-show',
		'section_id' 	=> 'sh_bk',
		'args' 			=> array(
			'options' 	=> array(
				'icon' 			=> 'Icon',
				'subtotal' 		=> 'Subtotal',
				'count' 		=> 'Count',
			)
		),
		'default' 	=> array(
			'icon', 'subtotal', 'count',
		),
	),


	/** SIDE CART HEADER **/

	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Show',
		'id' 			=> 'sch-show',
		'section_id' 	=> 'sc_head',
		'args' 			=> array(
			'options' 	=> array(
				'notifications' => 'Notifications',
				'basket' 		=> 'Basket Icon',
				'save' 			=> 'Save for Later Icon',
				'close' 		=> 'Close Icon'
			),
		),
		'default' 	=> array(
			'notifications', 'basket', 'close' ,'save'
		)
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Show notification for seconds',
		'id' 			=> 'sch-notify-time',
		'section_id' 	=> 'sc_head',
		'default' 		=> '2000',
		'desc' 			=> '( 1 second = 1000 )'
	),


	/** SIDE CART BODY **/

	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Show',
		'id' 			=> 'scb-show',
		'section_id' 	=> 'sc_body',
		'args' 			=> array(
			'options' 	=> array(
				'total_sales' 	=> 'Product Sales Count',
				'product_image' => 'Product Image',
				'product_name' 	=> 'Product Name',
				'product_price' => 'Product Price',
				'product_total' => 'Product Total',
				'product_qty' 	=> 'Product Quantity',
				'product_meta' 	=> 'Product Meta ( Variations )',
				'product_link' 	=> 'Link to Product Page',
				'product_del'	=> 'Delete Product',
			),
		),
		'default' 	=> array(
			'total_sales', 'product_price', 'product_qty', 'product_total', 'product_name', 'product_link', 'product_del', 'product_image', 'product_meta', 'product_qty'
		)
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Quantiy & Price Display',
		'id' 			=> 'scbp-qpdisplay',
		'section_id' 	=> 'sc_body',
		'args' 			=> array(
			'options' 	=> array(
				'one_liner' => 'Show in one line',
				'separate' 	=> 'Show separately',
			),
		),
		'default' 		=> 'one_liner',
		'desc' 			=> 'When quantity update is not allowed'
	),



	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Allow quantity update',
		'id' 			=> 'scb-update-qty',
		'section_id' 	=> 'sc_body',
		'default' 		=> 'yes',
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Quantity Update Delay',
		'id' 			=> 'scb-update-delay',
		'section_id' 	=> 'sc_body',
		'default' 		=> '500',
		'desc' 			=> 'Wait before quantiy update request is sent to server ( 1 second = 1000 )'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Product Price',
		'id' 			=> 'scb-prod-price',
		'section_id' 	=> 'sc_body',
		'args' 			=> array(
			'options' 	=> array(
				'actual' 	=> 'Show only actual price',
				'sale'		=> 'Show regular and sale price',
			),
		),
		'default' 	=> 'actual',
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Show Variation in product title',
		'id' 			=> 'scb-pname-var',
		'section_id' 	=> 'sc_body',
		'args' 			=> array(
			'options' 	=> array(
				'no' 	=> 'No, show separately',
				'yes'	=> 'Yes',
			),
		),
		'default' 	=> 'no',
		'desc' 		=> 'If no is selected, make sure "Product Meta" is checked above to display variation data separately.'
	),



	/** SIDE CART FOOTER **/

	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Show',
		'id' 			=> 'scf-show',
		'section_id' 	=> 'sc_footer',
		'args' 			=> array(
			'options' 	=> array(
				'subtotal' 		=> 'Subtotal',
				'discount' 		=> 'Discount',
				'tax' 			=> 'Tax',
				'shipping' 		=> 'Shipping Amount',
				'shipping_calc' => 'Shipping Calculator',
				'fee' 			=> 'Other Fee',
				'total' 		=> 'Total',
				'coupon' 		=> 'Coupon List Toggle',
				'empty_cart' 	=> 'Empty Cart Link'
			),
		),
		'default' 	=> array(
			'subtotal', 'discount', 'tax', 'shipping', 'shipping_calc', 'fee', 'total', 'coupon', 'order_notes', 'empty_cart'
		)
	),


	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Payment Buttons',
		'id' 			=> 'scf-payment-btns',
		'section_id' 	=> 'sc_footer',
		'args' 			=> array(
			'options' 	=> array(
				'paypal' 		=> 'Paypal',
				'amazon' 		=> 'Amazon Pay',
				'gpay' 			=> 'Google & Apple Pay',
			),
		),
		'default' 	=> array(
			'gpay'
		),
		'desc' 			=> '<a href="https://docs.xootix.com/side-cart-for-woocommerce#payment_buttons" target="_blank">How to setup? Documentation</a>'
	),



	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Show total in checkout button',
		'id' 			=> 'scf-chkbtntotal-en',
		'section_id' 	=> 'sc_footer',
		'default' 		=> 'yes',
	),

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Open Login Slider/Popup on checkout',
		'id' 			=> 'scf-chklogin-en',
		'section_id' 	=> 'sc_footer',
		'default' 		=> 'no',
		'desc' 			=> 'Ask users to login/register before checkout. You can smoothen the checkout process by collecting the data.<br>'.$loginPopupTxt
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Hide footer text when cart is empty',
		'id' 			=> 'scf-ftext-hide',
		'section_id' 	=> 'sc_footer',
		'default' 		=> 'yes',
		'desc' 			=> 'Set footer text below under "Texts section" '
	),

	/*** PROGRESS BAR ***/

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Enable',
		'id' 			=> 'scbar-en',
		'section_id' 	=> 'sc_bar',
		'default' 		=> 'yes',
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Progress bar value as',
		'id' 			=> 'scbar-total',
		'section_id' 	=> 'sc_bar',
		'args' 			=> array(
			'options' 	=> array(
				'total'			=> 'Cart Total',
				'subtotal' 		=> 'Cart Subtotal',
				'subtotal_tax' 	=> 'Cart Subtotal including Tax'
			),
		),
		'default' 	=> 'subtotal_tax',
		'desc' 		=> 'The value to be used to fill the progress bar'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Bar Location',
		'id' 			=> 'scbar-pos',
		'section_id' 	=> 'sc_bar',
		'args' 			=> array(
			'options' 	=> array(
				'xoo_wsc_header_end'  	=> 'Header',
				'xoo_wsc_body_start' 	=> 'Before Products',
				'xoo_wsc_body_end' 		=> 'After Products',
				'xoo_wsc_footer_start' 	=> 'Footer Start',
				'xoo_wsc_footer_end' 	=> 'Footer end',
			),
		),
		'default' 	=> 'xoo_wsc_body_start',
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Divide bar',
		'id' 			=> 'scbar-divide',
		'section_id' 	=> 'sc_bar',
		'args' 			=> array(
			'options' 	=> array(
				'equal'	=> 'Equally',
				'prop' 	=> 'Proportionately',
			),
		),
		'default' 	=> 'equal',
	),


	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Show',
		'id' 			=> 'scbar-show',
		'section_id' 	=> 'sc_bar',
		'args' 			=> array(
			'options' 	=> array(
				'remaining' 	=> 'Remaining Text',
				'title' 		=> 'Title',
				'amount' 		=> 'Amount'
			),
		),
		'default' 	=> array(
			'remaining', 'title', 'amount'
		)
	),


	array(
		'callback' 		=> 'custombardata',
		'title' 		=> 'Checkpoints',
		'id' 			=> 'scbar-data',
		'section_id' 	=> 'sc_bar',
		'default' 		=> '',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Completed Text',
		'id' 			=> 'scbar-comptext',
		'section_id' 	=> 'sc_bar',
		'default' 		=> 'Congrats! you have unlocked all achievements.',
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Checkpoint completed celebration',
		'id' 			=> 'scbar-one-celebrate',
		'section_id' 	=> 'sc_bar',
		'args' 			=> array(
			'options' 	=> array(
				'none'			=> 'None',
				'SchoolPride' 	=> 'School Pride',
				'BasicCannon' 	=> 'Basic Cannon',
				'RealisticLook'	=> 'Realistic Look',
				'Stars' 		=> 'Stars',
				'Fireworks' 	=> 'Fireworks',
			),
		),
		'default' 	=> 'RealisticLook',
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'All Checkpoints completed Celebration',
		'id' 			=> 'scbar-all-celebrate',
		'section_id' 	=> 'sc_bar',
		'args' 			=> array(
			'options' 	=> array(
				'none'			=> 'None',
				'SchoolPride' 	=> 'School Pride',
				'BasicCannon' 	=> 'Basic Cannon',
				'RealisticLook'	=> 'Realistic Look',
				'Stars' 		=> 'Stars',
				'Fireworks' 	=> 'Fireworks',
			),
		),
		'default' 	=> 'SchoolPride',
	),



	/*** SUGGESTED PRODUCTS ***/

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Enable',
		'id' 			=> 'scsp-enable',
		'section_id' 	=> 'suggested_products',
		'default' 		=> 'yes',
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Display on mobile devices',
		'id' 			=> 'scsp-mob-enable',
		'section_id' 	=> 'suggested_products',
		'default' 		=> 'yes',
	),



	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Show',
		'id' 			=> 'scsp-show',
		'section_id' 	=> 'suggested_products',
		'args' 			=> array(
			'options' 	=> array(
				'image' 	=> 'Product Image',
				'title' 	=> 'Product Title',
				'price' 	=> 'Product Price',
				'addtocart' => 'Add to cart button',
			),
		),
		'default' 	=> array(
			'image', 'price', 'addtocart', 'title'
		)
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Products type',
		'id' 			=> 'scsp-type',
		'section_id' 	=> 'suggested_products',
		'args' 			=> array(
			'options' 	=> array(
				'cross_sells'	=> 'Cross-Sells',
				'related' 		=> 'Related',
				'up_sells'		=> 'Up-Sells'
			),
		),
		'default' 	=> 'related'
	),


	array(
		'callback' 		=> 'textarea',
		'title' 		=> 'Custom Product IDS',
		'id' 			=> 'scsp-ids',
		'section_id' 	=> 'suggested_products',
		'default' 		=> '',
		'desc' 			=> 'Product IDS separated by comma.',
		'args' 			=> array(
			'rows' => 2
		)
	),



	array(
		'callback' 		=> 'number',
		'title' 		=> 'Max number of products',
		'id' 			=> 'scsp-count',
		'section_id' 	=> 'suggested_products',
		'default' 		=> 5,
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Random Products',
		'id' 			=> 'scsp-random',
		'section_id' 	=> 'suggested_products',
		'default' 		=> 'yes',
		'desc' 			=> 'If cross sells/upsells mentioned above are not available, show other random products'
	),


	/** Save For Later **/
	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Enable',
		'id' 			=> 'sl-enable',
		'section_id' 	=> 'save_for_later',
		'default' 		=> 'yes',
	),

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Disable for guest users',
		'id' 			=> 'sl-disable-guest',
		'section_id' 	=> 'save_for_later',
		'default' 		=> 'no',
		'desc' 			=> 'Only allow logged in users to access "Save for Later". <br>You can also open login slider on icon click.'.$loginPopupTxt
	),

	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Show',
		'id' 			=> 'sl-show',
		'section_id' 	=> 'save_for_later',
		'args' 			=> array(
			'options' 	=> array(
				'image' 	=> 'Product Image',
				'title' 	=> 'Product Title',
				'price' 	=> 'Product Price',
				'addtocart' => 'Move to cart button',
			),
		),
		'default' 	=> array(
			'image', 'price', 'addtocart', 'title'
		)
	),


	/** MAIN **/

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Auto Open Cart',
		'id' 			=> 'm-auto-open',
		'section_id' 	=> 'main',
		'default' 		=> 'yes',
		'desc' 			=> 'When product is added to cart'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Ajax add to cart',
		'id' 			=> 'm-ajax-atc',
		'section_id' 	=> 'main',
		'args' 			=> array(
			'options' 	=> array(
				'yes' 		=> 'Yes',
				'cat_no' 	=> 'Yes, except product categories',
				'cat_yes' 	=> 'Yes, only for product categories',
				'no'		=> 'No',
			),
		),
		'default' 		=> 'yes',
		'desc' 			=> 'Add to cart without refreshing page'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Category IDs (Ajax add to cart)',
		'id' 			=> 'm-ajax-atc-catid',
		'section_id' 	=> 'main',
		'desc' 			=> 'Add your category IDs here. ( Separated by comma ). <br> <a href="https://woocommerce.com/document/find-product-category-ids/" target="_blank">Find Category ID</a>'
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Fly to Cart Animation',
		'id' 			=> 'm-flycart',
		'section_id' 	=> 'main',
		'default' 		=> 'yes',
		'desc' 			=> 'Works with ajax add to cart'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Cart Order',
		'id' 			=> 'm-cart-order',
		'section_id' 	=> 'main',
		'args' 			=> array(
			'options' 	=> array(
				'asc' 	=> 'Recently added item at the end of the cart.',
				'desc'	=> 'Recently added item on top',
			),
		),
		'default' 	=> 'asc',
		'desc' 		=> 'If you have bundle/composite products, choose at the end option'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Basket Count',
		'id' 			=> 'm-bk-count',
		'section_id' 	=> 'main',
		'args' 			=> array(
			'options' 	=> array(
				'quantity'	=> 'Sum of Quantity of all the products',
				'items' 	=> 'Number of products',
			),
		),
		'default' 	=> 'items'
	),



	array(
		'callback' 		=> 'select',
		'title' 		=> 'Coupons List',
		'id' 			=> 'm-cp-list',
		'section_id' 	=> 'main',
		'args' 			=> array(
			'options' 	=> array(
				'all'		=> 'Show All',
				'available' => 'Show only available',
				'hide' 		=> 'Do not show'
			),
		),
		'default' 	=> 'all'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Maximum coupouns count',
		'id' 			=> 'm-cp-count',
		'section_id' 	=> 'main',
		'default' 		=> 20,
	),

	array(
		'callback' 		=> 'textarea',
		'title' 		=> 'Custom coupons post ID',
		'id' 			=> 'm-cp-custom',
		'section_id' 	=> 'main',
		'default' 		=> '',
		'desc' 			=> 'Display only these coupons. Add coupons post ID separated by comma. Leave empty to list all'
	),

	array(
		'callback' 		=> 'textarea',
		'title' 		=> 'Do not show cart on pages',
		'id' 			=> 'm-hide-cart',
		'section_id' 	=> 'main',
		'default' 		=> '',
		'desc' 			=> 'Use post type/page id/slug separated by comma. For eg: post,contact-us,about-us .For all non woocommerce pages, use no-woocommerce'
	),

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Remove WC view cart link',
		'id' 			=> 'm-viewcart-del',
		'section_id' 	=> 'main',
		'default' 		=> 'no',
		'desc' 			=> 'Remove view cart button/link added by woocommerce on ajax add to cart',
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Tooltip',
		'id' 			=> 'm-tooltip',
		'section_id' 	=> 'main',
		'default' 		=> 'yes',
		'desc' 			=> 'Show action information on icon hover',
	),


	/***** TEXTS *****/
	array(
		'callback' 		=> 'text',
		'title' 		=> 'Cart Heading',
		'id' 			=> 'sct-cart-heading',
		'section_id' 	=> 'texts',
		'default' 		=> 'Your Cart',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Continue Button',
		'id' 			=> 'sct-ft-contbtn',
		'section_id' 	=> 'texts',
		'default' 		=> 'Continue Shopping',
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Cart Button',
		'id' 			=> 'sct-ft-cartbtn',
		'section_id' 	=> 'texts',
		'default' 		=> 'View Cart',
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Checkout Button',
		'id' 			=> 'sct-ft-chkbtn',
		'section_id' 	=> 'texts',
		'default' 		=> 'Checkout',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Empty Cart',
		'id' 			=> 'sct-empty',
		'section_id' 	=> 'texts',
		'default' 		=> 'Your cart is empty',
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Shop Button',
		'id' 			=> 'sct-shop-btn',
		'section_id' 	=> 'texts',
		'default' 		=> 'Return to Shop',
		'desc' 			=> 'Displays when cart is empty'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Subtotal',
		'id' 			=> 'sct-subtotal',
		'section_id' 	=> 'texts',
		'default' 		=> 'Subtotal',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Footer text',
		'id' 			=> 'sct-footer',
		'section_id' 	=> 'texts',
		'default' 		=> 'To find out your shipping cost , Please proceed to checkout.',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Delete button text',
		'id' 			=> 'sct-delete',
		'section_id' 	=> 'texts',
		'default' 		=> 'Remove',
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Suggested Products Heading',
		'id' 			=> 'sct-sp-txt',
		'section_id' 	=> 'texts',
		'default' 		=> "Products you might like",
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Saved for Later Heading',
		'id' 			=> 'sct-sl-txt',
		'section_id' 	=> 'texts',
		'default' 		=> "Saved For Later",
	),



	array(
		'callback' 		=> 'text',
		'title' 		=> 'Continue Shopping',
		'id' 			=> 'scu-continue',
		'section_id' 	=> 'urls',
		'default' 		=> '#',
		'desc' 			=> 'Use # to close side cart & remain on the same page'
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Cart',
		'id' 			=> 'scu-cart',
		'section_id' 	=> 'urls',
		'default' 		=> wc_get_cart_url(),
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Checkout',
		'id' 			=> 'scu-checkout',
		'section_id' 	=> 'urls',
		'default' 		=> wc_get_checkout_url(),
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Return to Shop',
		'id' 			=> 'm-shop-url',
		'section_id' 	=> 'urls',
		'default' 		=> get_permalink( wc_get_page_id( 'shop' ) ),
		'desc' 			=> 'Displays when cart is empty'
	),


);

return apply_filters( 'xoo_wsc_admin_settings', $settings, 'general' );

?>
