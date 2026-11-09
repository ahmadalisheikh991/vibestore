<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package VibeStore
 */

get_header();
?>

<main>
  <section class="section-padding">
    <div class="container">
      <div class="error-404-card">
        <p class="section-eyebrow" style="color:var(--color-champagne);">
          Error 404 — Page or Archive Piece Not Found
        </p>
        <h1 class="section-title" style="color:var(--color-alabaster);font-size:2.4rem;margin-top:0.5rem;">
          Looking for a Missing Archive Piece?
        </h1>
        <p style="font-size:0.92rem;color:rgba(230,223,211,0.8);max-width:520px;margin:0.85rem auto 2rem;">
          If you followed a broken link or a numbered seasonal release has
          moved to our permanent archive, use the links below or return to
          our main collection.
        </p>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>" class="btn btn-light">
            <span>Return to Home Page</span>
            <span>→</span>
          </a>
          <a href="<?php echo vibestore_page_url( 'shop' ); ?>" class="btn btn-glass">
            <span>Browse Full Shop</span>
          </a>
          <a href="<?php echo vibestore_page_url( 'contact' ); ?>" class="btn btn-glass">
            <span>Ask Client Concierge</span>
          </a>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();

