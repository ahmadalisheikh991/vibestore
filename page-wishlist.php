<?php
/**
 * Template Name: Saved Wishlist
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- MAIN WISHLIST CONTENT -->
  <main>
    <section class="page-hero-banner">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <a href="<?php echo vibestore_page_url( 'shop' ); ?>">Shop</a>
          <span>/</span>
          <span style="color:var(--color-obsidian);">Saved Wishlist</span>
        </nav>
        <p class="section-eyebrow">Personal Shortlist</p>
        <h1 class="section-title" style="font-size:clamp(2.2rem, 3.8vw, 3.2rem);">
          Your Saved Atelier Wishlist
        </h1>
      </div>
    </section>

    <section class="section-padding" style="padding-top: 3.5rem;">
      <div class="container" id="wishlist-page-root">
        <!-- Populated dynamically by initWishlistPage() in js/script.js -->
      </div>
    </section>

    <!-- Curated Recommendations Section -->
    <section
      class="section-padding"
      style="background-color: var(--color-stone); border-top: 1px solid var(--color-border);"
    >
      <div class="container">
        <div class="section-header">
          <div>
            <p class="section-eyebrow">Complete Your Wardrobe</p>
            <h2 class="section-title">Recommended for You</h2>
          </div>
          <a href="<?php echo vibestore_page_url( 'shop' ); ?>" class="nav-link active">Explore All Pieces →</a>
        </div>

        <div id="wishlist-recommended-grid" class="product-grid"></div>
      </div>
    </section>
  </main>

<?php
get_footer();

