<?php
/**
 * Template Name: Atelier Checkout
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- MAIN CHECKOUT CONTENT -->
  <main>
    <section class="page-hero-banner" style="padding: 2.75rem 0;">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <a href="<?php echo vibestore_page_url( 'cart' ); ?>">Shopping Bag</a>
          <span>/</span>
          <span style="color:var(--color-obsidian);">Atelier Checkout</span>
        </nav>
        <h1 class="section-title" style="font-size:clamp(2rem, 3.5vw, 2.85rem);">
          Complete Your Order
        </h1>
      </div>
    </section>

    <section class="section-padding" style="padding-top: 3rem;">
      <div class="container" id="checkout-page-root">
        <!-- Populated dynamically by initCheckoutPage() in js/script.js -->
      </div>
    </section>
  </main>

<?php
get_footer();

