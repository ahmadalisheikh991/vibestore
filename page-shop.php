<?php
/**
 * Template Name: Shop Collection
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- 3. SHOP PAGE EDITORIAL HEADER & CATEGORY PILLS -->
  <main>
    <section class="page-hero-banner">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <span style="color:var(--color-obsidian);">Complete Atelier Collection</span>
        </nav>

        <h1 class="section-title" style="font-size:clamp(2.25rem, 4vw, 3.25rem);">
          The Atelier Collection
        </h1>
        <p class="section-subtitle" style="margin-top:0.65rem;max-width:560px;">
          Explore our permanent wardrobe foundations and numbered seasonal drops—crafted
          from traceable Italian cashmere, merino wool, and vegetable-tanned calfskin.
        </p>

        <!-- Quick Category Filter Pills -->
        <div id="categories" class="shop-category-pills" role="tablist" aria-label="Product Categories">
          <button type="button" class="category-pill-btn active" data-category-pill="All">
            All Pieces
          </button>
          <button type="button" class="category-pill-btn" data-category-pill="Outerwear">
            Outerwear &amp; Tailoring
          </button>
          <button type="button" class="category-pill-btn" data-category-pill="Knitwear">
            Merino &amp; Cashmere Knitwear
          </button>
          <button type="button" class="category-pill-btn" data-category-pill="Leather Goods">
            Italian Leather Goods
          </button>
          <button type="button" class="category-pill-btn" data-category-pill="Accessories">
            Minimalist Accessories
          </button>
        </div>
      </div>
    </section>

    <!-- 4. MAIN SHOP CONTENT: SIDEBAR FILTERS + PRODUCT LISTING GRID -->
    <section class="section-padding" style="padding-top: 3.5rem;">
      <div class="container shop-layout">
        <!-- Left Filter Sidebar -->
        <aside class="shop-sidebar" aria-label="Product Filters">
          <!-- Search Filter -->
          <div class="filter-group">
            <h2 class="filter-group-title">Search Atelier</h2>
            <div class="shop-search-box">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
              <input
                type="search"
                id="shop-search-input"
                placeholder="Search by garment, fiber..."
                aria-label="Search products"
              />
            </div>
          </div>

          <!-- Category Filter -->
          <div class="filter-group">
            <h2 class="filter-group-title">Category</h2>
            <div class="filter-option-list">
              <label class="filter-radio-label">
                <span class="filter-radio-left">
                  <input type="radio" name="shop-category" value="All" checked />
                  <span>All Categories</span>
                </span>
                <span class="filter-count-pill" data-cat-count="All">12</span>
              </label>

              <label class="filter-radio-label">
                <span class="filter-radio-left">
                  <input type="radio" name="shop-category" value="Outerwear" />
                  <span>Outerwear</span>
                </span>
                <span class="filter-count-pill" data-cat-count="Outerwear">3</span>
              </label>

              <label class="filter-radio-label">
                <span class="filter-radio-left">
                  <input type="radio" name="shop-category" value="Knitwear" />
                  <span>Knitwear</span>
                </span>
                <span class="filter-count-pill" data-cat-count="Knitwear">3</span>
              </label>

              <label class="filter-radio-label">
                <span class="filter-radio-left">
                  <input type="radio" name="shop-category" value="Leather Goods" />
                  <span>Leather Goods</span>
                </span>
                <span class="filter-count-pill" data-cat-count="Leather Goods">3</span>
              </label>

              <label class="filter-radio-label">
                <span class="filter-radio-left">
                  <input type="radio" name="shop-category" value="Accessories" />
                  <span>Accessories</span>
                </span>
                <span class="filter-count-pill" data-cat-count="Accessories">3</span>
              </label>
            </div>
          </div>

          <!-- Price Filter -->
          <div class="filter-group">
            <h2 class="filter-group-title">
              <span>Max Price</span>
              <span id="shop-price-value" style="color:var(--color-obsidian);font-weight:700;">$800</span>
            </h2>
            <div class="price-range-wrap">
              <input
                type="range"
                id="shop-price-range"
                class="price-range-slider"
                min="150"
                max="800"
                step="25"
                value="800"
                aria-label="Maximum Price Filter"
              />
              <div class="price-range-labels">
                <span>$150</span>
                <span>$450</span>
                <span>$800</span>
              </div>
            </div>
          </div>

          <!-- Collection Editions Filter -->
          <div class="filter-group">
            <h2 class="filter-group-title">Edition Filter</h2>
            <div class="filter-option-list">
              <label class="filter-radio-label">
                <span class="filter-radio-left">
                  <input type="checkbox" id="filter-new-only" />
                  <span>New Arrivals Only</span>
                </span>
              </label>
              <label class="filter-radio-label">
                <span class="filter-radio-left">
                  <input type="checkbox" id="filter-bestseller-only" />
                  <span>Best-Selling Icons</span>
                </span>
              </label>
            </div>
          </div>

          <!-- Reset Button -->
          <button
            type="button"
            id="shop-reset-btn"
            class="btn"
            style="width:100%;border:1px solid var(--color-border);background:var(--color-alabaster);color:var(--color-obsidian);margin-top:0.5rem;"
          >
            Reset All Filters
          </button>
        </aside>

        <!-- Right Main Product Listing Column -->
        <div>
          <!-- Toolbar: Results Count + Sort Options -->
          <div class="shop-toolbar">
            <p id="shop-results-count" class="shop-results-count">
              Showing <strong>1–6</strong> of <strong>12</strong> Atelier Pieces
            </p>

            <div class="shop-sort-wrap">
              <label for="shop-sort-select" class="shop-sort-label">Sort By:</label>
              <select id="shop-sort-select" class="shop-sort-select">
                <option value="featured">Featured Curations</option>
                <option value="newest">Newest Releases</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="rating">Highest Client Rating</option>
              </select>
            </div>
          </div>

          <!-- Product Grid (Populated by js/script.js) -->
          <div id="shop-products-grid" class="shop-products-grid"></div>

          <!-- Pagination / Load More Section -->
          <div id="shop-pagination-area" class="shop-pagination-area"></div>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();

