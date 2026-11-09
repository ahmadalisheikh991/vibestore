<?php
/**
 * Template Name: Shopping Bag
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- MAIN SHOPPING CART CONTENT -->
  <main>
    <section class="page-hero-banner">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <a href="<?php echo vibestore_page_url( 'shop' ); ?>">Shop</a>
          <span>/</span>
          <span style="color:var(--color-obsidian);">Shopping Bag</span>
        </nav>
        <h1 class="section-title" style="font-size:clamp(2.2rem, 3.8vw, 3.1rem);">
          Your Atelier Shopping Bag
        </h1>
      </div>
    </section>

    <section class="section-padding" style="padding-top: 3.5rem;">
      <div class="container" id="cart-page-root">
        <!-- Populated dynamically by initCartPage() in js/script.js -->
      </div>
    </section>
  </main>

<?php
get_footer();

