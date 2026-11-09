<?php
/**
 * The header for our Vibe Store theme
 *
 * @package VibeStore
 */

$current_route = vibestore_current_route();
$is_checkout   = ( 'checkout' === $current_route );
$is_wishlist   = ( 'wishlist' === $current_route );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta
    name="description"
    content="Curated modern luxury apparel, architectural silhouettes, and timeless lifestyle essentials crafted with uncompromising quality."
  />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( $is_checkout ) : ?>
  <!-- 1. TOP ANNOUNCEMENT BAR (CHECKOUT) -->
  <div class="announcement-bar">
    🔒 256-Bit Encrypted Atelier Checkout • Complimentary 30-Day Courier Returns
  </div>

  <!-- 2. STICKY HEADER & NAVIGATION (CHECKOUT) -->
  <header id="site-header" class="site-header">
    <div class="container header-inner">
      <div class="nav-left">
        <a href="<?php echo vibestore_page_url( 'cart' ); ?>" class="nav-link">← Return to Bag</a>
      </div>

      <!-- Center: Brand Identity -->
      <a href="<?php echo vibestore_page_url( 'home' ); ?>" class="brand-logo">
        <span class="brand-logo-main">VIBE STORE</span>
      </a>

      <!-- Right: Utility Icons -->
      <div class="header-actions">
        <a href="<?php echo vibestore_page_url( 'contact' ); ?>" class="nav-link" style="font-size:0.7rem;">Need Help? Concierge</a>
        <a href="<?php echo vibestore_page_url( 'cart' ); ?>" class="icon-btn" aria-label="Shopping Bag">
          <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <path d="M16 10a4 4 0 0 1-8 0"></path>
          </svg>
          <span class="badge-count" data-cart-count>1</span>
        </a>
      </div>
    </div>
  </header>
