<?php
/**
 * Template Name: Client Account
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- MAIN LOGIN / MY ACCOUNT CONTENT -->
  <main>
    <section class="page-hero-banner" style="padding: 3rem 0;">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <span id="account-breadcrumb-current" style="color:var(--color-obsidian);">Client Account</span>
        </nav>
        <h1 id="account-hero-title" class="section-title" style="font-size:clamp(2.15rem, 3.8vw, 3.1rem);">
          Client Account
        </h1>
        <p id="account-hero-sub" class="section-subtitle" style="margin-top:0.5rem;">
          Access your private atelier profile, saved wishlist, and real-time order tracking.
        </p>
      </div>
    </section>

    <section class="section-padding" style="padding-top: 3.5rem;">
      <div class="container" id="account-page-root">
        <!-- Populated dynamically by initAccountPages() in js/script.js -->
      </div>
    </section>
  </main>

<?php
get_footer();

