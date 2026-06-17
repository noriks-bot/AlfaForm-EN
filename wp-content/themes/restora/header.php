<?php
/**
 * Nordform theme header
 * Announcement bar + sticky header (logo center + cart)
 *
 * @package restora
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<?php wp_head(); ?>
</head>

<body <?php body_class( 'restora-body' ); ?>>

<?php wp_body_open(); ?>

<div id="page" class="restora-site">

  <?php /* boris-hide-hf */ if ( ! ( ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) ) ) : ?>
  <!-- Announcement bar -->
  <div class="cal-announce" role="region" aria-label="Promotions">
    <div class="cal-announce-track">
      <div class="cal-announce-content">
        <span>★ 4.8/5 · 12,000+ happy customers</span>
        <span>🚚 FREE shipping over 70€</span>
        <span>↩ 30-day risk-free — money back</span>
        <span>🔒 Secure payment · SSL encrypted</span>
        <span>★ 4.8/5 · 12,000+ happy customers</span>
        <span>🚚 FREE shipping over 70€</span>
        <span>↩ 30-day risk-free — money back</span>
        <span>🔒 Secure payment · SSL encrypted</span>
      </div>
    </div>
  </div>

  <!-- Main header -->
  <header class="cal-header" role="banner">
    <div class="cal-header-inner">

      <div class="cal-header-left">
        <button class="cal-menu-btn" aria-label="Menu" onclick="document.body.classList.toggle('cal-menu-open')">
          <span></span><span></span><span></span>
        </button>
        <nav class="cal-nav-desktop" aria-label="Main menu">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
          <a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">Shop</a>
          <a href="<?php echo esc_url( home_url( '/product/nordform-experience-the-shift-in-shape-posture/' ) ); ?>">Nordform</a>
        </nav>
      </div>

      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cal-logo" aria-label="Nordform">
        <span class="cal-logo-text">NORDFORM</span>
      </a>

      <div class="cal-header-right">
        <a href="<?php echo function_exists('wc_get_cart_url') ? esc_url( wc_get_cart_url() ) : '/cart'; ?>" class="cal-icon-btn cal-cart-btn" aria-label="Cart">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h2l2.4 12.4a2 2 0 0 0 2 1.6h9.6a2 2 0 0 0 2-1.6L23 6H6"/><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/></svg>
          <span class="cal-cart-count"><?php echo function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?></span>
        </a>
      </div>

    </div>

    <div class="cal-mobile-drawer">
      <nav class="cal-nav-mobile" aria-label="Mobile menu">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
        <a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">Shop</a>
        <a href="<?php echo esc_url( home_url( '/product/nordform-experience-the-shift-in-shape-posture/' ) ); ?>">Nordform</a>
        <a href="<?php echo esc_url( site_url( '/my-account/' ) ); ?>">My account</a>
      </nav>
    </div>
  </header>
  <?php endif; ?>

  <div id="content" class="cal-site-content">