<?php else : ?>
  <!-- 1. TOP ANNOUNCEMENT BAR -->
  <div class="announcement-bar">
    Complimentary Express Global Shipping on Orders Over $250
    <a href="<?php echo vibestore_page_url( 'shop' ); ?>">Discover Autumn / Winter Atelier</a>
  </div>

  <!-- 2. STICKY HEADER & NAVIGATION -->
  <header id="site-header" class="site-header">
    <div class="container header-inner">
      <!-- Left: Mobile Menu Trigger + Desktop Nav -->
      <div class="nav-left">
        <button
          type="button"
          id="mobile-menu-open"
          class="mobile-menu-btn"
          aria-label="Open Navigation Menu"
        >
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
        </button>

        <nav class="primary-nav" aria-label="Main Navigation">
          <div class="nav-item">
            <a href="<?php echo vibestore_page_url( 'home' ); ?>" class="nav-link <?php echo ( 'home' === $current_route ) ? 'active' : ''; ?>">Home</a>
          </div>
          <div class="nav-item">
            <a href="<?php echo vibestore_page_url( 'shop' ); ?>" class="nav-link <?php echo in_array( $current_route, array( 'shop', 'product-details' ), true ) ? 'active' : ''; ?>">Shop</a>
          </div>
          <div class="nav-item has-dropdown">
            <a href="<?php echo ( 'home' === $current_route ) ? '#featured-categories' : vibestore_page_url( 'shop' ); ?>" class="nav-link">
              <span>Categories</span>
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </a>
            <!-- Dropdown Category Menu -->
            <div class="dropdown-menu">
              <a href="<?php echo vibestore_page_url( 'shop', '?category=Outerwear' ); ?>" class="dropdown-card">
                <img src="<?php echo vibestore_asset( 'images/categories/outerwear.jpg' ); ?>" alt="Outerwear" />
                <div>
                  <div class="dropdown-card-title">Outerwear &amp; Tailoring</div>
                  <p class="dropdown-card-desc">Double-faced cashmere coats &amp; structured wool blazers</p>
                </div>
              </a>
              <a href="<?php echo vibestore_page_url( 'shop', '?category=Knitwear' ); ?>" class="dropdown-card">
                <img src="<?php echo vibestore_asset( 'images/categories/knitwear.jpg' ); ?>" alt="Knitwear" />
                <div>
                  <div class="dropdown-card-title">Architectural Knitwear</div>
                  <p class="dropdown-card-desc">Extra-fine Australian merino &amp; ribbed silhouettes</p>
                </div>
              </a>
              <a href="<?php echo vibestore_page_url( 'shop', '?category=Leather+Goods' ); ?>" class="dropdown-card">
                <img src="<?php echo vibestore_asset( 'images/categories/leather-goods.jpg' ); ?>" alt="Leather Goods" />
                <div>
                  <div class="dropdown-card-title">Italian Leather Goods</div>
                  <p class="dropdown-card-desc">Sculpted calfskin totes &amp; minimalist everyday carry</p>
                </div>
              </a>
              <a href="<?php echo vibestore_page_url( 'shop', '?category=Accessories' ); ?>" class="dropdown-card">
                <img src="<?php echo vibestore_asset( 'images/categories/accessories.jpg' ); ?>" alt="Accessories" />
                <div>
                  <div class="dropdown-card-title">Minimalist Accessories</div>
                  <p class="dropdown-card-desc">Hand-polished bio-acetate eyewear &amp; silk objects</p>
                </div>
              </a>
            </div>
          </div>
          <div class="nav-item">
            <a href="<?php echo vibestore_page_url( 'about' ); ?>" class="nav-link <?php echo ( 'about' === $current_route ) ? 'active' : ''; ?>">About</a>
          </div>
          <div class="nav-item">
            <a href="<?php echo vibestore_page_url( 'contact' ); ?>" class="nav-link <?php echo ( 'contact' === $current_route ) ? 'active' : ''; ?>">Contact</a>
          </div>
        </nav>
      </div>

      <!-- Center: Luxury Brand Identity -->
      <a href="<?php echo vibestore_page_url( 'home' ); ?>" class="brand-logo">
        <span class="brand-logo-main">VIBE STORE</span>
      </a>

      <!-- Right: Utility Icons -->
      <div class="header-actions">
        <button
          type="button"
          id="search-toggle-btn"
          class="icon-btn"
          aria-label="Search Products"
        >
          <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </button>

        <a href="<?php echo vibestore_page_url( 'login' ); ?>" class="icon-btn" data-account-link aria-label="User Account">
          <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
          </svg>
        </a>

        <a href="<?php echo vibestore_page_url( 'wishlist' ); ?>" class="icon-btn" aria-label="Wishlist">
          <svg width="19" height="19" viewBox="0 0 24 24" fill="<?php echo $is_wishlist ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="1.6">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
          </svg>
          <span class="badge-count wishlist-badge" data-wishlist-count>1</span>
        </a>

        <a href="<?php echo vibestore_page_url( 'cart' ); ?>" class="icon-btn" aria-label="Shopping Bag">
          <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <path d="M16 10a4 4 0 0 1-8 0"></path>
          </svg>
          <span class="badge-count" data-cart-count>1</span>
        </a>
      </div>
    </div>

    <!-- Expandable Search Bar -->
    <div id="search-bar-panel" class="search-bar-panel">
      <form action="<?php echo vibestore_page_url( 'shop' ); ?>" method="GET" class="search-bar-inner">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input
          type="text"
          name="q"
          id="header-search-input"
          placeholder="Search cashmere outerwear, sculpted leather totes, merino knitwear..."
        />
        <button type="button" id="search-close-btn" class="nav-link">Close</button>
      </form>
    </div>
  </header>

  <!-- Mobile Navigation Drawer -->
  <div id="mobile-drawer-overlay" class="mobile-drawer-overlay"></div>
  <aside id="mobile-drawer" class="mobile-drawer" aria-label="Mobile Menu">
    <div>
      <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:1.25rem;border-bottom:1px solid var(--color-border);">
        <span class="brand-logo-main" style="font-size:1.35rem;">VIBE STORE</span>
        <button type="button" id="mobile-menu-close" aria-label="Close Menu">✕</button>
      </div>
      <nav class="mobile-nav-list">
        <a href="<?php echo vibestore_page_url( 'home' ); ?>"><span>Home</span><span>↗</span></a>
        <a href="<?php echo vibestore_page_url( 'shop' ); ?>"><span>Shop</span><span>↗</span></a>
        <a href="<?php echo ( 'home' === $current_route ) ? '#featured-categories' : vibestore_page_url( 'shop', '#categories' ); ?>"><span>Categories</span><span>↗</span></a>
        <a href="<?php echo vibestore_page_url( 'about' ); ?>"><span>About</span><span>↗</span></a>
        <a href="<?php echo vibestore_page_url( 'contact' ); ?>"><span>Contact</span><span>↗</span></a>
        <a href="<?php echo vibestore_page_url( 'wishlist' ); ?>"><span>Wishlist</span><span>↗</span></a>
        <a href="<?php echo vibestore_page_url( 'login' ); ?>"><span>My Account</span><span>↗</span></a>
      </nav>
    </div>
    <div style="font-size:0.75rem;color:var(--color-charcoal);">
      <p style="text-transform:uppercase;letter-spacing:0.15em;color:var(--color-obsidian);font-weight:600;">Client Concierge</p>
      <p style="margin-top:0.25rem;">concierge@vibestore.luxury</p>
    </div>
  </aside>
  <script>
    (function() {
      var openBtn = document.getElementById('mobile-menu-open');
      var closeBtn = document.getElementById('mobile-menu-close');
      var drawer = document.getElementById('mobile-drawer');
      var overlay = document.getElementById('mobile-drawer-overlay');
      function openMenu(e) {
        if (e) e.preventDefault();
        if (drawer) drawer.classList.add('active');
        if (overlay) overlay.classList.add('active');
      }
      function closeMenu() {
        if (drawer) drawer.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
      }
      if (openBtn) openBtn.addEventListener('click', openMenu);
      if (closeBtn) closeBtn.addEventListener('click', closeMenu);
      if (overlay) overlay.addEventListener('click', closeMenu);
      if (drawer) {
        var links = drawer.querySelectorAll('a');
        for (var i = 0; i < links.length; i++) {
          links[i].addEventListener('click', closeMenu);
        }
      }
    })();
  </script>
<?php endif; ?>

