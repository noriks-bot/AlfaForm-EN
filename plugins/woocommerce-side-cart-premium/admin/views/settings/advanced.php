<?php

$settings = array(

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Refresh Cart',
		'id' 			=> 'm-fetch-cart',
		'section_id' 	=> 'av_main',
		'args' 			=> array(
			'options' 	=> array(
				'page_load' => 'On Page load',
				'cart_open' => 'On cart open',
				'disable' 	=> 'Disable'
			), 
		),
		'default' 		=> 'cart_open',
		'desc' 			=> "This will send a new server request to fetch cart contents.<br>You can also set it to disabled once you are done customizing side cart.<br>Keep this option enabled if you see outdated cart items or cart items do not match with actual cart"
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Refresh Cart on add to cart',
		'id' 			=> 'm-refresh-cart',
		'section_id' 	=> 'av_main',
		'default' 		=> 'no',
		'desc' 			=> '<b>NOTE - Enable this option only if the cart is not showing correct prices.</b>'
	),

	array(
		'callback' 		=> 'textarea',
		'title' 		=> 'Custom CSS',
		'id' 			=> 'm-custom-css',
		'section_id' 	=> 'av_main',
		'default' 		=> '',
		'args' 			=> array(
			'rows' => 20,
			'cols' => 70
		)
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Open side cart class',
		'id' 			=> 'm-trigger-class',
		'section_id' 	=> 'av_main',
		'default' 		=> "",
		'desc' 			=> 'You can use class xoo-wsc-cart-trigger to open side cart or add your own class here',
	),

);


return apply_filters( 'xoo_wsc_admin_settings', $settings, 'advanced' );

?>