<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * @package WooCommerce\Templates\Emails
 * @version 10.0.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );
$store_name                 = $store_name ?? get_bloginfo( 'name', 'display' );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title><?php echo esc_html( $store_name ); ?></title>
</head>
<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
	<table width="100%" id="outer_wrapper">
		<tr>
			<td><!-- Empty cell for layout consistency --></td>
			<td width="600">
				<div style="padding: 4px 0;" id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
					<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="inner_wrapper">
						<tr>
							<td align="center" valign="top">

								<?php
								$img = get_option( 'woocommerce_email_header_image' );
								if ( apply_filters( 'woocommerce_is_email_preview', false ) ) {
									$img_transient = get_transient( 'woocommerce_email_header_image' );
									$img           = false !== $img_transient ? $img_transient : $img;
								}
								?>

								<!-- BEGIN: Custom Header Logo -->
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #000000; border-top-left-radius: 3px; border-top-right-radius: 3px;">
									<tr>
										<td align="center" valign="middle" style="height: 80px;">
											<?php if ( $img ) : ?>
												<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $store_name ); ?>" width="130" height="40" style="display: block; margin: 0 auto; vertical-align: middle; line-height: 80px;" />
											<?php else : ?>
												<p style="margin: 0; color: #ffffff; font-size: 20px; line-height: 80px;"><?php echo esc_html( $store_name ); ?></p>
											<?php endif; ?>
										</td>
									</tr>
								</table>
								<!-- END: Custom Header Logo -->

								<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_container">
									<tr>
										<td align="center" valign="top">
											<!-- Header -->
											<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header">
												<tr>
													<td id="header_wrapper">
														<h1><?php echo esc_html( $email_heading ); ?></h1>
													</td>
												</tr>
											</table>
											<!-- End Header -->
										</td>
									</tr>
									<tr>
										<td align="center" valign="top">
											<!-- Body -->
											<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_body">
												<tr>
													<td valign="top" id="body_content">
														<!-- Content -->
														<table border="0" cellpadding="20" cellspacing="0" width="100%">
															<tr>
																<td valign="top" id="body_content_inner_cell">
																	<div id="body_content_inner">
