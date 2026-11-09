<?php
/**
 * Template Name: About the Maison
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- MAIN ABOUT PAGE CONTENT -->
  <main>
    <!-- 3. EDITORIAL HERO BANNER -->
    <section class="page-hero-banner">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <span style="color:var(--color-obsidian);">About the Maison</span>
        </nav>
        <p class="section-eyebrow">Established MMXXII — Milan &amp; Paris</p>
        <h1 class="section-title" style="font-size:clamp(2.5rem, 4.5vw, 3.75rem);max-width:780px;">
          Architecture for the Human Silhouette.
        </h1>
        <p class="section-subtitle" style="margin-top:1rem;max-width:600px;">
          Vibe Store was founded on a singular conviction: true luxury whispers.
          We partner directly with family-owned Italian mills to create enduring
          wardrobe foundations stripped of excess noise.
        </p>
      </div>
    </section>

    <!-- 4. BRAND STORY SECTION -->
    <section class="section-padding">
      <div class="container about-story-grid">
        <div class="about-image-frame reveal-on-scroll">
          <img src="<?php echo vibestore_asset( 'images/banners/atelier-campaign.jpg' ); ?>" alt="Vibe Store Milanese Atelier" />
        </div>

        <div class="reveal-on-scroll">
          <p class="section-eyebrow">01 — Our Brand Story</p>
          <h2 class="section-title" style="margin-bottom:1.5rem;">
            Born in Milan. Built for Decades, Not Seasons.
          </h2>
          <p style="font-size:0.98rem;color:var(--color-charcoal);line-height:1.8;margin-bottom:1.25rem;">
            In a fashion landscape dominated by fleeting micro-trends and
            synthetic fast production, Vibe Store began as an intimate study of
            proportion, fabric weight, and tactile permanence. Working out of a
            sunlit courtyard studio near Via Montenapoleone, our founders set
            out to distill the modern wardrobe to its purest essentials.
          </p>
          <p style="font-size:0.98rem;color:var(--color-charcoal);line-height:1.8;margin-bottom:2rem;">
            Every coat, knit, and calfskin object is developed over six months
            of pattern refinement before a single numbered run is cut. We do not
            chase seasonal markdowns; instead, we build a continuous permanent
            collection where each piece complements the last.
          </p>

          <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:1.5rem;padding-top:1.75rem;border-top:1px solid var(--color-border);">
            <div>
              <p style="font-family:var(--font-serif);font-size:2.1rem;font-weight:600;color:var(--color-obsidian);line-height:1;">100%</p>
              <p style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.12em;color:var(--color-charcoal);margin-top:0.35rem;">Traceable Natural Fibers</p>
            </div>
            <div>
              <p style="font-family:var(--font-serif);font-size:2.1rem;font-weight:600;color:var(--color-obsidian);line-height:1;">14</p>
              <p style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.12em;color:var(--color-charcoal);margin-top:0.35rem;">Heritage Italian Workshops</p>
            </div>
            <div>
              <p style="font-family:var(--font-serif);font-size:2.1rem;font-weight:600;color:var(--color-obsidian);line-height:1;">0%</p>
              <p style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.12em;color:var(--color-charcoal);margin-top:0.35rem;">Virgin Plastics or Synthetics</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. OUR MISSION & OUR VISION SECTION -->
    <section class="section-padding" style="background-color:var(--color-stone);border-top:1px solid var(--color-border);border-bottom:1px solid var(--color-border);">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <div>
            <p class="section-eyebrow">02 — Guiding Principles</p>
            <h2 class="section-title">Our Mission &amp; Vision</h2>
          </div>
        </div>

        <div class="mission-vision-grid">
          <!-- Our Mission -->
          <article class="mv-card reveal-on-scroll">
            <div>
              <span class="section-eyebrow" style="color:var(--color-champagne);">Our Mission</span>
              <h3 class="section-title" style="font-size:2rem;margin-top:0.5rem;">
                To Elevate Daily Rituals Through Quiet Craftsmanship
              </h3>
              <p style="font-size:0.95rem;color:var(--color-charcoal);line-height:1.75;margin-top:1.25rem;">
                Our mission is to craft garments and leather goods of uncompromising
                integrity—connecting discerning collectors directly with Europe’s
                finest master artisans while maintaining complete transparency
                from pasture to wardrobe.
              </p>
            </div>
            <div style="margin-top:2.25rem;padding-top:1.25rem;border-top:1px solid var(--color-border);font-size:0.76rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--color-obsidian);font-weight:600;">
              Small-Batch • Hand-Finished • Certified Organic
            </div>
          </article>

          <!-- Our Vision -->
          <article class="mv-card dark-card reveal-on-scroll">
            <div>
              <span class="section-eyebrow" style="color:var(--color-champagne);">Our Vision</span>
              <h3 class="section-title" style="font-size:2rem;margin-top:0.5rem;color:var(--color-alabaster);">
                A Future Where Less Is Infinitely Better
              </h3>
              <p style="font-size:0.95rem;color:rgba(230,223,211,0.82);line-height:1.75;margin-top:1.25rem;">
                We envision a culture of deliberate consumption—where every piece
                in your closet is chosen with intention, repaired rather than
                discarded, and passed down as a modern heirloom with its own
                lived-in story.
              </p>
            </div>
            <div style="margin-top:2.25rem;padding-top:1.25rem;border-top:1px solid rgba(255,255,255,0.15);font-size:0.76rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--color-beige);font-weight:600;">
              Circular Care • Lifetime Repair Program • Carbon Neutral
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- 6. WHY CHOOSE VIBE STORE SECTION -->
    <section class="section-padding">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <div>
            <p class="section-eyebrow">03 — The Atelier Distinction</p>
            <h2 class="section-title">Why Choose Vibe Store</h2>
          </div>
          <p class="section-subtitle">
            Four uncompromising standards that separate a Vibe Store garment from
            conventional luxury retail.
          </p>
        </div>

        <div class="why-choose-grid">
          <div class="why-card reveal-on-scroll">
            <span class="why-number">I.</span>
            <h3 class="section-title" style="font-size:1.45rem;margin-bottom:0.75rem;">
              Grade-A Noble Fibers
            </h3>
            <p style="font-size:0.88rem;color:var(--color-charcoal);line-height:1.7;">
              We use exclusively 14.5-micron Inner Mongolian cashmere, extra-fine
              Australian merino, and full-grain vegetable-tanned Tuscan calfskin.
            </p>
          </div>

          <div class="why-card reveal-on-scroll">
            <span class="why-number">II.</span>
            <h3 class="section-title" style="font-size:1.45rem;margin-bottom:0.75rem;">
              Architectural Tailoring
            </h3>
            <p style="font-size:0.88rem;color:var(--color-charcoal);line-height:1.7;">
              Our patterns are engineered for fluid movement and unlined comfort—draping
              effortlessly across diverse body types without stiffness.
            </p>
          </div>

          <div class="why-card reveal-on-scroll">
            <span class="why-number">III.</span>
            <h3 class="section-title" style="font-size:1.45rem;margin-bottom:0.75rem;">
              Direct-to-Collector Value
            </h3>
            <p style="font-size:0.88rem;color:var(--color-charcoal);line-height:1.7;">
              By bypassing traditional department store markups, we offer true
              Milanese couture craftsmanship at honest atelier pricing.
            </p>
          </div>

          <div class="why-card reveal-on-scroll">
            <span class="why-number">IV.</span>
            <h3 class="section-title" style="font-size:1.45rem;margin-bottom:0.75rem;">
              White-Glove Concierge
            </h3>
            <p style="font-size:0.88rem;color:var(--color-charcoal);line-height:1.7;">
              Enjoy complimentary 48-hour global express shipping, cedar &amp; linen
              garment presentation, and effortless 30-day courier returns.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- 7. BRAND IMAGES & ATELIER LOOKBOOK SHOWCASE -->
    <section class="section-padding" style="padding-top:0;">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <div>
            <p class="section-eyebrow">04 — Inside the Studio</p>
            <h2 class="section-title">Atelier Visual Archive</h2>
          </div>
        </div>

        <div class="brand-gallery-grid">
          <div class="brand-gallery-item reveal-on-scroll">
            <img src="<?php echo vibestore_asset( 'images/banners/craftsmanship-banner.jpg' ); ?>" alt="Milan Studio Tailoring" loading="lazy" />
          </div>
          <div class="brand-gallery-item reveal-on-scroll">
            <img src="<?php echo vibestore_asset( 'images/products/trench-1.jpg' ); ?>" alt="Double-Faced Cashmere Drape" loading="lazy" />
          </div>
          <div class="brand-gallery-item reveal-on-scroll">
            <img src="<?php echo vibestore_asset( 'images/products/tote-1.jpg' ); ?>" alt="Tuscan Calfskin Leatherwork" loading="lazy" />
          </div>
        </div>
      </div>
    </section>

    <!-- 8. CALL-TO-ACTION SECTION -->
    <section class="section-padding" style="padding-top:0;">
      <div class="container">
        <div class="philosophy-banner reveal-on-scroll" style="margin-top:0;background-color:var(--color-obsidian);color:var(--color-alabaster);">
          <div>
            <p class="section-eyebrow" style="color:var(--color-champagne);">Experience the Collection</p>
            <h2 class="philosophy-quote" style="color:var(--color-alabaster);">
              Ready to build a timeless wardrobe of quiet luxury essentials?
            </h2>
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:1rem;flex-shrink:0;">
            <a href="<?php echo vibestore_page_url( 'shop' ); ?>" class="btn btn-light">
              <span>Explore the Shop</span>
              <span>→</span>
            </a>
            <a href="<?php echo vibestore_page_url( 'contact' ); ?>" class="btn btn-glass">
              <span>Contact Concierge</span>
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();

