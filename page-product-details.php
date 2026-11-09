<?php
/**
 * Template Name: Product Details
 * Single Product Page with Size, Color & Variation Options
 *
 * @package VibeStore
 */

get_header();

$pdp_product = vibestore_get_current_pdp_product();
$pdp_cat     = $pdp_product ? $pdp_product['category'] : 'Outerwear';
$pdp_name    = $pdp_product ? $pdp_product['name'] : 'Atelier Piece';
$pdp_id      = $pdp_product ? $pdp_product['id'] : 'vibe-001';
$pdp_price   = $pdp_product ? $pdp_product['price'] : 680;
$pdp_orig    = ! empty( $pdp_product['originalPrice'] ) ? $pdp_product['originalPrice'] : 0;
$pdp_rating  = $pdp_product ? $pdp_product['rating'] : 4.9;
$pdp_reviews = $pdp_product ? $pdp_product['reviewsCount'] : 24;
$pdp_badge   = ! empty( $pdp_product['badge'] ) ? $pdp_product['badge'] : '';
$pdp_desc    = $pdp_product ? ( $pdp_product['description'] ?: $pdp_product['shortDescription'] ) : '';
$pdp_images  = ! empty( $pdp_product['images'] ) ? $pdp_product['images'] : array( vibestore_asset( 'images/products/trench-1.jpg' ) );
if ( count( $pdp_images ) > 1 ) {
	$pdp_gallery = array( $pdp_images[0], $pdp_images[1], $pdp_images[0] );
} else {
	$pdp_gallery = array( $pdp_images[0] );
}
$pdp_colors     = ! empty( $pdp_product['colors'] ) ? $pdp_product['colors'] : array( array( 'name' => 'Obsidian Black', 'hex' => '#0A0A0A' ) );
$pdp_sizes      = ! empty( $pdp_product['sizes'] ) ? $pdp_product['sizes'] : array( 'XS', 'S', 'M', 'L', 'XL' );
$pdp_attributes = ! empty( $pdp_product['attributes'] ) ? $pdp_product['attributes'] : array(
	array(
		'name'    => 'Silhouette Fit',
		'slug'    => 'fit',
		'options' => array( 'Signature Atelier Drape', 'Tailored Contour Fit' ),
	),
);
$first_color = isset( $pdp_colors[0]['name'] ) ? $pdp_colors[0]['name'] : 'Default';
$first_size  = isset( $pdp_sizes[0] ) ? $pdp_sizes[0] : 'One Size';
?>

  <!-- MAIN SINGLE PRODUCT PAGE CONTENT -->
  <main>
    <!-- Breadcrumb Strip -->
    <div style="border-bottom: 1px solid var(--color-border); background-color: var(--color-stone); padding: 1rem 0;">
      <div class="container">
        <nav class="breadcrumb-nav" style="margin-bottom:0;" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <a href="<?php echo vibestore_page_url( 'shop' ); ?>">Shop</a>
          <span>/</span>
          <a href="<?php echo vibestore_page_url( 'shop', '?category=' . rawurlencode( $pdp_cat ) ); ?>" id="pdp-breadcrumb-cat"><?php echo esc_html( $pdp_cat ); ?></a>
          <span>/</span>
          <span id="pdp-breadcrumb-name" style="color:var(--color-obsidian);"><?php echo esc_html( $pdp_name ); ?></span>
        </nav>
      </div>
    </div>

    <!-- 3. DYNAMIC PRODUCT GALLERY & SIZE / VARIATION DETAILS SECTION -->
    <section class="section-padding" style="padding-top: 3.5rem;">
      <div class="container" id="pdp-dynamic-root">
        <!-- Server-rendered initial markup (enhanced interactively by initProductDetailsPage in js/script.js) -->
        <div class="pdp-grid">
          <!-- Left: Interactive Product Image Gallery -->
          <div class="pdp-gallery">
            <div class="pdp-thumbs">
              <?php foreach ( $pdp_gallery as $idx => $img_url ) : ?>
                <button
                  type="button"
                  class="pdp-thumb-btn <?php echo 0 === $idx ? 'active' : ''; ?>"
                  data-pdp-thumb="<?php echo esc_url( $img_url ); ?>"
                  aria-label="View angle <?php echo esc_attr( $idx + 1 ); ?>"
                >
                  <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $pdp_name ); ?> thumbnail <?php echo esc_attr( $idx + 1 ); ?>" />
                </button>
              <?php endforeach; ?>
            </div>
            <div class="pdp-main-Stage">
              <?php if ( $pdp_badge ) : ?>
                <span class="product-badge <?php echo 'Limited Edition' === $pdp_badge ? 'limited' : ''; ?>"><?php echo esc_html( $pdp_badge ); ?></span>
              <?php endif; ?>
              <img
                id="pdp-main-image"
                src="<?php echo esc_url( $pdp_gallery[0] ); ?>"
                alt="<?php echo esc_attr( $pdp_name ); ?>"
              />
            </div>
          </div>

          <!-- Right: Product Details, Size & Variation Options & Purchase Controls -->
          <div class="pdp-info">
            <div class="pdp-meta-row">
              <span class="section-eyebrow" id="pdp-sku-label" style="margin-bottom:0;">
                <?php echo esc_html( $pdp_cat . ' • SKU: ' . strtoupper( $pdp_id ) ); ?>
              </span>
              <a href="#pdp-reviews-section" style="font-size:0.8rem;font-weight:600;color:var(--color-obsidian);">
                <span style="color:var(--color-champagne);">★★★★★</span> <?php echo esc_html( $pdp_rating ); ?> (<?php echo esc_html( $pdp_reviews ); ?> Reviews)
              </a>
            </div>

            <h1 class="pdp-title"><?php echo esc_html( $pdp_name ); ?></h1>

            <div class="pdp-price-row">
              <span class="pdp-price" id="pdp-live-price">$<?php echo esc_html( $pdp_price ); ?></span>
              <span class="pdp-price-original" id="pdp-live-original-price" style="<?php echo $pdp_orig > 0 ? '' : 'display:none;'; ?>">
                <?php echo $pdp_orig > 0 ? '$' . esc_html( $pdp_orig ) : ''; ?>
              </span>
              <span id="pdp-stock-status" style="margin-left:auto;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.12em;color:var(--color-success);font-weight:600;">
                ● In Stock — Ready to Ship
              </span>
            </div>

            <p class="pdp-description">
              <?php echo esc_html( $pdp_desc ); ?>
            </p>

            <!-- Color / Shade Variation Selector -->
            <div class="pdp-option-block">
              <div class="pdp-option-label">
                <span>Color Variation: <strong id="pdp-selected-color-label"><?php echo esc_html( $first_color ); ?></strong></span>
                <span style="font-size:0.68rem;color:var(--color-muted);"><?php echo count( $pdp_colors ); ?> <?php echo 1 === count( $pdp_colors ) ? 'Shade' : 'Shades'; ?> Available</span>
              </div>
              <div class="pdp-color-swatches">
                <?php foreach ( $pdp_colors as $idx => $c ) : ?>
                  <button
                    type="button"
                    class="pdp-color-btn <?php echo 0 === $idx ? 'active' : ''; ?>"
                    style="background-color: <?php echo esc_attr( $c['hex'] ); ?>;"
                    data-pdp-color="<?php echo esc_attr( $c['name'] ); ?>"
                    title="<?php echo esc_attr( $c['name'] ); ?>"
                    aria-label="Select color <?php echo esc_attr( $c['name'] ); ?>"
                  ></button>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Size Options Selector -->
            <div class="pdp-option-block">
              <div class="pdp-option-label">
                <span>Size Option: <strong id="pdp-selected-size-label"><?php echo esc_html( $first_size ); ?></strong></span>
                <button
                  type="button"
                  id="pdp-open-size-guide"
                  style="text-decoration:underline;font-size:0.7rem;font-weight:600;color:var(--color-obsidian);cursor:pointer;background:none;border:none;padding:0;"
                >
                  📏 Bespoke Size &amp; Fit Guide
                </button>
              </div>
              <div class="pdp-size-grid">
                <?php foreach ( $pdp_sizes as $idx => $s ) : ?>
                  <button
                    type="button"
                    class="pdp-size-btn <?php echo 0 === $idx ? 'active' : ''; ?>"
                    data-pdp-size="<?php echo esc_attr( $s ); ?>"
                  >
                    <?php echo esc_html( $s ); ?>
                  </button>
                <?php endforeach; ?>
              </div>
              <p id="pdp-fit-hint" style="font-size:0.75rem;color:var(--color-charcoal);margin-top:0.55rem;">
                ✦ Fit Note: True to Atelier measure. Take your normal size for our signature drape.
              </p>
            </div>

            <!-- Additional Variation Attributes (Silhouette Fit / Material / Custom WC Attributes) -->
            <?php foreach ( $pdp_attributes as $attr_group ) : ?>
              <?php
              $attr_name = isset( $attr_group['name'] ) ? $attr_group['name'] : 'Variation';
              $attr_slug = isset( $attr_group['slug'] ) ? $attr_group['slug'] : sanitize_title( $attr_name );
              $attr_opts = ! empty( $attr_group['options'] ) ? $attr_group['options'] : array();
              if ( empty( $attr_opts ) ) {
                  continue;
              }
              ?>
              <div class="pdp-option-block" data-pdp-attr-group="<?php echo esc_attr( $attr_slug ); ?>" data-pdp-attr-label="<?php echo esc_attr( $attr_name ); ?>">
                <div class="pdp-option-label">
                  <span><?php echo esc_html( $attr_name ); ?>: <strong data-pdp-attr-selected="<?php echo esc_attr( $attr_slug ); ?>"><?php echo esc_html( $attr_opts[0] ); ?></strong></span>
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:0.6rem;">
                  <?php foreach ( $attr_opts as $o_idx => $opt_val ) : ?>
                    <button
                      type="button"
                      class="pdp-size-btn <?php echo 0 === $o_idx ? 'active' : ''; ?>"
                      style="padding:0 1rem;width:auto;min-width:110px;font-size:0.75rem;"
                      data-pdp-attr-btn="<?php echo esc_attr( $attr_slug ); ?>"
                      data-pdp-attr-value="<?php echo esc_attr( $opt_val ); ?>"
                    >
                      <?php echo esc_html( $opt_val ); ?>
                    </button>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endforeach; ?>

            <!-- Live Selected Configuration Summary Pill -->
            <div id="pdp-variation-summary" style="margin-bottom:1.25rem;padding:0.75rem 1rem;background:var(--color-alabaster);border:1px solid var(--color-border);border-radius:var(--radius-sm);font-size:0.78rem;color:var(--color-charcoal);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
              <span>Selected Configuration: <strong style="color:var(--color-obsidian);"><?php echo esc_html( $first_color . ' • Size ' . $first_size ); ?></strong></span>
              <span style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--color-muted);">SKU: <?php echo esc_html( strtoupper( $pdp_id ) ); ?></span>
            </div>

            <!-- Quantity + Add to Bag + Wishlist -->
            <div class="pdp-purchase-row">
              <div class="qty-stepper" aria-label="Quantity Selector">
                <button type="button" class="qty-btn" id="pdp-qty-minus" aria-label="Decrease quantity">−</button>
                <input type="text" id="pdp-qty-input" class="qty-input" value="1" readonly aria-label="Quantity" />
                <button type="button" class="qty-btn" id="pdp-qty-plus" aria-label="Increase quantity">+</button>
              </div>

              <button type="button" id="pdp-add-to-cart-btn" class="btn btn-primary" style="flex:1;">
                <span>Add to Bag — $<span id="pdp-btn-total-price"><?php echo esc_html( $pdp_price ); ?></span></span>
              </button>

              <button
                type="button"
                class="pdp-wishlist-btn"
                data-wishlist-btn="<?php echo esc_attr( $pdp_id ); ?>"
                aria-label="Save to Wishlist"
                title="Save to Wishlist"
              >
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
              </button>
            </div>

            <!-- Instant Express Buy Now Button -->
            <div style="margin-top:0.75rem;">
              <button
                type="button"
                id="pdp-buy-now-btn"
                class="btn"
                style="width:100%;border:1px solid var(--color-obsidian);background:transparent;color:var(--color-obsidian);"
              >
                <span>Instant Atelier Checkout (Buy Now)</span>
                <span>→</span>
              </button>
            </div>

            <!-- Atelier Guarantee Highlights -->
            <div style="margin-top:1.5rem;padding:1rem 1.25rem;background:var(--color-stone);border-radius:var(--radius-sm);font-size:0.78rem;color:var(--color-charcoal);display:flex;flex-wrap:wrap;gap:1.25rem;">
              <span>✓ Complimentary Express DHL Delivery</span>
              <span>✓ 30-Day Atelier Exchange &amp; Returns</span>
              <span>✓ Organic Linen Garment Bag Included</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- BESPOKE SIZE & MEASUREMENT GUIDE MODAL -->
    <div id="pdp-size-guide-modal" class="quickview-backdrop" aria-hidden="true">
      <div class="quickview-modal" role="dialog" aria-modal="true" aria-label="Bespoke Size & Measurement Guide" style="grid-template-columns:1fr;max-width:680px;padding:2.5rem;">
        <button type="button" class="quickview-close" id="pdp-size-guide-close" aria-label="Close Size Guide">✕</button>
        <p class="section-eyebrow">Milanese Tailoring Standards</p>
        <h3 class="section-title" style="font-size:1.85rem;margin-bottom:0.5rem;">Bespoke Size &amp; Fit Guide</h3>
        <p style="font-size:0.86rem;color:var(--color-charcoal);margin-bottom:1.5rem;">
          All garments are cut in our Milan studio to offer a relaxed architectural drape. Compare your body measurements in centimeters below:
        </p>
        <div style="overflow-x:auto;">
          <table style="width:100%;border-collapse:collapse;font-size:0.82rem;text-align:left;">
            <thead>
              <tr style="border-bottom:2px solid var(--color-obsidian);text-transform:uppercase;letter-spacing:0.12em;font-size:0.7rem;">
                <th style="padding:0.75rem 0.5rem;">Size</th>
                <th style="padding:0.75rem 0.5rem;">IT / EU</th>
                <th style="padding:0.75rem 0.5rem;">Chest (cm / in)</th>
                <th style="padding:0.75rem 0.5rem;">Waist (cm / in)</th>
                <th style="padding:0.75rem 0.5rem;">Hip (cm / in)</th>
              </tr>
            </thead>
            <tbody>
              <tr style="border-bottom:1px solid var(--color-border);">
                <td style="padding:0.75rem 0.5rem;font-weight:600;">XS</td>
                <td style="padding:0.75rem 0.5rem;">38 / 44</td>
                <td style="padding:0.75rem 0.5rem;">82–86 cm (32–34")</td>
                <td style="padding:0.75rem 0.5rem;">64–68 cm (25–27")</td>
                <td style="padding:0.75rem 0.5rem;">88–92 cm (35–36")</td>
              </tr>
              <tr style="border-bottom:1px solid var(--color-border);">
                <td style="padding:0.75rem 0.5rem;font-weight:600;">S</td>
                <td style="padding:0.75rem 0.5rem;">40 / 46</td>
                <td style="padding:0.75rem 0.5rem;">86–90 cm (34–35.5")</td>
                <td style="padding:0.75rem 0.5rem;">68–72 cm (27–28.5")</td>
                <td style="padding:0.75rem 0.5rem;">92–96 cm (36–38")</td>
              </tr>
              <tr style="border-bottom:1px solid var(--color-border);">
                <td style="padding:0.75rem 0.5rem;font-weight:600;">M</td>
                <td style="padding:0.75rem 0.5rem;">42 / 48</td>
                <td style="padding:0.75rem 0.5rem;">90–96 cm (35.5–38")</td>
                <td style="padding:0.75rem 0.5rem;">72–78 cm (28.5–31")</td>
                <td style="padding:0.75rem 0.5rem;">96–102 cm (38–40")</td>
              </tr>
              <tr style="border-bottom:1px solid var(--color-border);">
                <td style="padding:0.75rem 0.5rem;font-weight:600;">L</td>
                <td style="padding:0.75rem 0.5rem;">44 / 50</td>
                <td style="padding:0.75rem 0.5rem;">96–102 cm (38–40")</td>
                <td style="padding:0.75rem 0.5rem;">78–84 cm (31–33")</td>
                <td style="padding:0.75rem 0.5rem;">102–108 cm (40–42.5")</td>
              </tr>
              <tr>
                <td style="padding:0.75rem 0.5rem;font-weight:600;">XL</td>
                <td style="padding:0.75rem 0.5rem;">46 / 52</td>
                <td style="padding:0.75rem 0.5rem;">102–108 cm (40–42.5")</td>
                <td style="padding:0.75rem 0.5rem;">84–90 cm (33–35.5")</td>
                <td style="padding:0.75rem 0.5rem;">108–114 cm (42.5–45")</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- 4. PRODUCT REVIEWS SECTION -->
    <section
      id="pdp-reviews-section"
      class="section-padding"
      style="background-color: var(--color-stone); border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);"
    >
      <div class="container">
        <div class="section-header">
          <div>
            <p class="section-eyebrow">Verified Impressions</p>
            <h2 class="section-title">Client Reviews</h2>
          </div>
        </div>

        <div class="reviews-layout">
          <!-- Left Rating Summary Box -->
          <div class="review-summary-card">
            <p class="section-eyebrow">Overall Satisfaction</p>
            <div style="display:flex;align-items:baseline;gap:0.75rem;margin-top:0.25rem;">
              <span style="font-family:var(--font-serif);font-size:3.25rem;font-weight:600;line-height:1;"><?php echo esc_html( $pdp_rating ); ?></span>
              <span style="font-size:0.9rem;color:var(--color-charcoal);">/ 5.0</span>
            </div>
            <div style="color:var(--color-champagne);letter-spacing:0.2em;margin:0.5rem 0 1rem;">★★★★★</div>
            <p style="font-size:0.84rem;color:var(--color-charcoal);line-height:1.6;">
              98% of verified collectors recommend this piece for its true-to-measure
              tailoring and heirloom material quality.
            </p>
            <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid var(--color-border);font-size:0.78rem;color:var(--color-charcoal);display:flex;flex-direction:column;gap:0.4rem;">
              <div style="display:flex;justify-content:space-between;"><span>Fit &amp; Silhouette</span><strong>True to Size</strong></div>
              <div style="display:flex;justify-content:space-between;"><span>Material Origin</span><strong>Biella / Milan, Italy</strong></div>
            </div>
          </div>

          <!-- Right Reviews List + Write Review Form -->
          <div>
            <div id="pdp-reviews-list"></div>

            <!-- Interactive Write a Review Form -->
            <div class="review-form-box">
              <p class="section-eyebrow">Share Your Experience</p>
              <h3 class="section-title" style="font-size:1.65rem;margin-bottom:1.25rem;">
                Write a Client Review
              </h3>
              <form id="pdp-review-form">
                <div class="form-field-grid">
                  <div>
                    <input
                      type="text"
                      id="rev-name"
                      class="luxury-input"
                      placeholder="Your Full Name *"
                      required
                    />
                  </div>
                  <div>
                    <input
                      type="text"
                      id="rev-location"
                      class="luxury-input"
                      placeholder="City, Country (e.g., Paris, France) *"
                      required
                    />
                  </div>
                </div>

                <div class="form-field-grid">
                  <div>
                    <select id="rev-rating" class="luxury-select" aria-label="Rating">
                      <option value="5">★★★★★ (5 / 5 — Exceptional)</option>
                      <option value="4">★★★★☆ (4 / 5 — Very Good)</option>
                      <option value="3">★★★☆☆ (3 / 5 — Satisfactory)</option>
                    </select>
                  </div>
                  <div>
                    <input
                      type="text"
                      id="rev-title"
                      class="luxury-input"
                      placeholder="Review Headline *"
                      required
                    />
                  </div>
                </div>

                <div style="margin-bottom:1.25rem;">
                  <textarea
                    id="rev-comment"
                    rows="3"
                    class="luxury-textarea"
                    placeholder="Describe the fit, fabric feel, and craftsmanship..."
                    required
                  ></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                  <span>Publish Client Review</span>
                  <span>→</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. RELATED PRODUCTS SECTION -->
    <section class="section-padding">
      <div class="container">
        <div class="section-header">
          <div>
            <p class="section-eyebrow">Complete the Silhouette</p>
            <h2 class="section-title">Related Atelier Pieces</h2>
          </div>
          <a href="<?php echo vibestore_page_url( 'shop' ); ?>" class="nav-link active">View Full Collection →</a>
        </div>

        <div id="pdp-related-grid" class="product-grid"></div>
      </div>
    </section>
  </main>

<?php
get_footer();
