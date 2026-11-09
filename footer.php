<?php
/**
 * The template for displaying the footer
 *
 * @package VibeStore
 */

$current_route = vibestore_current_route();
$is_checkout   = ( 'checkout' === $current_route );
?>

  <!-- COMPLETE PROFESSIONAL FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <?php if ( ! $is_checkout ) : ?>
      <div class="footer-grid">
        <div>
          <span class="brand-logo-main" style="color:var(--color-alabaster);">VIBE STORE</span>
          <p class="footer-brand-desc">
            Modern luxury minimal essentials. Designed with architectural
            precision and crafted from traceable natural materials in small
            numbered batches.
          </p>
          <p class="footer-cities">Milan • Paris • New York • Tokyo</p>
          <div class="footer-socials">
            <a href="https://instagram.com" target="_blank" rel="noreferrer" class="social-pill">Instagram</a>
            <a href="https://pinterest.com" target="_blank" rel="noreferrer" class="social-pill">Pinterest</a>
            <a href="https://linkedin.com" target="_blank" rel="noreferrer" class="social-pill">Editorial</a>
          </div>
        </div>

        <div>
          <h4 class="footer-heading">Collections</h4>
          <ul class="footer-links">
            <li><a href="<?php echo vibestore_page_url( 'shop', '?category=Outerwear' ); ?>">Outerwear &amp; Coats</a></li>
            <li><a href="<?php echo vibestore_page_url( 'shop', '?category=Knitwear' ); ?>">Merino &amp; Cashmere</a></li>
            <li><a href="<?php echo vibestore_page_url( 'shop', '?category=Leather+Goods' ); ?>">Italian Leather Goods</a></li>
            <li><a href="<?php echo vibestore_page_url( 'shop', '?category=Accessories' ); ?>">Minimalist Accessories</a></li>
            <li><a href="<?php echo vibestore_page_url( 'shop' ); ?>">New Arrivals</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-heading">Maison &amp; Care</h4>
          <ul class="footer-links">
            <li><a href="<?php echo vibestore_page_url( 'about' ); ?>">Our Brand Story</a></li>
            <li><a href="<?php echo vibestore_page_url( 'contact' ); ?>">Contact Concierge</a></li>
            <li><a href="<?php echo vibestore_page_url( 'faq' ); ?>">Frequently Asked Questions</a></li>
            <li><a href="<?php echo vibestore_page_url( 'faq', '#shipping' ); ?>">Shipping &amp; Returns</a></li>
            <li><a href="<?php echo vibestore_page_url( 'login' ); ?>">Client Account</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-heading">Private Atelier Concierge</h4>
          <p class="footer-brand-desc" style="margin-top:0;">
            Monday – Saturday, 9:00 AM – 7:00 PM CET<br />
            <strong style="color:var(--color-beige);font-weight:500;">concierge@vibestore.luxury</strong><br />
            Via Montenapoleone 18, 20121 Milano MI
          </p>
          <form class="newsletter-form" onsubmit="event.preventDefault(); window.showVibeToast('Subscribed to Private Atelier dispatches.'); this.reset();">
            <input type="email" placeholder="Quick journal signup..." required />
            <button type="submit">Join →</button>
          </form>
        </div>
      </div>
      <?php endif; ?>

      <div class="footer-bottom" <?php echo $is_checkout ? 'style="padding-top:0;"' : ''; ?>>
        <p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> VIBE STORE MAISON. All rights reserved.</p>
        <div class="payment-methods" aria-label="Accepted Payment Methods">
          <span class="payment-tag">Visa</span>
          <span class="payment-tag">Mastercard</span>
          <span class="payment-tag">Amex</span>
          <span class="payment-tag">Apple Pay</span>
          <span class="payment-tag">Klarna</span>
        </div>
        <div class="footer-bottom-links">
          <a href="<?php echo vibestore_page_url( 'faq', '#privacy' ); ?>">Privacy Policy</a>
          <a href="<?php echo vibestore_page_url( 'faq', '#terms' ); ?>">Terms &amp; Conditions</a>
          <a href="<?php echo vibestore_page_url( 'faq', '#shipping' ); ?>">Shipping &amp; Returns</a>
        </div>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>

