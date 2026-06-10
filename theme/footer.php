<?php
/**
 * Restora theme footer
 * 4-stolpčni dark footer + bottom strip
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
          <h3>Bodi prvi obveščen</h3>
          <p>Ekskluzivne ponudbe, novi izdelki in nasveti za boljši spanec.</p>
        </div>
        <form class="cal-newsletter-form" action="#" method="post" onsubmit="event.preventDefault();this.querySelector('button').textContent='✓ Hvala';">
          <input type="email" name="email" placeholder="Tvoj e-mail" required aria-label="E-mail">
          <button type="submit">Prijavi se</button>
        </form>
      </div>
    </div>

    <!-- Main footer columns -->
    <div class="cal-footer-main">
      <div class="cal-container cal-footer-grid">

        <div class="cal-footer-col cal-footer-brand">
          <div class="cal-footer-logo">RESTORA</div>
          <p class="cal-footer-tag">Ergonomske blazine za boljši spanec.<br>30 noči brez tveganja.</p>
          <div class="cal-footer-socials">
            <a href="#" aria-label="Instagram">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1" fill="currentColor"/></svg>
            </a>
            <a href="#" aria-label="Facebook">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
            <a href="#" aria-label="TikTok">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>
            </a>
            <a href="#" aria-label="YouTube">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 9s-.2-1.4-.8-2c-.7-.8-1.6-.8-2-.9C16.4 6 12 6 12 6s-4.4 0-7.2.2c-.4 0-1.3 0-2 .8-.6.6-.8 2-.8 2S2 10.6 2 12.3v1.4c0 1.7.2 3.3.2 3.3s.2 1.4.8 2c.7.8 1.7.8 2.1.9 1.5.1 6.9.2 6.9.2s4.4 0 7.2-.2c.4 0 1.3 0 2-.8.6-.6.8-2 .8-2s.2-1.6.2-3.3v-1.4c0-1.7-.2-3.3-.2-3.3zM10 15V9l5 3z" fill="currentColor"/></svg>
            </a>
          </div>
        </div>

        <div class="cal-footer-col">
          <h4>Trgovina</h4>
          <ul>
            <li><a href="#bundles">Restora blazina</a></li>
            <li><a href="#bundles">Paketi</a></li>
            <li><a href="#">Akcije</a></li>
            <li><a href="#">Darilni boni</a></li>
          </ul>
        </div>

        <div class="cal-footer-col">
          <h4>Podpora</h4>
          <ul>
            <li><a href="#faq">Pogosta vprašanja</a></li>
            <li><a href="#">Dostava in vračila</a></li>
            <li><a href="#">Garancija 30 noči</a></li>
            <li><a href="#">Kontakt</a></li>
          </ul>
        </div>

        <div class="cal-footer-col">
          <h4>O nas</h4>
          <ul>
            <li><a href="#">Naša zgodba</a></li>
            <li><a href="#reviews">Ocene strank</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Mediji</a></li>
          </ul>
          <div class="cal-footer-contact">
            <p><strong>Pomoč:</strong><br><a href="mailto:info@restora.si">info@restora.si</a></p>
          </div>
        </div>

      </div>
    </div>

    <!-- Bottom strip -->
    <div class="cal-footer-bottom">
      <div class="cal-container cal-footer-bottom-inner">
        <div class="cal-footer-copy">
          © <?php echo date('Y'); ?> Restora. Vse pravice pridržane.
        </div>
        <div class="cal-footer-legal">
          <a href="#">Pogoji uporabe</a>
          <a href="#">Politika zasebnosti</a>
          <a href="#">Piškotki</a>
          <a href="#">Politika vračila</a>
        </div>
        <div class="cal-footer-payments" aria-label="Sprejmemo">
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
