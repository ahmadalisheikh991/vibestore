<?php
/**
 * Template Name: FAQ & Policies
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- MAIN FAQ, POLICIES & ADDITIONAL PAGES DIRECTORY -->
  <main>
    <section class="page-hero-banner">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <span style="color:var(--color-obsidian);">Client Care &amp; Legal Directory</span>
        </nav>
        <p class="section-eyebrow">Maison Transparency &amp; Support</p>
        <h1 class="section-title" style="font-size:clamp(2.25rem, 4vw, 3.4rem);">
          Frequently Asked Questions &amp; Policies
        </h1>
        <p class="section-subtitle" style="margin-top:0.65rem;max-width:600px;">
          Everything you need to know about our global express shipping, 30-day
          complimentary returns, bespoke sizing, privacy standards, and terms of service.
        </p>
      </div>
    </section>

    <section class="section-padding" style="padding-top: 3.5rem;">
      <div class="container policy-hub-layout">
        <!-- Left Sticky Directory Navigation -->
        <aside class="policy-sidebar-nav" aria-label="Policy Sections Navigation">
          <a href="#faq" class="policy-nav-link active">
            <span>01. Client FAQs</span>
            <span>→</span>
          </a>
          <a href="#shipping" class="policy-nav-link">
            <span>02. Shipping &amp; Returns</span>
            <span>→</span>
          </a>
          <a href="#sizing" class="policy-nav-link">
            <span>03. Bespoke Size Guide</span>
            <span>→</span>
          </a>
          <a href="#privacy" class="policy-nav-link">
            <span>04. Privacy Policy</span>
            <span>→</span>
          </a>
          <a href="#terms" class="policy-nav-link">
            <span>05. Terms &amp; Conditions</span>
            <span>→</span>
          </a>
          <a href="#not-found" class="policy-nav-link">
            <span>06. 404 Archive Locator</span>
            <span>→</span>
          </a>
        </aside>

        <!-- Right Content Sections -->
        <div>
          <!-- SECTION 01: FREQUENTLY ASKED QUESTIONS -->
          <div id="faq" class="policy-section-card">
            <p class="section-eyebrow">01 — Frequently Asked Questions</p>
            <h2 class="section-title" style="font-size:2rem;margin-bottom:1.5rem;">
              Client Care FAQ
            </h2>

            <div class="faq-accordion-list">
              <div class="faq-item open">
                <button type="button" class="faq-trigger">
                  <span>Where are Vibe Store garments designed and manufactured?</span>
                  <span class="faq-icon">−</span>
                </button>
                <div class="faq-body">
                  <p>
                    Every Vibe Store silhouette is drafted in our Milan studio near
                    Via Montenapoleone and produced in small numbered batches across
                    14 family-owned heritage workshops in Lombardy, Veneto, and
                    Tuscany. Each garment includes a woven batch label tracing its
                    mill of origin.
                  </p>
                </div>
              </div>

              <div class="faq-item">
                <button type="button" class="faq-trigger">
                  <span>How do I apply my 10% First-Order Privilege code?</span>
                  <span class="faq-icon">+</span>
                </button>
                <div class="faq-body">
                  <p>
                    Enter code <strong>VIBE10</strong> (or <strong>ATELIER10</strong>)
                    inside the Privilege Code field on the Shopping Bag page
                    (<a href="<?php echo vibestore_page_url( 'cart' ); ?>" style="text-decoration:underline;">Shopping Bag</a>)
                    before proceeding to checkout. Your 10% reduction is calculated
                    instantly.
                  </p>
                </div>
              </div>

              <div class="faq-item">
                <button type="button" class="faq-trigger">
                  <span>Are customs duties and import taxes included in the price?</span>
                  <span class="faq-icon">+</span>
                </button>
                <div class="faq-body">
                  <p>
                    Yes. All orders shipped to the European Union, United Kingdom,
                    Switzerland, United States, Canada, Japan, and the UAE are
                    dispatched on a DDP (Delivered Duty Paid) basis—meaning no
                    additional customs fees are ever requested upon delivery.
                  </p>
                </div>
              </div>

              <div class="faq-item">
                <button type="button" class="faq-trigger">
                  <span>Do you offer lifetime repair and garment care?</span>
                  <span class="faq-icon">+</span>
                </button>
                <div class="faq-body">
                  <p>
                    Yes. Every registered collector is covered by our Circular
                    Atelier Care program. Whether a horn button needs replacement or
                    a cashmere seam requires invisible re-linking after years of wear,
                    our Milan tailors restore your piece free of charge.
                  </p>
                </div>
              </div>

              <div class="faq-item">
                <button type="button" class="faq-trigger">
                  <span>Can I modify or cancel an order after placing it?</span>
                  <span class="faq-icon">+</span>
                </button>
                <div class="faq-body">
                  <p>
                    Orders can be modified or canceled within 2 hours of placement
                    by contacting <a href="<?php echo vibestore_page_url( 'contact' ); ?>" style="text-decoration:underline;">Client Concierge</a>
                    with your <code>VB-ORD-...</code> reference number. Once handed to DHL
                    Express, you may use our complimentary 30-day return service.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- SECTION 02: SHIPPING & RETURNS -->
          <div id="shipping" class="policy-section-card policy-prose">
            <p class="section-eyebrow">02 — Global Logistics &amp; Exchanges</p>
            <h2 class="section-title" style="font-size:2rem;margin-bottom:1rem;">
              Shipping &amp; Returns Policy
            </h2>
            <p>
              Every Vibe Store order is prepared by hand in our Milan atelier,
              steamed, encased in a breathable organic linen garment cover with
              aromatic cedarwood blocks, and sealed inside a weather-resistant
              architectural presentation box.
            </p>

            <h3>Complimentary Global Express Delivery</h3>
            <p>
              Orders totaling <strong>$250 or more</strong> qualify automatically
              for complimentary insured DHL Express delivery worldwide. Orders
              under $250 carry a flat $25 insured express rate.
            </p>
            <ul style="list-style:disc;padding-left:1.35rem;">
              <li><strong>Europe &amp; United Kingdom:</strong> 24 – 48 Hours</li>
              <li><strong>United States &amp; Canada:</strong> 36 – 48 Hours</li>
              <li><strong>Asia-Pacific &amp; Middle East:</strong> 48 – 72 Hours</li>
              <li><strong>White-Glove Same-Day Salon Courier ($35):</strong> Available within 4 hours in Milan, Paris, and New York.</li>
            </ul>

            <h3>30-Day Complimentary Returns &amp; Exchanges</h3>
            <p>
              We want every piece in your wardrobe to feel effortless. If a size
              or silhouette is not quite right, you may return or exchange any
              unworn item with its original tags and linen bag within
              <strong>30 days of delivery</strong> at zero cost. Complimentary
              DHL courier pickup from your home or office is included.
            </p>
          </div>

          <!-- SECTION 03: BESPOKE SIZE GUIDE -->
          <div id="sizing" class="policy-section-card policy-prose">
            <p class="section-eyebrow">03 — Architectural Proportions</p>
            <h2 class="section-title" style="font-size:2rem;margin-bottom:1rem;">
              Bespoke Sizing &amp; Measurement Guide
            </h2>
            <p>
              Our outerwear and knitwear are cut for a modern, relaxed-tailored
              drape. We recommend selecting your usual size for our signature
              runway proportion, or sizing down one size if you prefer a closer
              fit across the shoulders.
            </p>

            <table class="size-guide-table" aria-label="Garment Size Chart">
              <thead>
                <tr>
                  <th>Atelier Size</th>
                  <th>Italian / EU</th>
                  <th>US / UK</th>
                  <th>Chest / Bust (cm)</th>
                  <th>Waist (cm)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>XS</strong></td>
                  <td>38 / 44</td>
                  <td>2 / 34</td>
                  <td>82 – 86 cm</td>
                  <td>64 – 68 cm</td>
                </tr>
                <tr>
                  <td><strong>S</strong></td>
                  <td>40 / 46</td>
                  <td>4 / 36</td>
                  <td>87 – 91 cm</td>
                  <td>69 – 73 cm</td>
                </tr>
                <tr>
                  <td><strong>M</strong></td>
                  <td>42 / 48</td>
                  <td>6 – 8 / 38</td>
                  <td>92 – 97 cm</td>
                  <td>74 – 79 cm</td>
                </tr>
                <tr>
                  <td><strong>L</strong></td>
                  <td>44 / 50</td>
                  <td>10 / 40</td>
                  <td>98 – 103 cm</td>
                  <td>80 – 85 cm</td>
                </tr>
                <tr>
                  <td><strong>XL</strong></td>
                  <td>46 / 52</td>
                  <td>12 / 42</td>
                  <td>104 – 110 cm</td>
                  <td>86 – 92 cm</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- SECTION 04: PRIVACY POLICY -->
          <div id="privacy" class="policy-section-card policy-prose">
            <p class="section-eyebrow">04 — Data Protection &amp; Discretion</p>
            <h2 class="section-title" style="font-size:2rem;margin-bottom:1rem;">
              Privacy Policy
            </h2>
            <p>
              <em>Effective Date: November 2026 • GDPR &amp; CCPA Compliant</em>
            </p>
            <p>
              Vibe Store Maison S.r.l. respects the discretion and privacy of our
              collectors. We collect only the essential personal information
              required to fulfill your orders, store your bespoke garment sizing,
              and provide white-glove concierge assistance.
            </p>
            <h3>How We Use &amp; Protect Your Information</h3>
            <p>
              All client data is encrypted using 256-bit TLS security. We never
              sell, rent, or trade client names, email addresses, or purchase
              histories with third-party data brokers or external advertisers.
              You may request complete export or deletion of your client profile
              at any time by contacting <strong>privacy@vibestore.luxury</strong>.
            </p>
          </div>

          <!-- SECTION 05: TERMS & CONDITIONS -->
          <div id="terms" class="policy-section-card policy-prose">
            <p class="section-eyebrow">05 — Governance &amp; Authenticity</p>
            <h2 class="section-title" style="font-size:2rem;margin-bottom:1rem;">
              Terms &amp; Conditions
            </h2>
            <p>
              By accessing Vibe Store or placing an order through our online
              salon, you agree to the following terms governing the sale of our
              numbered luxury goods:
            </p>
            <h3>1. Intellectual Property &amp; Numbered Editions</h3>
            <p>
              All garment patterns, lookbook photography, video assets, and
              trademarks are the exclusive property of Vibe Store Maison. Because
              our capsules are produced in strictly limited runs, we reserve the
              right to limit quantities to 3 pieces per style per collector.
            </p>
            <h3>2. Pricing, Authenticity &amp; Warranty</h3>
            <p>
              All prices are listed in USD and include applicable value-added
              taxes. Every piece is guaranteed 100% authentic and backed by our
              two-year structural craftsmanship warranty alongside our lifetime
              atelier repair service.
            </p>
          </div>

          <!-- SECTION 06: 404 ERROR / ARCHIVE LOCATOR -->
          <div id="not-found" class="error-404-card">
            <p class="section-eyebrow" style="color:var(--color-champagne);">
              Error 404 — Page or Archive Piece Not Found
            </p>
            <h2 class="section-title" style="color:var(--color-alabaster);font-size:2.4rem;margin-top:0.5rem;">
              Looking for a Missing Archive Piece?
            </h2>
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
      </div>
    </section>
  </main>

<?php
get_footer();

