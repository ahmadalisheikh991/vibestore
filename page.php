<?php
/**
 * The template for displaying all default pages
 *
 * @package VibeStore
 */

get_header();
?>

<main>
  <?php
  while ( have_posts() ) :
    the_post();
    ?>
    <section class="page-hero-banner">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <span style="color:var(--color-obsidian);"><?php the_title(); ?></span>
        </nav>
        <h1 class="section-title" style="font-size:clamp(2.25rem, 4vw, 3.4rem);">
          <?php the_title(); ?>
        </h1>
      </div>
    </section>

    <section class="section-padding" style="padding-top: 3.5rem;">
      <div class="container">
        <div class="policy-section-card policy-prose">
          <?php the_content(); ?>
        </div>
      </div>
    </section>
  <?php endwhile; ?>
</main>

<?php
get_footer();

