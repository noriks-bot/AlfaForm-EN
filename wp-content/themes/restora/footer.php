<?php
/**
 * Nordform theme footer
 * 4-column dark footer + bottom strip
 *
 * @package restora
 */
?>
  </div><!-- #content -->

  <?php /* boris-hide-hf */ if ( ! ( function_exists( 'is_cart' ) && is_cart() ) ) : ?>
  <footer class="cal-footer" role="contentinfo">

    <!-- Newsletter strip -->
    <div class="cal-footer-newsletter">
      <div class="cal-container cal-footer-newsletter-inner">
        <div class="cal-footer-newsletter-text">
          <h3>Be the first to know</h3>
          <p>Exclusive offers, new products and Exclusive offers, new products and posture tips.</p>
        </div>
        <form class="cal-newsletter-form" action="#" method="post" onsubmit="event.preventDefault();this.querySelector('button').textContent='✓ Thanks';">
          <input type="email" name="email" placeholder="Your e-mail" required aria-label="E-mail">
          <button type="submit">Sign up</button>
        </form>
      </div>
    </div>

    <!-- Main footer columns -->
    <div class="cal-footer-main">
      <div class="cal-container cal-footer-grid">

        <div class="cal-footer-col cal-footer-brand">
          <div class="cal-footer-logo">NORDFORM</div>
          <p class="cal-footer-tag">Posture support that helps you<br>stand taller and move better.</p>
          <div class="cal-footer-socials">
            <a href="#" aria-label="Instagram"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1" fill="currentColor"/></svg></a>
            <a href="#" aria-label="Facebook"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
            <a href="#" aria-label="TikTok"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg></a>
          </div>
        </div>

        <div class="cal-footer-col">
          <h4>Shop</h4>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/product/nordform-experience-the-shift-in-shape-posture/' ) ); ?>">Nordform</a></li>
            <li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">Shop all</a></li>
            <li><a href="#">Deals</a></li>
            <li><a href="#">Gift cards</a></li>
          </ul>
        </div>

        <div class="cal-footer-col">
          <h4>Support</h4>
          <ul>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Shipping &amp; returns</a></li>
            <li><a href="#">30-day guarantee</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>

        <div class="cal-footer-col">
          <h4>About</h4>
          <ul>
            <li><a href="#">Our story</a></li>
            <li><a href="#">Customer reviews</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
          <div class="cal-footer-contact">
            <p><strong>Support:</strong><br><a href="mailto:info@info@nordform.si">info@info@nordform.si</a></p>
          </div>
        </div>

      </div>
    </div>

    <!-- Bottom strip -->
    <div class="cal-footer-bottom">
      <div class="cal-container cal-footer-bottom-inner">
        <div class="cal-footer-copy">
          © <?php echo date('Y'); ?> Nordform. All rights reserved.
        </div>
        <div class="cal-footer-legal">
          <a href="#">Terms of Use</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Cookies</a>
          <a href="#">Refund Policy</a>
        </div>
        <div class="cal-footer-payments" aria-label="We accept">
          <span class="cal-pay">VISA</span>
          <span class="cal-pay">MC</span>
          <span class="cal-pay">PAYPAL</span>
          <span class="cal-pay">KLARNA</span>
          <span class="cal-pay">APPLE PAY</span>
        </div>
      </div>
    </div>

  </footer>
  <?php endif; ?>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
