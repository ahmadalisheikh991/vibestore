<?php
/**
 * The front page template file (Homepage)
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- MAIN HOMEPAGE CONTENT -->
  <main>
    <!-- 3. FULL-WIDTH BACKGROUND VIDEO HERO SECTION -->
    <section class="hero-section">
      <video
        id="hero-bg-video"
        class="hero-video"
        autoplay
        loop
        muted
        playsinline
        poster="<?php echo vibestore_asset( 'images/banners/atelier-campaign.jpg' ); ?>"
      >
        <source src="<?php echo vibestore_asset( 'videos/hero-video.mp4' ); ?>" type="video/mp4" />
      </video>

      <div class="hero-overlay" aria-hidden="true"></div>

      <div class="hero-content">
        <div class="hero-eyebrow">
          <span>✦</span>
          <span>Autumn / Winter 2026 — Architectural Quiet Luxury</span>
        </div>

        <h1 class="hero-headline">
          Timeless Form. <em>Uncompromising</em> Craft.
        </h1>

        <p class="hero-description">
          Discover sculpted Italian cashmere, vegetable-tanned leather goods,
          and minimalist silhouettes designed to transcend seasons.
        </p>

        <div class="hero-cta-group">
          <a href="<?php echo vibestore_page_url( 'shop' ); ?>" class="btn btn-light">
            <span>Shop Now</span>
            <span>→</span>
          </a>
          <a href="#featured-categories" class="btn btn-glass">
            <span>Explore Collection</span>
          </a>
        </div>

        <div class="hero-metrics">
          <div>
            <div class="hero-metric-val">100%</div>
            <div class="hero-metric-label">Traceable Cashmere &amp; Wool</div>
          </div>
          <div>
            <div class="hero-metric-val">Milan</div>
            <div class="hero-metric-label">Small-Batch Atelier Craft</div>
          </div>
          <div>
            <div class="hero-metric-val">48 Hr</div>
            <div class="hero-metric-label">Complimentary Express Ship</div>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. FEATURED CATEGORIES SECTION -->
    <section id="featured-categories" class="section-padding">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <div>
            <p class="section-eyebrow">Architectural Wardrobe</p>
            <h2 class="section-title">Featured Categories</h2>
          </div>
          <p class="section-subtitle">
            Explore our four foundational pillars—each defined by clean geometry,
            tactile natural fibers, and enduring versatility.
          </p>
        </div>

        <div class="categories-bento">
          <a href="<?php echo vibestore_page_url( 'shop', '?category=Outerwear' ); ?>" class="category-card reveal-on-scroll">
            <img src="<?php echo vibestore_asset( 'images/categories/outerwear.jpg' ); ?>" alt="Outerwear & Tailoring" loading="lazy" />
            <div class="category-card-overlay"></div>
            <div class="category-card-content">
              <span class="category-card-count">14 Curated Pieces</span>
              <h3 class="category-card-title">Outerwear &amp; Tailoring</h3>
              <span class="category-card-cta">Explore Atelier →</span>
            </div>
          </a>

          <a href="<?php echo vibestore_page_url( 'shop', '?category=Knitwear' ); ?>" class="category-card reveal-on-scroll">
            <img src="<?php echo vibestore_asset( 'images/categories/knitwear.jpg' ); ?>" alt="Architectural Knitwear" loading="lazy" />
            <div class="category-card-overlay"></div>
            <div class="category-card-content">
              <span class="category-card-count">18 Curated Pieces</span>
              <h3 class="category-card-title">Merino &amp; Cashmere Knitwear</h3>
              <span class="category-card-cta">Explore Atelier →</span>
            </div>
          </a>

          <a href="<?php echo vibestore_page_url( 'shop', '?category=Leather+Goods' ); ?>" class="category-card reveal-on-scroll">
            <img src="<?php echo vibestore_asset( 'images/categories/leather-goods.jpg' ); ?>" alt="Italian Leather Goods" loading="lazy" />
            <div class="category-card-overlay"></div>
            <div class="category-card-content">
              <span class="category-card-count">12 Curated Pieces</span>
              <h3 class="category-card-title">Italian Leather Goods</h3>
              <span class="category-card-cta">Explore Atelier →</span>
            </div>
          </a>

          <a href="<?php echo vibestore_page_url( 'shop', '?category=Accessories' ); ?>" class="category-card reveal-on-scroll">
            <img src="<?php echo vibestore_asset( 'images/categories/accessories.jpg' ); ?>" alt="Minimalist Accessories" loading="lazy" />
            <div class="category-card-overlay"></div>
            <div class="category-card-content">
              <span class="category-card-count">9 Curated Pieces</span>
              <h3 class="category-card-title">Sculptural Accessories</h3>
              <span class="category-card-cta">Explore Atelier →</span>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- 5. TRENDING PRODUCTS SECTION WITH INTERACTIVE FILTER TABS -->
    <section id="trending-section" class="section-padding" style="background-color: var(--color-stone); border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <div>
            <p class="section-eyebrow">Most Coveted Now</p>
            <h2 class="section-title">Trending Atelier Pieces</h2>
          </div>

          <!-- Interactive Filter Tabs -->
          <div class="filter-tabs" role="tablist" aria-label="Product Collection Filter">
            <button type="button" class="filter-tab-btn active" data-filter-tab="trending">
              Trending Now
            </button>
            <button type="button" class="filter-tab-btn" data-filter-tab="bestseller">
              Best Sellers
            </button>
            <button type="button" class="filter-tab-btn" data-filter-tab="new">
              New Releases
            </button>
            <button type="button" class="filter-tab-btn" data-filter-tab="all">
              All Curated
            </button>
          </div>
        </div>

        <div id="trending-products-grid" class="product-grid"></div>
      </div>
    </section>

    <!-- 6. BEST-SELLING SIGNATURE PIECES SECTION -->
    <section id="bestsellers-section" class="section-padding">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <div>
            <p class="section-eyebrow">Client Favorites — Permanent Collection</p>
            <h2 class="section-title">Best-Selling Icons</h2>
          </div>
          <a href="<?php echo vibestore_page_url( 'shop' ); ?>" class="btn btn-primary">
            <span>View All Products</span>
            <span>→</span>
          </a>
        </div>

        <div id="bestsellers-products-grid" class="product-grid"></div>
      </div>
    </section>

    <!-- 7. PROMOTIONAL EDITORIAL BANNERS SECTION (STEP 4B) -->
    <section id="promotional-banners" class="section-padding" style="padding-top: 1rem;">
      <div class="container">
        <!-- Split Editorial Campaign Showcase -->
        <div class="promo-split-grid reveal-on-scroll">
          <div class="promo-media">
            <img src="<?php echo vibestore_asset( 'images/banners/craftsmanship-banner.jpg' ); ?>" alt="Milanese Atelier Craftsmanship" loading="lazy" />
          </div>
          <div class="promo-content">
            <span class="promo-tag">Limited Capsule — Autumn / Winter 2026</span>
            <h2 class="promo-title">
              The Architecture of Unlined Cashmere.
            </h2>
            <p class="promo-text">
              Every double-faced coat in our Milanese studio requires 18 hours
              of hand-finishing by master tailors—resulting in weightless
              warmth that drapes like liquid silk.
            </p>

            <div class="promo-pillars">
              <div>
                <p class="promo-pillar-title">Grade-A Mongolian</p>
                <p class="promo-pillar-sub">14.5 Micron Ultra-Fine Fiber</p>
              </div>
              <div>
                <p class="promo-pillar-title">Numbered Edition</p>
                <p class="promo-pillar-sub">Strictly 150 Pieces Worldwide</p>
              </div>
            </div>

            <div style="display:flex;flex-wrap:wrap;gap:1rem;">
              <a href="<?php echo vibestore_page_url( 'shop', '?category=Outerwear' ); ?>" class="btn btn-light">
                <span>Shop Capsule</span>
                <span>→</span>
              </a>
              <a href="<?php echo vibestore_page_url( 'about' ); ?>" class="btn btn-glass">
                <span>Discover Our Craft</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Dual Secondary Promotional Callout Cards -->
        <div class="promo-dual-grid">
          <div class="promo-mini-card reveal-on-scroll">
            <div>
              <p class="section-eyebrow">Complimentary Service</p>
              <h3 class="section-title" style="font-size:1.75rem;">
                Signature Linen &amp; Cedar Gift Presentation
              </h3>
              <p style="font-size:0.88rem;color:var(--color-charcoal);margin-top:0.65rem;max-width:440px;">
                Every order arrives encased in reusable organic linen garment
                bags with aromatic cedarwood blocks and a handwritten note.
              </p>
            </div>
            <div style="margin-top:1.75rem;">
              <a href="<?php echo vibestore_page_url( 'shop' ); ?>" class="nav-link active" style="font-weight:600;">
                Explore Gifting Suite →
              </a>
            </div>
          </div>

          <div class="promo-mini-card dark-tone reveal-on-scroll">
            <div>
              <p class="section-eyebrow">Private Client Styling</p>
              <h3 class="section-title" style="font-size:1.75rem;">
                One-on-One Virtual &amp; Salon Appointments
              </h3>
              <p style="font-size:0.88rem;color:var(--color-charcoal);margin-top:0.65rem;max-width:440px;">
                Consult with our senior wardrobe directors in Milan, Paris, or
                online for bespoke sizing and capsule curation.
              </p>
            </div>
            <div style="margin-top:1.75rem;">
              <a href="<?php echo vibestore_page_url( 'contact' ); ?>" class="nav-link active" style="font-weight:600;">
                Book Private Consultation →
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 8. NEW ARRIVALS SECTION (STEP 4B) -->
    <section id="new-arrivals-section" class="section-padding" style="background-color: var(--color-stone); border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <div>
            <p class="section-eyebrow">Just Landed in Salon</p>
            <h2 class="section-title">New Arrivals</h2>
          </div>
          <p class="section-subtitle">
            Freshly released silhouettes from our latest numbered studio drop—crafted
            in small batches for immediate wardrobe elevation.
          </p>
        </div>

        <div id="new-arrivals-grid" class="product-grid"></div>
      </div>
    </section>

    <!-- 9. CUSTOMER TESTIMONIALS SECTION (STEP 4B) -->
    <section id="testimonials-section" class="section-padding">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <div>
            <p class="section-eyebrow">Client Voices — 4.9 / 5.0 Average Rating</p>
            <h2 class="section-title">Words From Our Collectors</h2>
          </div>
          <p class="section-subtitle">
            Read verified impressions from architects, creative directors, and
            collectors who live in Vibe Store essentials around the world.
          </p>
        </div>

        <div class="testimonials-grid">
          <article class="testimonial-card reveal-on-scroll">
            <div>
              <div class="testimonial-stars" aria-label="5 out of 5 stars">★★★★★</div>
              <p class="testimonial-quote">
                “The Atelier Double-Faced Cashmere Trench rivals coats three
                times its price from heritage Parisian houses. The drape and
                hand-feel are extraordinary.”
              </p>
            </div>
            <div class="testimonial-author">
              <div>
                <p class="testimonial-name">Camille Laurent</p>
                <p class="testimonial-meta">Interior Architect • Paris, France</p>
              </div>
              <span class="verified-pill">Verified Buyer</span>
            </div>
          </article>

          <article class="testimonial-card reveal-on-scroll">
            <div>
              <div class="testimonial-stars" aria-label="5 out of 5 stars">★★★★★</div>
              <p class="testimonial-quote">
                “I carry the Sculpted Calfskin Tote daily between my studio and
                client flights. Six months in, the vegetable-tanned leather has
                developed a gorgeous patina.”
              </p>
            </div>
            <div class="testimonial-author">
              <div>
                <p class="testimonial-name">Julian Vance</p>
                <p class="testimonial-meta">Creative Director • New York, NY</p>
              </div>
              <span class="verified-pill">Verified Buyer</span>
            </div>
          </article>

          <article class="testimonial-card reveal-on-scroll">
            <div>
              <div class="testimonial-stars" aria-label="5 out of 5 stars">★★★★★</div>
              <p class="testimonial-quote">
                “From the cedar-scented linen packaging to the weightless
                merino knitwear, every touchpoint feels intentional, quiet, and
                deeply luxurious.”
              </p>
            </div>
            <div class="testimonial-author">
              <div>
                <p class="testimonial-name">Elena Rostova</p>
                <p class="testimonial-meta">Gallery Curator • Zurich, Switzerland</p>
              </div>
              <span class="verified-pill">Verified Buyer</span>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- 10. DEDICATED NEWSLETTER SUBSCRIPTION SECTION (STEP 4B) -->
    <section id="newsletter-section" class="section-padding" style="padding-top: 0;">
      <div class="container">
        <div class="newsletter-section-box reveal-on-scroll">
          <div>
            <p class="section-eyebrow">The Inner Circle</p>
            <h2 class="section-title">Join the Private Atelier List</h2>
            <p style="margin-top:0.85rem;font-size:0.95rem;color:var(--color-charcoal);max-width:520px;">
              Subscribe for 48-hour early access to numbered capsule releases,
              private lookbooks, and complimentary express shipping on your
              first atelier order.
            </p>
            <div class="newsletter-perks">
              <span>✓ 10% First-Order Privilege</span>
              <span>✓ Early Capsule Access</span>
              <span>✓ Zero Spam, Unsubscribe Anytime</span>
            </div>
          </div>

          <div>
            <form
              id="homepage-newsletter-form"
              class="newsletter-box-form"
              onsubmit="event.preventDefault(); window.showVibeToast('Thank you for joining the Private Atelier List. Check your inbox for your 10% privilege code.'); this.reset();"
            >
              <input
                type="email"
                class="newsletter-box-input"
                placeholder="Enter your email address..."
                required
                aria-label="Email Address"
              />
              <button type="submit" class="btn btn-primary">
                <span>Subscribe</span>
                <span>→</span>
              </button>
            </form>
            <p style="font-size:0.72rem;color:var(--color-charcoal);margin-top:0.75rem;">
              By subscribing, you agree to our <a href="<?php echo vibestore_page_url( 'faq', '#privacy' ); ?>" style="text-decoration:underline;">Privacy Policy</a> and <a href="<?php echo vibestore_page_url( 'faq', '#terms' ); ?>" style="text-decoration:underline;">Terms</a>.
            </p>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();

