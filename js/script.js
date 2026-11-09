/* ==========================================================================
   VIBE STORE — MAIN UI & INTERACTION CONTROLLER (js/script.js)
   ========================================================================== */

window.showVibeToast = function (message, actionLink = null) {
  let toast = document.getElementById("vibe-toast");
  if (!toast) {
    toast = document.createElement("div");
    toast.id = "vibe-toast";
    toast.className = "toast-notification";
    document.body.appendChild(toast);
  }

  const isBagMessage =
    !actionLink && message.toLowerCase().includes("bag");
  const resolvedLink =
    actionLink ||
    (isBagMessage ? { href: window.vibePageUrl("cart"), label: "View Bag →" } : null);

  if (resolvedLink) {
    toast.innerHTML = `
      <span style="display:inline-flex;align-items:center;gap:1rem;">
        <span>${message}</span>
        <a href="${resolvedLink.href}" style="color:var(--color-beige);text-decoration:underline;font-weight:600;white-space:nowrap;">
          ${resolvedLink.label}
        </a>
      </span>
    `;
  } else {
    toast.textContent = message;
  }

  toast.classList.add("show");
  clearTimeout(window.__vibeToastTimer);
  window.__vibeToastTimer = setTimeout(() => {
    toast.classList.remove("show");
  }, 3200);
};

/* Helper: Create Product Card HTML */
window.createProductCardHtml = function (product) {
  const isWishlisted =
    window.VibeWishlist && window.VibeWishlist.has(product.id);
  const badgeClass =
    product.badge === "Limited Edition"
      ? "product-badge limited"
      : "product-badge";

  const swatchesHtml = (product.colors || [])
    .map(
      (c) =>
        `<span class="swatch-dot" title="${c.name}" style="background-color: ${c.hex};"></span>`
    )
    .join("");

  const originalPriceHtml = product.originalPrice
    ? `<span style="font-size:0.78rem;color:var(--color-muted);text-decoration:line-through;margin-right:0.35rem;">$${product.originalPrice}</span>`
    : "";

  const sizesPreview = (product.sizes || ["XS", "S", "M", "L"]).join(" · ");
  const pdpUrl = window.vibePageUrl(
    "product-details",
    "?id=" + encodeURIComponent(product.id)
  );

  return `
    <article class="product-card reveal-on-scroll" data-product-id="${product.id}">
      <div class="product-media">
        <a href="${pdpUrl}">
          <img src="${product.images[0]}" alt="${product.name}" class="product-img-primary" loading="lazy" />
          ${
            product.images[1]
              ? `<img src="${product.images[1]}" alt="${product.name} alternate view" class="product-img-secondary" loading="lazy" />`
              : ""
          }
        </a>

        ${
          product.badge
            ? `<span class="${badgeClass}">${product.badge}</span>`
            : ""
        }

        <button
          type="button"
          class="wishlist-toggle-btn ${isWishlisted ? "active" : ""}"
          data-wishlist-btn="${product.id}"
          aria-label="Save to Wishlist"
        >
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
          </svg>
        </button>

        <div class="quick-add-wrap">
          <div class="product-card-actions">
            <button
              type="button"
              class="quick-add-btn"
              data-quick-add="${product.id}"
            >
              <span>Quick Add — $${product.price}</span>
            </button>
            <button
              type="button"
              class="quick-view-icon-btn"
              data-quick-view="${product.id}"
              title="Quick View"
              aria-label="Quick View ${product.name}"
            >
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div class="product-meta-top">
        <span>${product.category}</span>
        <span>★ ${product.rating} (${product.reviewsCount})</span>
      </div>

      <div class="product-info-row">
        <h3 class="product-title">
          <a href="${pdpUrl}">${product.name}</a>
        </h3>
        <span class="product-price">${originalPriceHtml}$${product.price}</span>
      </div>

      <div style="display:flex;align-items:center;justify-content:space-between;gap:0.5rem;margin-top:0.25rem;">
        <div class="product-swatches">
          ${swatchesHtml}
        </div>
        <span style="font-size:0.68rem;color:var(--color-muted);letter-spacing:0.06em;">${sizesPreview}</span>
      </div>
    </article>
  `;
};

/* Render Trending, Best-Selling & New Arrivals Sections on Homepage */
function renderHomepageProductSections(filterMode = "trending") {
  const trendingGrid = document.getElementById("trending-products-grid");
  const bestSellersGrid = document.getElementById("bestsellers-products-grid");
  const newArrivalsGrid = document.getElementById("new-arrivals-grid");
  const allProducts = window.VIBE_PRODUCTS || [];

  if (trendingGrid) {
    let list = allProducts;
    if (filterMode === "trending") {
      list = allProducts.filter((p) => p.trending);
    } else if (filterMode === "bestseller") {
      list = allProducts.filter((p) => p.bestSeller);
    } else if (filterMode === "new") {
      list = allProducts.filter((p) => p.newArrival);
    }
    trendingGrid.innerHTML = list.slice(0, 4).map(window.createProductCardHtml).join("");
  }

  if (bestSellersGrid) {
    const bestSellers = allProducts.filter((p) => p.bestSeller);
    bestSellersGrid.innerHTML = bestSellers
      .slice(0, 4)
      .map(window.createProductCardHtml)
      .join("");
  }

  if (newArrivalsGrid) {
    const newArrivals = allProducts.filter((p) => p.newArrival);
    newArrivalsGrid.innerHTML = newArrivals
      .slice(0, 4)
      .map(window.createProductCardHtml)
      .join("");
  }

  initScrollReveal();
}

/* Scroll Reveal Observer */
function initScrollReveal() {
  const elements = document.querySelectorAll(".reveal-on-scroll:not(.revealed)");
  if (!("IntersectionObserver" in window)) {
    elements.forEach((el) => el.classList.add("revealed"));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("revealed");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.12, rootMargin: "0px 0px -40px 0px" }
  );

  elements.forEach((el) => observer.observe(el));
}

/* Quick View Modal Controller */
function openQuickViewModal(productId) {
  const product = (window.VIBE_PRODUCTS || []).find((p) => p.id === productId);
  if (!product) return;

  let backdrop = document.getElementById("quickview-backdrop");
  if (!backdrop) {
    backdrop = document.createElement("div");
    backdrop.id = "quickview-backdrop";
    backdrop.className = "quickview-backdrop";
    document.body.appendChild(backdrop);
  }

  const defaultSize = (product.sizes && product.sizes[0]) || "One Size";
  const defaultColor = (product.colors && product.colors[0]?.name) || "Default";

  const colorSwatchesHtml = (product.colors || [])
    .map(
      (c, idx) =>
        `<button type="button" class="pdp-color-btn ${idx === 0 ? "active" : ""}" style="background-color:${c.hex};width:26px;height:26px;" data-qv-color="${c.name}" title="${c.name}" aria-label="Select color ${c.name}"></button>`
    )
    .join("");

  const sizePillsHtml = (product.sizes || ["One Size"])
    .map(
      (s, idx) =>
        `<button type="button" class="size-pill ${idx === 0 ? "active" : ""}" data-qv-size="${s}">${s}</button>`
    )
    .join("");

  backdrop.innerHTML = `
    <div class="quickview-modal" role="dialog" aria-modal="true" aria-label="${product.name}">
      <button type="button" class="quickview-close" id="quickview-close-btn" aria-label="Close Quick View">✕</button>
      <div class="quickview-media">
        <img src="${product.images[0]}" alt="${product.name}" />
      </div>
      <div class="quickview-details">
        <p class="section-eyebrow">${product.category} • ★ ${product.rating}</p>
        <h3 class="section-title" style="font-size:1.85rem;">${product.name}</h3>
        <p style="font-size:1.25rem;font-weight:600;margin-top:0.5rem;">$${product.price}</p>
        <p style="font-size:0.88rem;color:var(--color-charcoal);margin-top:1rem;line-height:1.65;">
          ${product.description || product.shortDescription}
        </p>

        <div style="margin-top:1.25rem;">
          <p style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;color:var(--color-charcoal);margin-bottom:0.45rem;">
            Color: <strong id="qv-color-label" style="color:var(--color-obsidian);">${defaultColor}</strong>
          </p>
          <div style="display:flex;gap:0.55rem;" id="qv-colors">
            ${colorSwatchesHtml}
          </div>
        </div>

        <div style="margin-top:1.25rem;">
          <p style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;color:var(--color-charcoal);">
            Select Size: <strong id="qv-size-label" style="color:var(--color-obsidian);">${defaultSize}</strong>
          </p>
          <div class="quickview-size-pills" id="qv-sizes">
            ${sizePillsHtml}
          </div>
        </div>

        <div style="margin-top:1.75rem;display:flex;gap:0.75rem;">
          <button
            type="button"
            class="btn btn-primary"
            style="flex:1;"
            id="qv-add-btn"
            data-selected-size="${defaultSize}"
            data-selected-color="${defaultColor}"
          >
            Add to Bag — $${product.price}
          </button>
          <a href="${window.vibePageUrl("product-details", "?id=" + encodeURIComponent(product.id))}" class="btn" style="border:1px solid var(--color-border);">
            Full Details →
          </a>
        </div>
      </div>
    </div>
  `;

  requestAnimationFrame(() => backdrop.classList.add("active"));

  const closeBtn = backdrop.querySelector("#quickview-close-btn");
  const closeModal = () => backdrop.classList.remove("active");
  if (closeBtn) closeBtn.addEventListener("click", closeModal);
  backdrop.addEventListener("click", (e) => {
    if (e.target === backdrop) closeModal();
  });

  // Color & Size selection inside modal
  const addBtn = backdrop.querySelector("#qv-add-btn");
  const qvColorLabel = backdrop.querySelector("#qv-color-label");
  const qvSizeLabel = backdrop.querySelector("#qv-size-label");

  backdrop.querySelectorAll("[data-qv-color]").forEach((swatch) => {
    swatch.addEventListener("click", () => {
      backdrop.querySelectorAll("[data-qv-color]").forEach((s) => s.classList.remove("active"));
      swatch.classList.add("active");
      const chosenColor = swatch.getAttribute("data-qv-color");
      if (addBtn) addBtn.setAttribute("data-selected-color", chosenColor);
      if (qvColorLabel) qvColorLabel.textContent = chosenColor;
    });
  });

  backdrop.querySelectorAll("[data-qv-size]").forEach((pill) => {
    pill.addEventListener("click", () => {
      backdrop.querySelectorAll("[data-qv-size]").forEach((p) => p.classList.remove("active"));
      pill.classList.add("active");
      const chosenSize = pill.getAttribute("data-qv-size");
      if (addBtn) addBtn.setAttribute("data-selected-size", chosenSize);
      if (qvSizeLabel) qvSizeLabel.textContent = chosenSize;
    });
  });

  if (addBtn) {
    addBtn.addEventListener("click", () => {
      const chosenSize = addBtn.getAttribute("data-selected-size") || defaultSize;
      const chosenColor = addBtn.getAttribute("data-selected-color") || defaultColor;
      if (window.VibeCart) {
        window.VibeCart.addItem(product.id, 1, chosenSize, chosenColor);
      }
      closeModal();
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  // 1. Render Homepage Sections
  renderHomepageProductSections("trending");

  // 2. Initialize Cart & Wishlist Badges
  if (window.VibeCart) window.VibeCart.updateHeaderBadge(false);
  if (window.VibeWishlist) {
    window.VibeWishlist.updateHeaderBadge(false);
    window.VibeWishlist.syncButtons();
  }

  // 3. Filter Tabs for Trending Showcase
  const filterTabs = document.querySelectorAll("[data-filter-tab]");
  filterTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      filterTabs.forEach((t) => t.classList.remove("active"));
      tab.classList.add("active");
      const mode = tab.getAttribute("data-filter-tab");
      renderHomepageProductSections(mode);
      if (window.VibeWishlist) window.VibeWishlist.syncButtons();
    });
  });

  // 4. Sticky Header Scroll State
  const header = document.getElementById("site-header");
  if (header) {
    window.addEventListener(
      "scroll",
      () => {
        if (window.scrollY > 36) {
          header.classList.add("scrolled");
        } else {
          header.classList.remove("scrolled");
        }
      },
      { passive: true }
    );
  }

  // 5. Search Bar Toggle & Global Instant Search Autocomplete
  const searchToggle = document.getElementById("search-toggle-btn");
  const searchPanel = document.getElementById("search-bar-panel");
  const searchClose = document.getElementById("search-close-btn");
  const searchInput = document.getElementById("header-search-input");

  if (searchToggle && searchPanel) {
    searchToggle.addEventListener("click", () => {
      searchPanel.classList.toggle("active");
      if (searchPanel.classList.contains("active") && searchInput) {
        setTimeout(() => searchInput.focus(), 100);
      }
    });
  }
  if (searchClose && searchPanel) {
    searchClose.addEventListener("click", () => {
      searchPanel.classList.remove("active");
    });
  }

  if (searchInput && searchPanel) {
    let resultsBox = document.getElementById("instant-search-results");
    if (!resultsBox) {
      resultsBox = document.createElement("div");
      resultsBox.id = "instant-search-results";
      resultsBox.className = "instant-search-results";
      searchPanel.appendChild(resultsBox);
    }

    searchInput.addEventListener("input", (e) => {
      const q = (e.target.value || "").trim().toLowerCase();
      if (q.length < 2) {
        resultsBox.classList.remove("visible");
        resultsBox.innerHTML = "";
        return;
      }

      const matches = (window.VIBE_PRODUCTS || []).filter(
        (p) =>
          p.name.toLowerCase().includes(q) ||
          p.category.toLowerCase().includes(q) ||
          (p.shortDescription || "").toLowerCase().includes(q)
      );

      if (matches.length === 0) {
        resultsBox.innerHTML = `
          <div style="padding:1rem 1.25rem;font-size:0.84rem;color:var(--color-charcoal);">
            No atelier pieces matching "<strong>${e.target.value}</strong>".
            <a href="${window.vibePageUrl("shop")}" style="text-decoration:underline;margin-left:0.5rem;color:var(--color-obsidian);font-weight:600;">Browse full catalog →</a>
          </div>
        `;
      } else {
        resultsBox.innerHTML =
          matches
            .slice(0, 4)
            .map(
              (p) => `
              <a href="${window.vibePageUrl("product-details", "?id=" + p.id)}" class="instant-search-item">
                <div style="display:flex;align-items:center;gap:0.85rem;">
                  <img src="${p.images[0]}" alt="${p.name}" />
                  <div>
                    <p style="font-size:0.88rem;font-weight:600;color:var(--color-obsidian);">${p.name}</p>
                    <p style="font-size:0.72rem;color:var(--color-charcoal);text-transform:uppercase;letter-spacing:0.1em;">${p.category}</p>
                  </div>
                </div>
                <strong style="font-size:0.88rem;color:var(--color-obsidian);">$${p.price}</strong>
              </a>
            `
            )
            .join("") +
          `
            <a href="${window.vibePageUrl("shop", "?q=" + encodeURIComponent(e.target.value))}" style="display:block;padding:0.75rem 1.25rem;background:var(--color-stone);text-align:center;font-size:0.74rem;font-weight:600;text-transform:uppercase;letter-spacing:0.14em;color:var(--color-obsidian);">
              View All ${matches.length} Matching Pieces in Shop →
            </a>
          `;
      }
      resultsBox.classList.add("visible");
    });
  }

  // 5B. Sync Header Account Online Indicator Dot
  const activeSession = getActiveSession();
  document.querySelectorAll('[data-account-link], a[href*="login"].icon-btn').forEach((accLink) => {
    const existingDot = accLink.querySelector(".account-online-dot");
    if (activeSession && !existingDot) {
      const dot = document.createElement("span");
      dot.className = "account-online-dot";
      dot.title = `Signed in as ${activeSession.name}`;
      accLink.appendChild(dot);
    }
  });

  // 6. Mobile Drawer Menu Toggle
  const mobileOpenBtn = document.getElementById("mobile-menu-open");
  const mobileCloseBtn = document.getElementById("mobile-menu-close");
  const mobileDrawer = document.getElementById("mobile-drawer");
  const mobileOverlay = document.getElementById("mobile-drawer-overlay");

  function closeMobileMenu() {
    if (mobileDrawer) mobileDrawer.classList.remove("active");
    if (mobileOverlay) mobileOverlay.classList.remove("active");
  }

  if (mobileOpenBtn && mobileDrawer && mobileOverlay) {
    mobileOpenBtn.addEventListener("click", (e) => {
      e.preventDefault();
      mobileDrawer.classList.add("active");
      mobileOverlay.classList.add("active");
    });
    if (mobileCloseBtn) mobileCloseBtn.addEventListener("click", closeMobileMenu);
    mobileOverlay.addEventListener("click", closeMobileMenu);
    mobileDrawer.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", closeMobileMenu);
    });
  }

  // 7. Delegate Quick Add, Quick View & Wishlist Clicks
  document.body.addEventListener("click", (e) => {
    const quickAddBtn = e.target.closest("[data-quick-add]");
    if (quickAddBtn && window.VibeCart) {
      const productId = quickAddBtn.getAttribute("data-quick-add");
      window.VibeCart.addItem(productId, 1);

      const originalHtml = quickAddBtn.innerHTML;
      quickAddBtn.classList.add("added");
      quickAddBtn.innerHTML = "<span>✓ Added to Bag</span>";
      setTimeout(() => {
        quickAddBtn.classList.remove("added");
        quickAddBtn.innerHTML = originalHtml;
      }, 1400);
    }

    const quickViewBtn = e.target.closest("[data-quick-view]");
    if (quickViewBtn) {
      const productId = quickViewBtn.getAttribute("data-quick-view");
      openQuickViewModal(productId);
    }

    const wishlistBtn = e.target.closest("[data-wishlist-btn]");
    if (wishlistBtn && window.VibeWishlist) {
      const productId = wishlistBtn.getAttribute("data-wishlist-btn");
      window.VibeWishlist.toggle(productId);
    }
  });

  // 8. Initialize Scroll Reveal
  initScrollReveal();

  // 9. Initialize Shop Page if on shop.html
  initShopPage();

  // 10. Initialize Product Details Page if on product-details.html
  initProductDetailsPage();

  // 11. Initialize FAQ Accordions & Contact Form
  initFaqAndContact();

  // 12. Initialize Shopping Cart Page if on cart.html
  initCartPage();

  // 13. Initialize Checkout Page if on checkout.html
  initCheckoutPage();

  // 14. Initialize Account Pages (login.html / My Account & register.html)
  initAccountPages();

  // 15. Initialize Wishlist Page if on wishlist.html
  initWishlistPage();

  // 16. Initialize FAQ, Policies & 404 Hub if on faq.html
  initFaqPolicyHub();

  // 17. Ensure Background Hero Video Autoplays Smoothly
  const heroVideo = document.getElementById("hero-bg-video");
  if (heroVideo) {
    heroVideo.muted = true;
    heroVideo.play().catch(() => {});
  }
});

/* ==========================================================================
   STEP 5F: WISHLIST PAGE & FAQ / POLICIES / 404 HUB CONTROLLERS
   ========================================================================== */
function initWishlistPage() {
  const wishlistRoot = document.getElementById("wishlist-page-root");
  const recommendedGrid = document.getElementById("wishlist-recommended-grid");
  if (!wishlistRoot || !window.VibeWishlist) return;

  const allProducts = window.VIBE_PRODUCTS || [];

  function renderWishlist() {
    const savedIds = window.VibeWishlist.getIds();
    const savedProducts = savedIds
      .map((id) => allProducts.find((p) => p.id === id))
      .filter(Boolean);

    if (savedProducts.length === 0) {
      wishlistRoot.innerHTML = `
        <div class="shop-empty-state">
          <p class="section-eyebrow">Your Wishlist Is Empty</p>
          <h2 class="section-title" style="font-size:2.1rem;">No atelier pieces are currently saved.</h2>
          <p style="color:var(--color-charcoal);font-size:0.95rem;margin:0.85rem auto 2rem;max-width:480px;">
            Tap the heart icon on any garment across the store to curate your personal seasonal shortlist.
          </p>
          <a href="${window.vibePageUrl("shop")}" class="btn btn-primary">
            <span>Explore the Collection</span>
            <span>→</span>
          </a>
        </div>
      `;
    } else {
      wishlistRoot.innerHTML = `
        <div class="wishlist-toolbar">
          <p style="font-size:0.9rem;color:var(--color-charcoal);">
            You have <strong style="color:var(--color-obsidian);">${savedProducts.length}</strong> ${
        savedProducts.length === 1 ? "piece" : "pieces"
      } saved in your personal shortlist
          </p>

          <div style="display:flex;flex-wrap:wrap;gap:0.85rem;">
            <button type="button" id="wishlist-move-all-btn" class="btn btn-primary" style="padding:0.75rem 1.5rem;">
              <span>Add All ${savedProducts.length} Pieces to Bag</span>
              <span>→</span>
            </button>
            <button
              type="button"
              id="wishlist-clear-btn"
              class="btn"
              style="padding:0.75rem 1.25rem;border:1px solid var(--color-border);background:var(--color-surface);"
            >
              Clear Wishlist
            </button>
          </div>
        </div>

        <div class="product-grid">
          ${savedProducts.map(window.createProductCardHtml).join("")}
        </div>
      `;

      const moveAllBtn = document.getElementById("wishlist-move-all-btn");
      if (moveAllBtn && window.VibeCart) {
        moveAllBtn.addEventListener("click", () => {
          savedProducts.forEach((p) => {
            window.VibeCart.addItem(p.id, 1);
          });
          if (window.showVibeToast) {
            window.showVibeToast(
              `Added all ${savedProducts.length} saved pieces to your shopping bag.`
            );
          }
        });
      }

      const clearBtn = document.getElementById("wishlist-clear-btn");
      if (clearBtn) {
        clearBtn.addEventListener("click", () => {
          window.VibeWishlist.saveIds([]);
          if (window.showVibeToast) {
            window.showVibeToast("Cleared your saved wishlist.");
          }
          renderWishlist();
        });
      }
    }

    // Render Recommended Pieces Below
    if (recommendedGrid) {
      const notInWishlist = allProducts.filter((p) => !savedIds.includes(p.id));
      const recList = (notInWishlist.length >= 4 ? notInWishlist : allProducts).slice(0, 4);
      recommendedGrid.innerHTML = recList.map(window.createProductCardHtml).join("");
    }

    window.VibeWishlist.syncButtons();
    initScrollReveal();
  }

  renderWishlist();

  // Re-render wishlist grid whenever a heart icon is clicked on wishlist.html
  document.body.addEventListener("click", (e) => {
    if (e.target.closest("[data-wishlist-btn]")) {
      setTimeout(renderWishlist, 20);
    }
  });
}

function initFaqPolicyHub() {
  const navLinks = document.querySelectorAll(".policy-nav-link");
  if (!navLinks.length) return;

  function syncHashActive() {
    const hash = window.location.hash || "#faq";
    navLinks.forEach((link) => {
      if (link.getAttribute("href") === hash) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });
  }

  window.addEventListener("hashchange", syncHashActive);
  syncHashActive();
}

/* ==========================================================================
   STEP 5E: USER ACCOUNT CONTROLLER (Register, Login, My Account, Orders, Profile)
   ========================================================================== */
const USERS_STORAGE_KEY = "vibe_store_users_v1";
const SESSION_STORAGE_KEY = "vibe_store_session_v1";

function getRegisteredUsers() {
  try {
    const raw = localStorage.getItem(USERS_STORAGE_KEY);
    if (!raw) {
      const seeded = [
        {
          name: "Camille Laurent",
          email: "camille@vibestore.luxury",
          password: "password123",
          phone: "+33 6 12 34 56 78",
          city: "Paris Salon",
          address: "242 Rue Saint-Honoré, 75001 Paris, France",
          preferredSize: "M",
          memberSince: "Autumn 2024"
        }
      ];
      localStorage.setItem(USERS_STORAGE_KEY, JSON.stringify(seeded));
      return seeded;
    }
    return JSON.parse(raw);
  } catch (e) {
    return [];
  }
}

function getActiveSession() {
  try {
    return JSON.parse(localStorage.getItem(SESSION_STORAGE_KEY) || "null");
  } catch (e) {
    return null;
  }
}

function setActiveSession(userObj) {
  if (!userObj) {
    localStorage.removeItem(SESSION_STORAGE_KEY);
  } else {
    localStorage.setItem(SESSION_STORAGE_KEY, JSON.stringify(userObj));
  }
}

function initAccountPages() {
  // A. Handle Register Page (register.html)
  const registerForm = document.getElementById("register-client-form");
  if (registerForm) {
    registerForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const name = document.getElementById("reg-name")?.value.trim() || "Client";
      const email = document.getElementById("reg-email")?.value.trim().toLowerCase() || "";
      const password = document.getElementById("reg-password")?.value || "";
      const phone = document.getElementById("reg-phone")?.value.trim() || "";
      const city = document.getElementById("reg-city")?.value || "Milan Flagship";
      const address = document.getElementById("reg-address")?.value.trim() || "Via Montenapoleone 18, Milan";

      const users = getRegisteredUsers();
      const existingIdx = users.findIndex((u) => u.email.toLowerCase() === email);
      const newUser = {
        name,
        email,
        password,
        phone,
        city,
        address,
        preferredSize: "M",
        memberSince: "November 2026"
      };

      if (existingIdx > -1) {
        users[existingIdx] = newUser;
      } else {
        users.push(newUser);
      }

      localStorage.setItem(USERS_STORAGE_KEY, JSON.stringify(users));
      setActiveSession(newUser);

      if (window.showVibeToast) {
        window.showVibeToast(`Welcome to Vibe Store, ${name}! Redirecting to your account...`);
      }
      setTimeout(() => {
        window.location.href = window.vibePageUrl("login");
      }, 700);
    });
  }

  // B. Handle Login & My Account Dashboard Page (login.html)
  const accountRoot = document.getElementById("account-page-root");
  if (!accountRoot) return;

  let activeTab = "orders";

  function renderAccountPage() {
    const sessionUser = getActiveSession();
    const heroTitle = document.getElementById("account-hero-title");
    const heroSub = document.getElementById("account-hero-sub");
    const breadcrumbCurrent = document.getElementById("account-breadcrumb-current");

    // 1. SIGNED OUT VIEW -> Render Login Form
    if (!sessionUser) {
      if (heroTitle) heroTitle.textContent = "Client Sign In";
      if (heroSub) {
        heroSub.textContent =
          "Access your private atelier profile, saved wishlist, and real-time order tracking.";
      }
      if (breadcrumbCurrent) breadcrumbCurrent.textContent = "Client Sign In";

      accountRoot.innerHTML = `
        <div class="auth-split-container">
          <div class="auth-editorial-side">
            <div>
              <p class="section-eyebrow" style="color:var(--color-champagne);">Maison Membership</p>
              <h2 class="section-title" style="color:var(--color-alabaster);font-size:2.2rem;margin-top:0.5rem;">
                The Private Collector Portal.
              </h2>
              <p style="font-size:0.92rem;color:rgba(230,223,211,0.8);margin-top:1rem;line-height:1.7;">
                Sign in to manage your bespoke measurements, track insured DHL Express shipments, and access numbered archive releases.
              </p>
            </div>

            <div style="padding-top:2rem;border-top:1px solid rgba(255,255,255,0.14);font-size:0.8rem;color:var(--color-beige);display:flex;flex-direction:column;gap:0.55rem;">
              <span>✦ Real-Time Atelier Order History</span>
              <span>✦ Saved Bespoke Sizing &amp; Delivery Addresses</span>
              <span>✦ Priority Salon Appointment Booking</span>
            </div>
          </div>

          <div class="auth-form-side">
            <p class="section-eyebrow">Returning Client</p>
            <h3 class="section-title" style="font-size:1.85rem;margin-bottom:1.5rem;">
              Sign In to Your Account
            </h3>

            <div
              id="login-error-box"
              style="display:none;margin-bottom:1.25rem;padding:0.85rem 1rem;background:#FDF2F2;border:1px solid var(--color-error);color:var(--color-error);font-size:0.82rem;border-radius:var(--radius-sm);"
            ></div>

            <form id="login-client-form">
              <div style="margin-bottom:1.1rem;">
                <label for="login-email" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Email Address *
                </label>
                <input
                  type="email"
                  id="login-email"
                  class="luxury-input"
                  placeholder="camille@vibestore.luxury"
                  required
                />
              </div>

              <div style="margin-bottom:1.5rem;">
                <label for="login-password" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Password *
                </label>
                <input
                  type="password"
                  id="login-password"
                  class="luxury-input"
                  placeholder="••••••••"
                  required
                />
              </div>

              <button type="submit" class="btn btn-primary" style="width:100%;">
                <span>Sign In to My Account</span>
                <span>→</span>
              </button>
            </form>

            <!-- Instant Demo Sign-In Helper for Quick Testing -->
            <div style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--color-border);">
              <button
                type="button"
                id="demo-login-btn"
                class="btn"
                style="width:100%;border:1px solid var(--color-border);background:var(--color-stone);color:var(--color-obsidian);"
              >
                ✦ Instant Demo Collector Sign-In (Camille Laurent)
              </button>
            </div>

            <p style="margin-top:1.5rem;font-size:0.85rem;color:var(--color-charcoal);text-align:center;">
              New to Vibe Store?
              <a href="${window.vibePageUrl("register")}" style="color:var(--color-obsidian);font-weight:600;text-decoration:underline;">
                Create a Client Account →
              </a>
            </p>
          </div>
        </div>
      `;

      const loginForm = document.getElementById("login-client-form");
      const errorBox = document.getElementById("login-error-box");
      if (loginForm) {
        loginForm.addEventListener("submit", (e) => {
          e.preventDefault();
          const email = document.getElementById("login-email")?.value.trim().toLowerCase() || "";
          const password = document.getElementById("login-password")?.value || "";
          const users = getRegisteredUsers();
          const found = users.find((u) => u.email.toLowerCase() === email);

          if (found && found.password === password) {
            setActiveSession(found);
            if (window.showVibeToast) {
              window.showVibeToast(`Welcome back, ${found.name}.`);
            }
            renderAccountPage();
          } else if (found && found.password !== password) {
            if (errorBox) {
              errorBox.style.display = "block";
              errorBox.textContent = "Incorrect password. Or click 'Instant Demo Collector Sign-In' below.";
            }
          } else {
            // Allow seamless sign-in for any email entered during local testing
            const quickUser = {
              name: email.split("@")[0].replace(/[._]/g, " "),
              email,
              phone: "+39 02 8945 2100",
              city: "Milan Flagship",
              address: "Via Montenapoleone 18, 20121 Milano MI, Italy",
              preferredSize: "M",
              memberSince: "November 2026"
            };
            setActiveSession(quickUser);
            if (window.showVibeToast) {
              window.showVibeToast(`Signed in as ${quickUser.name}.`);
            }
            renderAccountPage();
          }
        });
      }

      const demoBtn = document.getElementById("demo-login-btn");
      if (demoBtn) {
        demoBtn.addEventListener("click", () => {
          const users = getRegisteredUsers();
          setActiveSession(users[0]);
          if (window.showVibeToast) {
            window.showVibeToast(`Signed in as Demo Collector (${users[0].name}).`);
          }
          renderAccountPage();
        });
      }
      return;
    }

    // 2. SIGNED IN VIEW -> Render My Account Dashboard (Orders & Profile)
    if (heroTitle) heroTitle.textContent = `Welcome, ${sessionUser.name}`;
    if (heroSub) {
      heroSub.textContent = `Private Atelier Collector • Member since ${sessionUser.memberSince || "2026"} • ${sessionUser.city || "Milan Flagship"}`;
    }
    if (breadcrumbCurrent) breadcrumbCurrent.textContent = "My Account";

    // Gather Orders from localStorage + 1 Seeded Historical Order
    const storedOrders = window.VibeCart ? window.VibeCart.getOrders() : [];
    const historicalSeededOrder = {
      orderId: "VB-ORD-849201",
      createdAt: "Oct 14, 2026",
      status: "Delivered — Signed in Paris",
      paymentMethod: "Card (Visa •••• 4242)",
      shippingAddress: sessionUser.address || "242 Rue Saint-Honoré, 75001 Paris, France",
      total: 680,
      items: [
        {
          productId: "vibe-001",
          name: "Atelier Double-Faced Cashmere Trench",
          price: 680,
          quantity: 1,
          size: "M",
          color: "Warm Sand",
          image: window.vibeAssetUrl("images/products/trench-1.jpg")
        }
      ]
    };
    const allOrders = [...storedOrders, historicalSeededOrder];

    const initials = (sessionUser.name || "V")
      .split(" ")
      .map((n) => n[0])
      .join("")
      .toUpperCase()
      .slice(0, 2);

    let rightColumnContentHtml = "";

    if (activeTab === "orders") {
      const ordersListHtml = allOrders
        .map(
          (ord) => `
          <article class="order-history-card">
            <div class="order-history-header">
              <div>
                <span style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;color:var(--color-muted);display:block;">
                  Order Reference
                </span>
                <strong style="font-size:1rem;color:var(--color-obsidian);">${ord.orderId}</strong>
                <span style="font-size:0.8rem;color:var(--color-charcoal);margin-left:0.5rem;">• Placed ${ord.createdAt}</span>
              </div>
              <div style="display:flex;align-items:center;gap:1rem;">
                <span class="order-status-badge">${ord.status}</span>
                <strong style="font-size:1.1rem;color:var(--color-obsidian);">$${ord.total}</strong>
              </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:0.85rem;">
              ${(ord.items || [])
                .map(
                  (item) => `
                  <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
                    <div style="display:flex;align-items:center;gap:1rem;">
                      <img
                        src="${item.image ? window.vibeAssetUrl(item.image) : window.vibeAssetUrl("images/products/trench-1.jpg")}"
                        alt="${item.name}"
                        style="width:54px;height:70px;object-fit:cover;border-radius:var(--radius-sm);background:var(--color-stone);"
                      />
                      <div>
                        <a href="${window.vibePageUrl("product-details", "?id=" + (item.productId || "vibe-001"))}" style="font-weight:600;font-size:0.92rem;color:var(--color-obsidian);">
                          ${item.name}
                        </a>
                        <p style="font-size:0.78rem;color:var(--color-charcoal);margin-top:0.15rem;">
                          Qty: ${item.quantity} • Size: ${item.size} • Color: ${item.color}
                        </p>
                      </div>
                    </div>
                    <strong style="font-size:0.9rem;">$${item.price * item.quantity}</strong>
                  </div>
                `
                )
                .join("")}
            </div>

            <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--color-border);display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:0.75rem;font-size:0.78rem;color:var(--color-charcoal);">
              <span><strong>Shipping Address:</strong> ${ord.shippingAddress}</span>
              <div style="display:flex;align-items:center;gap:1rem;">
                <span><strong>Payment:</strong> ${ord.paymentMethod}</span>
                <button
                  type="button"
                  class="btn"
                  data-reorder-id="${ord.orderId}"
                  style="padding:0.45rem 0.9rem;font-size:0.68rem;border:1px solid var(--color-border);background:var(--color-stone);"
                >
                  ↻ Reorder Pieces
                </button>
              </div>
            </div>

            <!-- 4-Stage Order Tracking Progress Bar -->
            <div class="order-tracking-steps">
              <div class="tracking-step completed">
                <div class="tracking-bar"></div>
                <span>01. Confirmed</span>
              </div>
              <div class="tracking-step completed">
                <div class="tracking-bar"></div>
                <span>02. Milan QC</span>
              </div>
              <div class="tracking-step ${ord.status.includes("Delivered") ? "completed" : ""}">
                <div class="tracking-bar"></div>
                <span>03. DHL Express</span>
              </div>
              <div class="tracking-step ${ord.status.includes("Delivered") ? "completed" : ""}">
                <div class="tracking-bar"></div>
                <span>04. Delivered</span>
              </div>
            </div>
          </article>
        `
        )
        .join("");

      rightColumnContentHtml = `
        <div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <div>
              <p class="section-eyebrow">Archive &amp; Active Dispatches</p>
              <h2 class="section-title" style="font-size:2rem;">Order History (${allOrders.length})</h2>
            </div>
            <a href="${window.vibePageUrl("shop")}" class="btn btn-primary">New Atelier Order →</a>
          </div>
          ${ordersListHtml}
        </div>
      `;
    } else if (activeTab === "profile") {
      rightColumnContentHtml = `
        <div class="contact-form-panel">
          <p class="section-eyebrow">Personal Details &amp; Sizing</p>
          <h2 class="section-title" style="font-size:2rem;margin-bottom:1.5rem;">
            Profile Information
          </h2>

          <form id="profile-update-form">
            <div class="form-field-grid">
              <div>
                <label style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Full Name
                </label>
                <input
                  type="text"
                  id="prof-name"
                  class="luxury-input"
                  value="${sessionUser.name || ""}"
                  required
                />
              </div>
              <div>
                <label style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Email Address
                </label>
                <input
                  type="email"
                  id="prof-email"
                  class="luxury-input"
                  value="${sessionUser.email || ""}"
                  required
                />
              </div>
            </div>

            <div class="form-field-grid">
              <div>
                <label style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Telephone
                </label>
                <input
                  type="tel"
                  id="prof-phone"
                  class="luxury-input"
                  value="${sessionUser.phone || "+33 6 12 34 56 78"}"
                />
              </div>
              <div>
                <label style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Preferred Garment Size
                </label>
                <select id="prof-size" class="luxury-select">
                  ${["XS", "S", "M", "L", "XL"]
                    .map(
                      (s) =>
                        `<option value="${s}" ${
                          (sessionUser.preferredSize || "M") === s ? "selected" : ""
                        }>Size ${s}</option>`
                    )
                    .join("")}
                </select>
              </div>
            </div>

            <div style="margin-bottom:1.5rem;">
              <label style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                Default Insured Shipping Address
              </label>
              <input
                type="text"
                id="prof-address"
                class="luxury-input"
                value="${sessionUser.address || ""}"
                required
              />
            </div>

            <button type="submit" class="btn btn-primary">
              <span>Save Profile Changes</span>
              <span>→</span>
            </button>
          </form>
        </div>
      `;
    }

    accountRoot.innerHTML = `
      <div class="account-dashboard-layout">
        <!-- Left Account Navigation Sidebar -->
        <aside class="account-nav-card">
          <div class="account-user-header">
            <div class="account-avatar-circle">${initials}</div>
            <h3 style="font-family:var(--font-serif);font-size:1.45rem;font-weight:600;">
              ${sessionUser.name}
            </h3>
            <p style="font-size:0.78rem;color:var(--color-charcoal);">${sessionUser.email}</p>
          </div>

          <div class="account-tab-list">
            <button
              type="button"
              class="account-tab-btn ${activeTab === "orders" ? "active" : ""}"
              data-account-tab="orders"
            >
              <span>Order History</span>
              <span>(${allOrders.length})</span>
            </button>

            <button
              type="button"
              class="account-tab-btn ${activeTab === "profile" ? "active" : ""}"
              data-account-tab="profile"
            >
              <span>Profile Information</span>
              <span>→</span>
            </button>

            <a href="${window.vibePageUrl("wishlist")}" class="account-tab-btn">
              <span>Saved Wishlist</span>
              <span>↗</span>
            </a>

            <a href="${window.vibePageUrl("cart")}" class="account-tab-btn">
              <span>Shopping Bag</span>
              <span>↗</span>
            </a>

            <button
              type="button"
              id="account-logout-btn"
              class="account-tab-btn"
              style="margin-top:0.75rem;color:var(--color-error);border-top:1px solid var(--color-border);padding-top:1rem;"
            >
              <span>Sign Out</span>
              <span>✕</span>
            </button>
          </div>
        </aside>

        <!-- Right Account Content Area -->
        <div>
          ${rightColumnContentHtml}
        </div>
      </div>
    `;

    // Bind Tab Switches
    accountRoot.querySelectorAll("[data-account-tab]").forEach((btn) => {
      btn.addEventListener("click", () => {
        activeTab = btn.getAttribute("data-account-tab");
        renderAccountPage();
      });
    });

    // Bind Reorder Buttons in Order History
    accountRoot.querySelectorAll("[data-reorder-id]").forEach((btn) => {
      btn.addEventListener("click", () => {
        const orderId = btn.getAttribute("data-reorder-id");
        const targetOrder = allOrders.find((o) => o.orderId === orderId);
        if (targetOrder && targetOrder.items && window.VibeCart) {
          targetOrder.items.forEach((item) => {
            window.VibeCart.addItem(
              item.productId || "vibe-001",
              item.quantity || 1,
              item.size || "M",
              item.color || "Default"
            );
          });
          if (window.showVibeToast) {
            window.showVibeToast(
              `Reordered items from ${orderId} into your shopping bag.`
            );
          }
        }
      });
    });

    // Bind Profile Update Form
    const profileForm = document.getElementById("profile-update-form");
    if (profileForm) {
      profileForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const updatedUser = {
          ...sessionUser,
          name: document.getElementById("prof-name")?.value.trim() || sessionUser.name,
          email: document.getElementById("prof-email")?.value.trim() || sessionUser.email,
          phone: document.getElementById("prof-phone")?.value.trim() || sessionUser.phone,
          preferredSize: document.getElementById("prof-size")?.value || "M",
          address: document.getElementById("prof-address")?.value.trim() || sessionUser.address
        };
        setActiveSession(updatedUser);
        if (window.showVibeToast) {
          window.showVibeToast("Your client profile has been updated.");
        }
        renderAccountPage();
      });
    }

    // Bind Logout
    const logoutBtn = document.getElementById("account-logout-btn");
    if (logoutBtn) {
      logoutBtn.addEventListener("click", () => {
        setActiveSession(null);
        if (window.showVibeToast) {
          window.showVibeToast("You have signed out of your account.");
        }
        renderAccountPage();
      });
    }
  }

  renderAccountPage();
}

/* ==========================================================================
   STEP 5D: SHOPPING CART PAGE & CHECKOUT PAGE CONTROLLERS
   ========================================================================== */
function initCartPage() {
  const cartRoot = document.getElementById("cart-page-root");
  if (!cartRoot || !window.VibeCart) return;

  let selectedShippingTier = "express";

  function renderCart() {
    const summary = window.VibeCart.calculateSummary(selectedShippingTier);
    const allCountries = window.VibeCart.getAllCountries ? window.VibeCart.getAllCountries() : ["Pakistan"];

    if (summary.items.length === 0) {
      cartRoot.innerHTML = `
        <div class="shop-empty-state">
          <p class="section-eyebrow">Your Atelier Bag Is Empty</p>
          <h2 class="section-title" style="font-size:2.1rem;">No garments are currently in your shopping bag.</h2>
          <p style="color:var(--color-charcoal);font-size:0.95rem;margin:0.85rem auto 2rem;max-width:480px;">
            Explore our permanent collection of double-faced cashmere outerwear, fine merino knitwear, and Italian leather goods.
          </p>
          <a href="${window.vibePageUrl("shop")}" class="btn btn-primary">
            <span>Explore the Collection</span>
            <span>→</span>
          </a>
        </div>
      `;
      return;
    }

    const shippingMessage =
      summary.isFreeShipping
        ? `<span style="color:var(--color-success);font-weight:600;">✓ Free Shipping for ${summary.country} ($0.00)!</span>`
        : `<span>Shipping Destination: <strong>${summary.country}</strong> (Standard: $${summary.standardCost} • Express: $${summary.expressCost})</span>`;

    const itemsRowsHtml = summary.items
      .map(
        (item) => `
        <div class="cart-item-row" data-cart-row="${item.index}">
          <a href="${window.vibePageUrl("product-details", "?id=" + item.product.id)}" class="cart-item-thumb">
            <img src="${item.product.images[0]}" alt="${item.product.name}" />
          </a>

          <div>
            <p class="section-eyebrow" style="margin-bottom:0.2rem;">${item.product.category}</p>
            <h3 style="font-family:var(--font-serif);font-size:1.35rem;font-weight:500;">
              <a href="${window.vibePageUrl("product-details", "?id=" + item.product.id)}">${item.product.name}</a>
            </h3>
            <div class="cart-item-meta">
              <span>Size: <strong>${item.size}</strong></span>
              <span>Color: <strong>${item.color}</strong></span>
              <span>Unit Price: <strong>$${item.product.price}</strong></span>
            </div>
            <button
              type="button"
              class="cart-remove-btn"
              data-cart-remove="${item.index}"
            >
              Remove Piece
            </button>
          </div>

          <div class="cart-item-actions-col" style="text-align:right;">
            <div class="qty-stepper" style="height:38px;margin-bottom:0.65rem;">
              <button
                type="button"
                class="qty-btn"
                data-cart-dec="${item.index}"
                aria-label="Decrease quantity"
              >−</button>
              <input
                type="text"
                class="qty-input"
                value="${item.quantity}"
                readonly
                aria-label="Quantity"
              />
              <button
                type="button"
                class="qty-btn"
                data-cart-inc="${item.index}"
                aria-label="Increase quantity"
              >+</button>
            </div>
            <p style="font-size:1.05rem;font-weight:600;color:var(--color-obsidian);">
              $${item.lineTotal}
            </p>
          </div>
        </div>
      `
      )
      .join("");

    const countryOptionsHtml = allCountries
      .map((c) => `<option value="${c}" ${c === summary.country ? "selected" : ""}>${c}</option>`)
      .join("");

    cartRoot.innerHTML = `
      <div class="cart-layout">
        <!-- Left Column: Progress Bar + Cart Item Rows -->
        <div>
          <div class="shipping-progress-card">
            <p style="font-size:0.84rem;color:var(--color-obsidian);">
              ${shippingMessage}
            </p>
            <div class="shipping-progress-track">
              <div class="shipping-progress-fill" style="width:100%;"></div>
            </div>
          </div>

          <div class="cart-items-container">
            ${itemsRowsHtml}
          </div>

          <div style="margin-top:1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <a href="${window.vibePageUrl("shop")}" class="nav-link active">← Continue Shopping</a>
            <button
              type="button"
              id="cart-clear-all-btn"
              style="font-size:0.74rem;text-transform:uppercase;letter-spacing:0.14em;color:var(--color-muted);text-decoration:underline;"
            >
              Clear Shopping Bag
            </button>
          </div>
        </div>

        <!-- Right Column: Shipping Calculation, Promo Code & Order Summary -->
        <aside class="order-summary-panel" aria-label="Order Summary">
          <p class="section-eyebrow">Atelier Summary</p>
          <h2 class="section-title" style="font-size:1.85rem;margin-bottom:1.5rem;">
            Order Summary
          </h2>

          <!-- Country / Destination Selector -->
          <div style="margin-bottom:1.25rem;">
            <label for="cart-country-select" style="display:block;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;color:var(--color-charcoal);margin-bottom:0.4rem;">
              Shipping Destination (Country)
            </label>
            <select id="cart-country-select" class="luxury-select" style="width:100%;padding:0.65rem 0.85rem;">
              ${countryOptionsHtml}
            </select>
          </div>

          <!-- Shipping Method Calculation -->
          <div style="margin-bottom:1.5rem;">
            <p style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;color:var(--color-charcoal);margin-bottom:0.65rem;">
              Shipping Method (${summary.country})
            </p>

            <label class="shipping-option-card ${selectedShippingTier === "express" ? "active" : ""}">
              <span style="display:flex;align-items:center;gap:0.6rem;font-size:0.84rem;">
                <input
                  type="radio"
                  name="cart-shipping-tier"
                  value="express"
                  ${selectedShippingTier === "express" ? "checked" : ""}
                />
                <span>
                  <strong style="display:block;color:var(--color-obsidian);">${summary.standardLabel}</strong>
                  <span style="font-size:0.74rem;color:var(--color-charcoal);">${summary.isFreeShipping ? "Complimentary Domestic Delivery" : "Insured International Courier"}</span>
                </span>
              </span>
              <strong style="font-size:0.84rem;color:${summary.standardCost === 0 ? "var(--color-success)" : "var(--color-obsidian)"};">
                ${summary.standardCost === 0 ? "FREE ($0)" : "$" + summary.standardCost}
              </strong>
            </label>

            <label class="shipping-option-card ${selectedShippingTier === "sameday" ? "active" : ""}">
              <span style="display:flex;align-items:center;gap:0.6rem;font-size:0.84rem;">
                <input
                  type="radio"
                  name="cart-shipping-tier"
                  value="sameday"
                  ${selectedShippingTier === "sameday" ? "checked" : ""}
                />
                <span>
                  <strong style="display:block;color:var(--color-obsidian);">${summary.expressLabel}</strong>
                  <span style="font-size:0.74rem;color:var(--color-charcoal);">Priority expedited handling</span>
                </span>
              </span>
              <strong style="font-size:0.84rem;">$${summary.expressCost}</strong>
            </label>
          </div>

          <!-- Privilege Promo Code -->
          <div style="margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--color-border);">
            <label for="cart-promo-input" style="display:block;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;color:var(--color-charcoal);margin-bottom:0.5rem;">
              Privilege Code (Try <span style="color:var(--color-obsidian);">VIBE10</span>)
            </label>
            <div style="display:flex;gap:0.5rem;">
              <input
                type="text"
                id="cart-promo-input"
                class="luxury-input"
                placeholder="Enter code (e.g., VIBE10)"
                value="${summary.activePromo}"
                style="padding:0.65rem 0.85rem;"
              />
              <button type="button" id="cart-promo-apply" class="btn btn-primary" style="padding:0.65rem 1.25rem;">
                Apply
              </button>
            </div>
            ${
              summary.discountAmount > 0
                ? `<p style="font-size:0.76rem;color:var(--color-success);margin-top:0.45rem;font-weight:600;">
                    ✓ Code ${summary.activePromo} applied (10% privilege discount: −$${summary.discountAmount})
                  </p>`
                : ""
            }
          </div>

          <!-- Subtotal, Shipping & Total Breakdown -->
          <div class="summary-row">
            <span>Subtotal (${summary.itemCount} ${summary.itemCount === 1 ? "piece" : "pieces"})</span>
            <strong style="color:var(--color-obsidian);">$${summary.subtotal}</strong>
          </div>

          ${
            summary.discountAmount > 0
              ? `<div class="summary-row" style="color:var(--color-success);">
                  <span>Atelier Privilege (${summary.activePromo})</span>
                  <strong>−$${summary.discountAmount}</strong>
                </div>`
              : ""
          }

          <div class="summary-row">
            <span>Shipping (${summary.country})</span>
            <strong style="color:${summary.shippingCost === 0 ? "var(--color-success)" : "var(--color-obsidian)"};">
              ${summary.shippingCost === 0 ? "Free Shipping ($0)" : "$" + summary.shippingCost}
            </strong>
          </div>

          <div class="summary-row total-row">
            <span>Total (Taxes Included)</span>
            <span>$${summary.total}</span>
          </div>

          <a
            href="${window.vibePageUrl("checkout", "?shipping=" + selectedShippingTier)}"
            class="btn btn-primary"
            style="width:100%;margin-top:1.5rem;"
          >
            <span>Proceed to Checkout</span>
            <span>→</span>
          </a>

          <p style="font-size:0.74rem;color:var(--color-charcoal);text-align:center;margin-top:1rem;">
            🔒 Encrypted 256-Bit Checkout • Complimentary 30-Day Returns
          </p>
        </aside>
      </div>
    `;

    // Bind Country Dropdown Change
    const countrySelect = document.getElementById("cart-country-select");
    if (countrySelect) {
      countrySelect.addEventListener("change", (e) => {
        if (window.VibeCart.setCountry) {
          window.VibeCart.setCountry(e.target.value);
        }
        renderCart();
      });
    }

    // Bind Cart Row Events
    cartRoot.querySelectorAll("[data-cart-inc]").forEach((btn) => {
      btn.addEventListener("click", () => {
        const idx = Number(btn.getAttribute("data-cart-inc"));
        const current = summary.items.find((i) => i.index === idx);
        if (current) {
          window.VibeCart.updateQuantity(idx, current.quantity + 1);
          renderCart();
        }
      });
    });

    cartRoot.querySelectorAll("[data-cart-dec]").forEach((btn) => {
      btn.addEventListener("click", () => {
        const idx = Number(btn.getAttribute("data-cart-dec"));
        const current = summary.items.find((i) => i.index === idx);
        if (current) {
          window.VibeCart.updateQuantity(idx, current.quantity - 1);
          renderCart();
        }
      });
    });

    cartRoot.querySelectorAll("[data-cart-remove]").forEach((btn) => {
      btn.addEventListener("click", () => {
        const idx = Number(btn.getAttribute("data-cart-remove"));
        window.VibeCart.removeItemAtIndex(idx);
        if (window.showVibeToast) {
          window.showVibeToast("Removed item from your shopping bag.");
        }
        renderCart();
      });
    });

    const clearAllBtn = document.getElementById("cart-clear-all-btn");
    if (clearAllBtn) {
      clearAllBtn.addEventListener("click", () => {
        window.VibeCart.clearCart();
        renderCart();
      });
    }

    // Bind Shipping Method Change
    cartRoot
      .querySelectorAll('input[name="cart-shipping-tier"]')
      .forEach((radio) => {
        radio.addEventListener("change", (e) => {
          selectedShippingTier = e.target.value;
          renderCart();
        });
      });

    // Bind Promo Code
    const promoInput = document.getElementById("cart-promo-input");
    const promoBtn = document.getElementById("cart-promo-apply");
    if (promoBtn && promoInput) {
      promoBtn.addEventListener("click", () => {
        const res = window.VibeCart.setPromoCode(promoInput.value);
        if (res.valid) {
          window.showVibeToast(`Privilege code ${res.code} (10% off) applied!`);
        } else if (promoInput.value.trim() !== "") {
          window.showVibeToast("Invalid code. Try VIBE10 for 10% off.");
        }
        renderCart();
      });
    }
  }

  renderCart();
}

function initCheckoutPage() {
  const checkoutRoot = document.getElementById("checkout-page-root");
  if (!checkoutRoot || !window.VibeCart) return;

  const params = new URLSearchParams(window.location.search);
  let shippingTier = params.get("shipping") === "sameday" ? "sameday" : "express";
  let paymentMethod = "Card (Visa / Mastercard / Amex)";

  // Check if a user session exists to pre-fill customer details
  let savedUser = null;
  try {
    savedUser = JSON.parse(localStorage.getItem("vibe_store_session_v1") || "null");
  } catch (e) {
    savedUser = null;
  }

  function renderCheckout() {
    const prevVals = {
      firstName: document.getElementById("chk-first-name")?.value,
      lastName: document.getElementById("chk-last-name")?.value,
      email: document.getElementById("chk-email")?.value,
      phone: document.getElementById("chk-phone")?.value,
      address: document.getElementById("chk-address")?.value,
      city: document.getElementById("chk-city")?.value,
      postal: document.getElementById("chk-postal")?.value,
      country: document.getElementById("chk-country")?.value || (window.VibeCart.getCountry ? window.VibeCart.getCountry() : "Pakistan")
    };

    const currentCountry = prevVals.country;
    const summary = window.VibeCart.calculateSummary(shippingTier, currentCountry);
    const allCountries = window.VibeCart.getAllCountries ? window.VibeCart.getAllCountries() : ["Pakistan"];

    if (summary.items.length === 0) {
      checkoutRoot.innerHTML = `
        <div class="shop-empty-state">
          <p class="section-eyebrow">No Items to Checkout</p>
          <h2 class="section-title" style="font-size:2rem;">Your shopping bag is currently empty.</h2>
          <p style="color:var(--color-charcoal);margin:0.75rem auto 1.75rem;max-width:460px;">
            Add pieces from our permanent collection to proceed to checkout.
          </p>
          <a href="${window.vibePageUrl("shop")}" class="btn btn-primary">Return to Shop</a>
        </div>
      `;
      return;
    }

    const orderItemsHtml = summary.items
      .map(
        (item) => `
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:0.85rem 0;border-bottom:1px solid var(--color-border);">
          <div style="display:flex;align-items:center;gap:0.85rem;">
            <img
              src="${item.product.images[0]}"
              alt="${item.product.name}"
              style="width:52px;height:68px;object-fit:cover;border-radius:var(--radius-sm);background:var(--color-stone);"
            />
            <div>
              <p style="font-size:0.88rem;font-weight:600;color:var(--color-obsidian);">${item.product.name}</p>
              <p style="font-size:0.74rem;color:var(--color-charcoal);">
                Qty: ${item.quantity} • Size: ${item.size} • ${item.color}
              </p>
            </div>
          </div>
          <strong style="font-size:0.9rem;color:var(--color-obsidian);">$${item.lineTotal}</strong>
        </div>
      `
      )
      .join("");

    const countryOptionsHtml = allCountries
      .map((c) => `<option value="${c}" ${c === currentCountry ? "selected" : ""}>${c}</option>`)
      .join("");

    checkoutRoot.innerHTML = `
      <form id="checkout-master-form" class="checkout-layout">
        <!-- Left Column: Customer Info, Shipping Address & Payment Method -->
        <div>
          <!-- 1. Customer Information -->
          <div class="checkout-step-card">
            <p class="section-eyebrow">Step 01</p>
            <h2 class="section-title" style="font-size:1.65rem;margin-bottom:1.25rem;">
              Customer Information
            </h2>
            <div class="form-field-grid">
              <div>
                <label for="chk-first-name" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  First Name *
                </label>
                <input
                  type="text"
                  id="chk-first-name"
                  class="luxury-input"
                  value="${savedUser ? savedUser.name.split(" ")[0] : ""}"
                  placeholder="Camille"
                  required
                />
              </div>
              <div>
                <label for="chk-last-name" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Last Name *
                </label>
                <input
                  type="text"
                  id="chk-last-name"
                  class="luxury-input"
                  value="${savedUser && savedUser.name.split(" ")[1] ? savedUser.name.split(" ").slice(1).join(" ") : ""}"
                  placeholder="Laurent"
                  required
                />
              </div>
            </div>

            <div class="form-field-grid" style="margin-bottom:0;">
              <div>
                <label for="chk-email" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Email Address (For Receipt &amp; Tracking) *
                </label>
                <input
                  type="email"
                  id="chk-email"
                  class="luxury-input"
                  value="${savedUser ? savedUser.email : ""}"
                  placeholder="camille@domain.com"
                  required
                />
              </div>
              <div>
                <label for="chk-phone" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Mobile Telephone (For Courier) *
                </label>
                <input
                  type="tel"
                  id="chk-phone"
                  class="luxury-input"
                  placeholder="+92 300 1234567"
                  required
                />
              </div>
            </div>
          </div>

          <!-- 2. Shipping Address & Delivery Speed -->
          <div class="checkout-step-card">
            <p class="section-eyebrow">Step 02</p>
            <h2 class="section-title" style="font-size:1.65rem;margin-bottom:1.25rem;">
              Shipping Destination
            </h2>

            <div style="margin-bottom:1rem;">
              <label for="chk-address" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                Street Address &amp; Apartment / Suite *
              </label>
              <input
                type="text"
                id="chk-address"
                class="luxury-input"
                placeholder="242 Luxury Avenue, Suite 4B"
                required
              />
            </div>

            <div class="form-field-grid">
              <div>
                <label for="chk-city" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  City *
                </label>
                <input
                  type="text"
                  id="chk-city"
                  class="luxury-input"
                  placeholder="Lahore / London / Paris"
                  required
                />
              </div>
              <div>
                <label for="chk-postal" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                  Postal / ZIP Code *
                </label>
                <input
                  type="text"
                  id="chk-postal"
                  class="luxury-input"
                  placeholder="54000"
                  required
                />
              </div>
            </div>

            <div style="margin-bottom:1.5rem;">
              <label for="chk-country" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                Country / Region *
              </label>
              <select id="chk-country" class="luxury-select" required>
                ${countryOptionsHtml}
              </select>
            </div>

            <p style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.65rem;color:var(--color-charcoal);">
              Select Delivery Service (${summary.country})
            </p>
            <label class="shipping-option-card ${shippingTier === "express" ? "active" : ""}">
              <span style="display:flex;align-items:center;gap:0.6rem;font-size:0.85rem;">
                <input
                  type="radio"
                  name="chk-shipping-tier"
                  value="express"
                  ${shippingTier === "express" ? "checked" : ""}
                />
                <span>
                  <strong style="display:block;color:var(--color-obsidian);">${summary.standardLabel}</strong>
                  <span style="font-size:0.74rem;color:var(--color-charcoal);">${summary.isFreeShipping ? "Complimentary Domestic Delivery • Signature linen packaging" : "Insured International Courier • Signature packaging included"}</span>
                </span>
              </span>
              <strong style="color:${summary.standardCost === 0 ? "var(--color-success)" : "var(--color-obsidian)"};">
                ${summary.standardCost === 0 ? "FREE ($0)" : "$" + summary.standardCost}
              </strong>
            </label>

            <label class="shipping-option-card ${shippingTier === "sameday" ? "active" : ""}">
              <span style="display:flex;align-items:center;gap:0.6rem;font-size:0.85rem;">
                <input
                  type="radio"
                  name="chk-shipping-tier"
                  value="sameday"
                  ${shippingTier === "sameday" ? "checked" : ""}
                />
                <span>
                  <strong style="display:block;color:var(--color-obsidian);">${summary.expressLabel}</strong>
                  <span style="font-size:0.74rem;color:var(--color-charcoal);">Expedited priority direct hand-delivery</span>
                </span>
              </span>
              <strong>$${summary.expressCost}</strong>
            </label>
          </div>

          <!-- 3. Payment Method -->
          <div class="checkout-step-card" style="margin-bottom:0;">
            <p class="section-eyebrow">Step 03</p>
            <h2 class="section-title" style="font-size:1.65rem;margin-bottom:0.85rem;">
              Payment Method
            </h2>

            <div class="gateway-notice-banner">
              <strong>Architecture Note (Transparent Payment Integration):</strong>
              This checkout operates in <strong>Local Sandbox Mode</strong> so you can test the complete order &amp; receipt workflow without live charges. To process real live cards in production, connect a backend Stripe PaymentIntent or Adyen session key.
            </div>

            <div class="payment-method-card active" data-payment-card>
              <label class="payment-method-header" for="pm-card">
                <span class="payment-method-left">
                  <input
                    type="radio"
                    id="pm-card"
                    name="chk-payment-method"
                    value="Card (Visa / Mastercard / Amex)"
                    checked
                  />
                  <span>Credit or Debit Card</span>
                </span>
                <span style="font-size:0.72rem;color:var(--color-charcoal);">Visa • Mastercard • Amex</span>
              </label>

              <div id="card-fields-wrap">
                <div style="margin-bottom:0.85rem;">
                  <input
                    type="text"
                    class="luxury-input"
                    placeholder="Card Number (e.g., 4242 •••• •••• 4242)"
                    value="4242 •••• •••• 4242"
                    aria-label="Card Number"
                  />
                </div>
                <div class="form-field-grid" style="margin-bottom:0;">
                  <input
                    type="text"
                    class="luxury-input"
                    placeholder="MM / YY"
                    value="08 / 29"
                    aria-label="Expiration Date"
                  />
                  <input
                    type="text"
                    class="luxury-input"
                    placeholder="CVC"
                    value="888"
                    aria-label="Security Code"
                  />
                </div>
              </div>
            </div>

            <div class="payment-method-card" data-payment-card>
              <label class="payment-method-header" for="pm-applepay">
                <span class="payment-method-left">
                  <input
                    type="radio"
                    id="pm-applepay"
                    name="chk-payment-method"
                    value="Apple Pay / Express Wallet"
                  />
                  <span>Apple Pay / Express Digital Wallet</span>
                </span>
                <span style="font-size:0.72rem;color:var(--color-charcoal);">Instant Biometric Auth</span>
              </label>
            </div>

            <div class="payment-method-card" data-payment-card style="margin-bottom:0;">
              <label class="payment-method-header" for="pm-klarna">
                <span class="payment-method-left">
                  <input
                    type="radio"
                    id="pm-klarna"
                    name="chk-payment-method"
                    value="Klarna (3 Interest-Free Installments)"
                  />
                  <span>Klarna — 3 Interest-Free Payments of $${Math.round(summary.total / 3)}</span>
                </span>
                <span style="font-size:0.72rem;color:var(--color-charcoal);">0% APR</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Right Column: Sticky Order Summary & Place Order Button -->
        <aside class="order-summary-panel" aria-label="Checkout Summary">
          <p class="section-eyebrow">Your Selection</p>
          <h2 class="section-title" style="font-size:1.85rem;margin-bottom:1rem;">
            Order Summary
          </h2>

          <div style="margin-bottom:1.25rem;max-height:320px;overflow-y:auto;">
            ${orderItemsHtml}
          </div>

          <div class="summary-row">
            <span>Subtotal (${summary.itemCount} ${summary.itemCount === 1 ? "piece" : "pieces"})</span>
            <strong style="color:var(--color-obsidian);">$${summary.subtotal}</strong>
          </div>

          ${
            summary.discountAmount > 0
              ? `<div class="summary-row" style="color:var(--color-success);">
                  <span>Privilege Discount (${summary.activePromo})</span>
                  <strong>−$${summary.discountAmount}</strong>
                </div>`
              : ""
          }

          <div class="summary-row">
            <span>Shipping (${summary.country})</span>
            <strong style="color:${summary.shippingCost === 0 ? "var(--color-success)" : "var(--color-obsidian)"};">
              ${summary.shippingCost === 0 ? "Free Shipping ($0)" : "$" + summary.shippingCost}
            </strong>
          </div>

          <div class="summary-row total-row">
            <span>Total Due</span>
            <span>$${summary.total}</span>
          </div>

          <button
            type="submit"
            class="btn btn-primary"
            style="width:100%;margin-top:1.5rem;"
          >
            <span>Place Atelier Order — $${summary.total}</span>
            <span>→</span>
          </button>

          <a
            href="${window.vibePageUrl("cart")}"
            style="display:block;text-align:center;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.14em;color:var(--color-charcoal);margin-top:1rem;text-decoration:underline;"
          >
            ← Return to Shopping Bag
          </a>
        </aside>
      </form>
    `;

    // Restore any in-progress form values after re-render
    if (prevVals.firstName !== undefined && document.getElementById("chk-first-name")) {
      document.getElementById("chk-first-name").value = prevVals.firstName;
    }
    if (prevVals.lastName !== undefined && document.getElementById("chk-last-name")) {
      document.getElementById("chk-last-name").value = prevVals.lastName;
    }
    if (prevVals.email !== undefined && document.getElementById("chk-email")) {
      document.getElementById("chk-email").value = prevVals.email;
    }
    if (prevVals.phone !== undefined && document.getElementById("chk-phone")) {
      document.getElementById("chk-phone").value = prevVals.phone;
    }
    if (prevVals.address !== undefined && document.getElementById("chk-address")) {
      document.getElementById("chk-address").value = prevVals.address;
    }
    if (prevVals.city !== undefined && document.getElementById("chk-city")) {
      document.getElementById("chk-city").value = prevVals.city;
    }
    if (prevVals.postal !== undefined && document.getElementById("chk-postal")) {
      document.getElementById("chk-postal").value = prevVals.postal;
    }
    if (prevVals.country !== undefined && document.getElementById("chk-country")) {
      document.getElementById("chk-country").value = prevVals.country;
    }

    // Bind Country Dropdown Change on Checkout
    const countrySelect = document.getElementById("chk-country");
    if (countrySelect) {
      countrySelect.addEventListener("change", (e) => {
        if (window.VibeCart.setCountry) {
          window.VibeCart.setCountry(e.target.value);
        }
        renderCheckout();
      });
    }

    // Bind Shipping Tier Change on Checkout
    checkoutRoot
      .querySelectorAll('input[name="chk-shipping-tier"]')
      .forEach((radio) => {
        radio.addEventListener("change", (e) => {
          shippingTier = e.target.value;
          renderCheckout();
        });
      });

    // Bind Payment Method Highlight & Card Selection
    checkoutRoot
      .querySelectorAll('input[name="chk-payment-method"]')
      .forEach((radio) => {
        radio.addEventListener("change", (e) => {
          paymentMethod = e.target.value;
          checkoutRoot
            .querySelectorAll("[data-payment-card]")
            .forEach((card) => card.classList.remove("active"));
          const parentCard = radio.closest("[data-payment-card]");
          if (parentCard) parentCard.classList.add("active");
        });
      });

    checkoutRoot
      .querySelectorAll("[data-payment-card]")
      .forEach((card) => {
        card.addEventListener("click", (e) => {
          if (e.target.closest("#card-fields-wrap input")) return;
          const radio = card.querySelector('input[type="radio"]');
          if (radio && !radio.checked) {
            radio.checked = true;
            radio.dispatchEvent(new Event("change"));
          }
        });
      });

    // Bind Form Submit -> Create Order & Show Confirmation Receipt
    const masterForm = document.getElementById("checkout-master-form");
    if (masterForm) {
      masterForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const firstName = document.getElementById("chk-first-name")?.value || "Client";
        const lastName = document.getElementById("chk-last-name")?.value || "";
        const email = document.getElementById("chk-email")?.value || "";
        const phone = document.getElementById("chk-phone")?.value || "";
        const address = document.getElementById("chk-address")?.value || "";
        const city = document.getElementById("chk-city")?.value || "";
        const postal = document.getElementById("chk-postal")?.value || "";
        const country = document.getElementById("chk-country")?.value || summary.country;

        const createdOrder = window.VibeCart.saveOrder({
          customerName: `${firstName} ${lastName}`.trim(),
          email,
          phone,
          shippingAddress: `${address}, ${postal} ${city}, ${country}`,
          country,
          shippingTier,
          shippingTitle: summary.shippingTitle,
          paymentMethod,
          items: summary.items.map((i) => ({
            productId: i.product.id,
            wcId: i.product.wcId || (i.product.id && i.product.id.startsWith("wc-") ? Number(i.product.id.slice(3)) : 0),
            name: i.product.name,
            price: i.product.price,
            quantity: i.quantity,
            size: i.size,
            color: i.color,
            image: i.product.images[0]
          })),
          subtotal: summary.subtotal,
          discountAmount: summary.discountAmount,
          shippingCost: summary.shippingCost,
          total: summary.total
        });

        // Submit order to WooCommerce backend
        const placeBtn = masterForm.querySelector('button[type="submit"]');
        if (placeBtn) {
          placeBtn.disabled = true;
          placeBtn.innerHTML = `<span>Securing Atelier Order...</span>`;
        }

        const renderReceipt = (wcOrderNum = null) => {
          const displayOrderNumber = wcOrderNum || createdOrder.orderId;

          if (window.showVibeToast) {
            window.showVibeToast(`Order ${displayOrderNumber} confirmed!`);
          }

          // Render Luxury Order Confirmation Receipt (Order Received Page)
          checkoutRoot.innerHTML = `
            <div class="order-confirmation-box">
              <span class="verified-pill" style="background:var(--color-obsidian);color:var(--color-beige);padding:0.4rem 1rem;">
                ✓ Order Received
              </span>
              <h2 class="section-title" style="font-size:2.5rem;margin-top:1.25rem;">
                Thank You, ${firstName}.
              </h2>
              <p style="font-size:0.95rem;color:var(--color-charcoal);margin:0.75rem auto 2rem;max-width:520px;">
                Your order <strong>${displayOrderNumber}</strong> has been received and registered in our atelier system. A confirmation dispatch has been sent to <strong>${email}</strong>.
              </p>

              <div style="text-align:left;background:var(--color-alabaster);border:1px solid var(--color-border);border-radius:var(--radius-md);padding:1.75rem;margin-bottom:2rem;">
                <div style="display:grid;grid-template-columns:repeat(2, 1fr);gap:1rem;padding-bottom:1.25rem;border-bottom:1px solid var(--color-border);font-size:0.84rem;">
                  <div>
                    <span style="color:var(--color-muted);display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.12em;">Order Number</span>
                    <strong id="confirmed-order-number">${displayOrderNumber}</strong>
                  </div>
                  <div>
                    <span style="color:var(--color-muted);display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.12em;">Payment Method</span>
                    <strong>${createdOrder.paymentMethod}</strong>
                  </div>
                  <div>
                    <span style="color:var(--color-muted);display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.12em;">Shipping Destination</span>
                    <strong>${createdOrder.shippingAddress}</strong>
                  </div>
                  <div>
                    <span style="color:var(--color-muted);display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.12em;">Shipping Service</span>
                    <strong style="color:${createdOrder.shippingCost === 0 ? "var(--color-success)" : "var(--color-obsidian)"};">
                      ${createdOrder.shippingCost === 0 ? "Free Shipping ($0)" : "$" + createdOrder.shippingCost + " (" + (createdOrder.shippingTitle || "International") + ")"}
                    </strong>
                  </div>
                  <div>
                    <span style="color:var(--color-muted);display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.12em;">Order Status</span>
                    <span style="color:var(--color-success);font-weight:600;">Processing (WooCommerce Synced)</span>
                  </div>
                  <div>
                    <span style="color:var(--color-muted);display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.12em;">Total Charged</span>
                    <strong>$${createdOrder.total}</strong>
                  </div>
                </div>

                <div style="padding-top:1.25rem;">
                  <p style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.14em;color:var(--color-charcoal);font-weight:600;margin-bottom:0.75rem;">
                    Ordered Pieces
                  </p>
                  ${createdOrder.items
                    .map(
                      (item) => `
                      <div style="display:flex;justify-content:space-between;font-size:0.86rem;padding:0.35rem 0;">
                        <span>${item.quantity}x ${item.name} (${item.size}, ${item.color})</span>
                        <strong>$${item.price * item.quantity}</strong>
                      </div>
                    `
                    )
                    .join("")}
                </div>
              </div>

              <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
                <a href="${window.vibePageUrl("shop")}" class="btn btn-primary">
                  <span>Continue Exploring</span>
                  <span>→</span>
                </a>
                <a href="${window.vibePageUrl("login")}" class="btn" style="border:1px solid var(--color-border);">
                  <span>View in My Account</span>
                </a>
              </div>
            </div>
          `;
          window.scrollTo({ top: 0, behavior: "smooth" });
        };

        if (window.VIBE_WP_CONFIG && window.VIBE_WP_CONFIG.ajaxUrl) {
          fetch(window.VIBE_WP_CONFIG.ajaxUrl + "?action=vibestore_create_wc_order", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              firstName,
              lastName,
              email,
              phone,
              address,
              city,
              postal,
              country,
              shippingCost: summary.shippingCost,
              shippingTitle: summary.shippingTitle,
              paymentMethod,
              total: summary.total,
              items: createdOrder.items
            })
          })
            .then((r) => r.json())
            .then((data) => {
              if (data && data.success && data.data && data.data.wcOrderNumber) {
                renderReceipt(data.data.wcOrderNumber);
              } else {
                renderReceipt(createdOrder.orderId);
              }
            })
            .catch(() => {
              renderReceipt(createdOrder.orderId);
            });
        } else {
          renderReceipt(createdOrder.orderId);
        }
      });
    }
  }

  renderCheckout();
}

/* ==========================================================================
   STEP 5C: FAQ ACCORDIONS & CONTACT CONCIERGE CONTROLLER
   ========================================================================== */
function initFaqAndContact() {
  // FAQ Accordion Toggles
  document.querySelectorAll(".faq-trigger").forEach((trigger) => {
    trigger.addEventListener("click", () => {
      const item = trigger.closest(".faq-item");
      if (!item) return;
      const isOpen = item.classList.contains("open");
      item.classList.toggle("open");
      const icon = trigger.querySelector(".faq-icon");
      if (icon) icon.textContent = isOpen ? "+" : "−";
    });
  });

  // Contact Concierge Form Submission
  const contactForm = document.getElementById("contact-concierge-form");
  const contactSuccessBox = document.getElementById("contact-success-box");
  if (contactForm) {
    contactForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const name = document.getElementById("contact-name")?.value || "";
      const email = document.getElementById("contact-email")?.value || "";
      const subject = document.getElementById("contact-subject")?.value || "General Inquiry";
      const message = document.getElementById("contact-message")?.value || "";

      const inquiries = JSON.parse(
        localStorage.getItem("vibe_store_inquiries_v1") || "[]"
      );
      const referenceId = "VB-" + Math.floor(100000 + Math.random() * 900000);
      inquiries.unshift({
        referenceId,
        name,
        email,
        subject,
        message,
        createdAt: new Date().toISOString()
      });
      localStorage.setItem("vibe_store_inquiries_v1", JSON.stringify(inquiries));

      contactForm.reset();
      if (contactSuccessBox) {
        contactSuccessBox.style.display = "block";
        contactSuccessBox.innerHTML = `
          <strong style="display:block;font-family:var(--font-serif);font-size:1.25rem;margin-bottom:0.25rem;">
            Thank you, ${name}. Your inquiry (${referenceId}) has been received.
          </strong>
          Our Milan Client Concierge will respond to <strong>${email}</strong> within 4 business hours.
        `;
      }
      if (window.showVibeToast) {
        window.showVibeToast(`Inquiry ${referenceId} sent to Client Concierge.`);
      }
    });
  }
}

/* ==========================================================================
   STEP 5B: PRODUCT DETAILS PAGE CONTROLLER (Gallery, Variants, Reviews, Related)
   ========================================================================== */
function initProductDetailsPage() {
  const pdpContainer = document.getElementById("pdp-dynamic-root");
  if (!pdpContainer) return;

  const allProducts = window.VIBE_PRODUCTS || [];
  const params = new URLSearchParams(window.location.search);
  const pathSlug = window.location.pathname
    .replace(/\/+$/, "")
    .split("/")
    .pop();
  const productId =
    params.get("id") ||
    params.get("product") ||
    window.VIBE_CURRENT_PRODUCT_ID ||
    (pathSlug && pathSlug !== "product-details" ? pathSlug : "") ||
    "vibe-001";
  const product =
    allProducts.find(
      (p) =>
        p.id === productId ||
        p.slug === productId ||
        (p.wcId && String(p.wcId) === String(productId))
    ) || allProducts[0];

  if (!product) return;

  // Update Document Title & Breadcrumb
  document.title = `${product.name} | VIBE STORE`;
  const breadcrumbCategory = document.getElementById("pdp-breadcrumb-cat");
  const breadcrumbName = document.getElementById("pdp-breadcrumb-name");
  if (breadcrumbCategory) {
    breadcrumbCategory.textContent = product.category;
    breadcrumbCategory.href = window.vibePageUrl("shop", "?category=" + encodeURIComponent(product.category));
  }
  if (breadcrumbName) {
    breadcrumbName.textContent = product.name;
  }

  let selectedColor =
    (product.colors && product.colors[0] && product.colors[0].name) || "Default";
  let selectedSize = (product.sizes && product.sizes[0]) || "One Size";
  let quantity = 1;
  let activeUnitPrice = Number(product.price) || 0;
  let activeOriginalPrice = Number(product.originalPrice) || 0;
  let activeVariantSku = String(product.id || "vibe-001").toUpperCase();

  const extraAttributes =
    product.attributes && product.attributes.length > 0
      ? product.attributes
      : [
          {
            name: "Silhouette Fit",
            slug: "fit",
            options: ["Signature Atelier Drape", "Tailored Contour Fit"]
          }
        ];

  const selectedAttributes = {};
  extraAttributes.forEach((attr) => {
    const key = attr.slug || attr.name;
    selectedAttributes[key] =
      (attr.options && attr.options[0]) || "Standard";
  });

  // Build Gallery Images list (ensure at least 3 angles for gallery richness)
  const galleryImages =
    product.images && product.images.length > 1
      ? [product.images[0], product.images[1], ...product.images.slice(2), product.images[0]].slice(0, 4)
      : [product.images[0]];

  const thumbsHtml = galleryImages
    .map(
      (imgUrl, idx) => `
      <button
        type="button"
        class="pdp-thumb-btn ${idx === 0 ? "active" : ""}"
        data-pdp-thumb="${imgUrl}"
        aria-label="View angle ${idx + 1}"
      >
        <img src="${imgUrl}" alt="${product.name} thumbnail ${idx + 1}" />
      </button>
    `
    )
    .join("");

  const colorsList =
    product.colors && product.colors.length > 0
      ? product.colors
      : [{ name: "Obsidian Black", hex: "#0A0A0A" }];

  const colorsHtml = colorsList
    .map(
      (c, idx) => `
      <button
        type="button"
        class="pdp-color-btn ${idx === 0 ? "active" : ""}"
        style="background-color: ${c.hex};"
        data-pdp-color="${c.name}"
        title="${c.name}"
        aria-label="Select color ${c.name}"
      ></button>
    `
    )
    .join("");

  const sizesList =
    product.sizes && product.sizes.length > 0 ? product.sizes : ["One Size"];

  const sizesHtml = sizesList
    .map(
      (s, idx) => `
      <button
        type="button"
        class="pdp-size-btn ${idx === 0 ? "active" : ""}"
        data-pdp-size="${s}"
      >
        ${s}
      </button>
    `
    )
    .join("");

  const extraAttrsHtml = extraAttributes
    .map((attr) => {
      const slug = attr.slug || attr.name;
      const opts = attr.options || [];
      if (opts.length === 0) return "";
      const buttons = opts
        .map(
          (val, idx) => `
          <button
            type="button"
            class="pdp-size-btn ${idx === 0 ? "active" : ""}"
            style="padding:0 1rem;width:auto;min-width:110px;font-size:0.75rem;"
            data-pdp-attr-btn="${slug}"
            data-pdp-attr-value="${val}"
          >
            ${val}
          </button>
        `
        )
        .join("");

      return `
        <div class="pdp-option-block" data-pdp-attr-group="${slug}">
          <div class="pdp-option-label">
            <span>${attr.name}: <strong data-pdp-attr-selected="${slug}">${opts[0]}</strong></span>
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:0.6rem;">
            ${buttons}
          </div>
        </div>
      `;
    })
    .join("");

  const isWishlisted =
    window.VibeWishlist && window.VibeWishlist.has(product.id);

  pdpContainer.innerHTML = `
    <div class="pdp-grid">
      <!-- Left: Interactive Product Image Gallery -->
      <div class="pdp-gallery">
        <div class="pdp-thumbs">
          ${thumbsHtml}
        </div>
        <div class="pdp-main-Stage">
          ${
            product.badge
              ? `<span class="product-badge ${
                  product.badge === "Limited Edition" ? "limited" : ""
                }">${product.badge}</span>`
              : ""
          }
          <img
            id="pdp-main-image"
            src="${galleryImages[0]}"
            alt="${product.name}"
          />
        </div>
      </div>

      <!-- Right: Product Details, Size & Variation Options & Purchase Controls -->
      <div class="pdp-info">
        <div class="pdp-meta-row">
          <span class="section-eyebrow" id="pdp-sku-label" style="margin-bottom:0;">
            ${product.category} • SKU: ${activeVariantSku}
          </span>
          <a href="#pdp-reviews-section" style="font-size:0.8rem;font-weight:600;color:var(--color-obsidian);">
            <span style="color:var(--color-champagne);">★★★★★</span> ${product.rating} (${product.reviewsCount} Reviews)
          </a>
        </div>

        <h1 class="pdp-title">${product.name}</h1>

        <div class="pdp-price-row">
          <span class="pdp-price" id="pdp-live-price">$${activeUnitPrice}</span>
          <span
            class="pdp-price-original"
            id="pdp-live-original-price"
            style="${activeOriginalPrice > 0 ? "" : "display:none;"}"
          >
            ${activeOriginalPrice > 0 ? "$" + activeOriginalPrice : ""}
          </span>
          <span id="pdp-stock-status" style="margin-left:auto;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.12em;color:var(--color-success);font-weight:600;">
            ● In Stock — Ready to Ship
          </span>
        </div>

        <p class="pdp-description">
          ${product.description || product.shortDescription}
        </p>

        <!-- Color / Shade Variation Selector -->
        <div class="pdp-option-block">
          <div class="pdp-option-label">
            <span>Color Variation: <strong id="pdp-selected-color-label">${selectedColor}</strong></span>
            <span style="font-size:0.68rem;color:var(--color-muted);">${colorsList.length} ${colorsList.length === 1 ? "Shade" : "Shades"} Available</span>
          </div>
          <div class="pdp-color-swatches">
            ${colorsHtml}
          </div>
        </div>

        <!-- Size Options Selector -->
        <div class="pdp-option-block">
          <div class="pdp-option-label">
            <span>Size Option: <strong id="pdp-selected-size-label">${selectedSize}</strong></span>
            <button
              type="button"
              id="pdp-open-size-guide"
              style="text-decoration:underline;font-size:0.7rem;font-weight:600;color:var(--color-obsidian);cursor:pointer;background:none;border:none;padding:0;"
            >
              📏 Bespoke Size &amp; Fit Guide
            </button>
          </div>
          <div class="pdp-size-grid">
            ${sizesHtml}
          </div>
          <p id="pdp-fit-hint" style="font-size:0.75rem;color:var(--color-charcoal);margin-top:0.55rem;">
            ✦ Fit Note: Size <strong>${selectedSize}</strong> is cut true to Italian Atelier measure.
          </p>
        </div>

        <!-- Additional Variation Attributes -->
        ${extraAttrsHtml}

        <!-- Live Selected Variation Summary Strip -->
        <div id="pdp-variation-summary" style="margin-bottom:1.25rem;padding:0.75rem 1rem;background:var(--color-alabaster);border:1px solid var(--color-border);border-radius:var(--radius-sm);font-size:0.78rem;color:var(--color-charcoal);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
          <span id="pdp-variation-summary-text">Selected Configuration: <strong style="color:var(--color-obsidian);">${selectedColor} • Size ${selectedSize}</strong></span>
          <span id="pdp-variation-summary-sku" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--color-muted);">SKU: ${activeVariantSku}</span>
        </div>

        <!-- Quantity + Add to Cart + Wishlist -->
        <div class="pdp-purchase-row">
          <div class="qty-stepper" aria-label="Quantity Selector">
            <button type="button" class="qty-btn" id="pdp-qty-minus" aria-label="Decrease quantity">−</button>
            <input type="text" id="pdp-qty-input" class="qty-input" value="1" readonly aria-label="Quantity" />
            <button type="button" class="qty-btn" id="pdp-qty-plus" aria-label="Increase quantity">+</button>
          </div>

          <button type="button" id="pdp-add-to-cart-btn" class="btn btn-primary" style="flex:1;">
            <span>Add to Bag — $<span id="pdp-btn-total-price">${activeUnitPrice}</span></span>
          </button>

          <button
            type="button"
            class="pdp-wishlist-btn ${isWishlisted ? "active" : ""}"
            data-wishlist-btn="${product.id}"
            aria-label="Save to Wishlist"
            title="Save to Wishlist"
          >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
            </svg>
          </button>
        </div>

        <!-- Instant Buy Now Button -->
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

        <!-- Accordions: Materials, Fit, Shipping -->
        <div class="pdp-accordions">
          <div class="pdp-accordion-item open">
            <button type="button" class="pdp-accordion-trigger">
              <span>Composition &amp; Craftsmanship</span>
              <span>−</span>
            </button>
            <div class="pdp-accordion-body">
              <p>
                Sourced from certified sustainable mills in Biella and Vicenza, Italy. Every seam is reinforced by hand in our Milan studio to guarantee decades of wear without losing architectural structure.
              </p>
            </div>
          </div>

          <div class="pdp-accordion-item">
            <button type="button" class="pdp-accordion-trigger">
              <span>Fit, Dimensions &amp; Care</span>
              <span>+</span>
            </button>
            <div class="pdp-accordion-body">
              <p>
                Designed for a relaxed, tailored drape. Take your normal size for our signature silhouette, or size down for a closer shoulder fit. Dry clean only using eco-certified hydrocarbon solvents or steam gently.
              </p>
            </div>
          </div>

          <div class="pdp-accordion-item">
            <button type="button" class="pdp-accordion-trigger">
              <span>Complimentary Shipping &amp; Returns</span>
              <span>+</span>
            </button>
            <div class="pdp-accordion-body">
              <p>
                Orders placed before 2:00 PM CET dispatch the same business day via insured DHL Express (24–48 hour delivery worldwide). Complimentary courier pickup is included for all exchanges and returns within 30 days.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;

  // Wire Gallery Thumbnail Clicks
  const mainImg = document.getElementById("pdp-main-image");
  pdpContainer.querySelectorAll("[data-pdp-thumb]").forEach((btn) => {
    btn.addEventListener("click", () => {
      pdpContainer
        .querySelectorAll("[data-pdp-thumb]")
        .forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
      if (mainImg) mainImg.src = btn.getAttribute("data-pdp-thumb");
    });
  });

  // Helper: Sync Live Variation State (Price, Image, Stock, Summary, SKU)
  const colorLabel = document.getElementById("pdp-selected-color-label");
  const sizeLabel = document.getElementById("pdp-selected-size-label");
  const fitHintEl = document.getElementById("pdp-fit-hint");
  const livePriceEl = document.getElementById("pdp-live-price");
  const liveOrigPriceEl = document.getElementById("pdp-live-original-price");
  const stockStatusEl = document.getElementById("pdp-stock-status");
  const skuLabelEl = document.getElementById("pdp-sku-label");
  const summaryTextEl = document.getElementById("pdp-variation-summary-text");
  const summarySkuEl = document.getElementById("pdp-variation-summary-sku");
  const qtyInput = document.getElementById("pdp-qty-input");
  const totalBtnPrice = document.getElementById("pdp-btn-total-price");
  const addBtn = document.getElementById("pdp-add-to-cart-btn");

  const sizeNotes = {
    XS: "Size XS (IT 38 / EU 44) — Chest 82–86 cm. Ideal for a closer, tailored shoulder fit.",
    S: "Size S (IT 40 / EU 46) — Chest 86–90 cm. Model is 178 cm and wears Size S.",
    M: "Size M (IT 42 / EU 48) — Chest 90–96 cm. Our signature relaxed Milanese drape.",
    L: "Size L (IT 44 / EU 50) — Chest 96–102 cm. Generous proportion for effortless layering.",
    XL: "Size XL (IT 46 / EU 52) — Chest 102–108 cm. Extended architectural silhouette."
  };

  function syncVariationState() {
    // Check if WooCommerce variable product has a matching variation
    let matchedVar = null;
    if (Array.isArray(product.variations) && product.variations.length > 0) {
      matchedVar = product.variations.find((v) => {
        const attrs = v.attributes || {};
        let sizeOk = true;
        let colorOk = true;
        Object.keys(attrs).forEach((k) => {
          const val = (attrs[k] || "").toLowerCase();
          if (!val) return;
          if (k.includes("size")) {
            sizeOk = val === selectedSize.toLowerCase();
          } else if (k.includes("color") || k.includes("colour")) {
            colorOk =
              val === selectedColor.toLowerCase() ||
              selectedColor.toLowerCase().includes(val);
          }
        });
        return sizeOk && colorOk;
      });
    }

    if (matchedVar) {
      activeUnitPrice = Number(matchedVar.price) || Number(product.price) || 0;
      activeOriginalPrice =
        matchedVar.regularPrice > activeUnitPrice
          ? Number(matchedVar.regularPrice)
          : Number(product.originalPrice) || 0;
      activeVariantSku = String(matchedVar.sku || `${product.id}-${selectedSize}`).toUpperCase();
      if (matchedVar.image && mainImg) {
        mainImg.src = matchedVar.image;
      }
      if (stockStatusEl) {
        if (matchedVar.inStock === false) {
          stockStatusEl.textContent = "○ Currently Out of Stock in This Size";
          stockStatusEl.style.color = "var(--color-error)";
          if (addBtn) addBtn.disabled = true;
        } else {
          const qtyNote =
            matchedVar.stockQty && matchedVar.stockQty <= 5
              ? `● Only ${matchedVar.stockQty} Left in Atelier`
              : "● In Stock — Ready to Ship";
          stockStatusEl.textContent = qtyNote;
          stockStatusEl.style.color = "var(--color-success)";
          if (addBtn) addBtn.disabled = false;
        }
      }
    } else {
      activeUnitPrice = Number(product.price) || 0;
      activeOriginalPrice = Number(product.originalPrice) || 0;
      const cleanSizeCode = String(selectedSize).replace(/\s+/g, "").toUpperCase();
      activeVariantSku = `${String(product.id).toUpperCase()}-${cleanSizeCode}`;
      if (stockStatusEl) {
        stockStatusEl.textContent = "● In Stock — Ready to Ship";
        stockStatusEl.style.color = "var(--color-success)";
      }
      if (addBtn) addBtn.disabled = false;
    }

    if (livePriceEl) livePriceEl.textContent = `$${activeUnitPrice}`;
    if (liveOrigPriceEl) {
      if (activeOriginalPrice > activeUnitPrice) {
        liveOrigPriceEl.style.display = "";
        liveOrigPriceEl.textContent = `$${activeOriginalPrice}`;
      } else {
        liveOrigPriceEl.style.display = "none";
      }
    }
    if (skuLabelEl) {
      skuLabelEl.textContent = `${product.category} • SKU: ${activeVariantSku}`;
    }
    if (fitHintEl) {
      fitHintEl.innerHTML =
        "✦ Fit Note: " +
        (sizeNotes[selectedSize] ||
          `Size <strong>${selectedSize}</strong> is cut true to Italian Atelier measure.`);
    }

    const extraSummaryParts = Object.values(selectedAttributes).filter(Boolean);
    const fullConfigText = [
      selectedColor,
      `Size ${selectedSize}`,
      ...extraSummaryParts
    ].join(" • ");

    if (summaryTextEl) {
      summaryTextEl.innerHTML = `Selected Configuration: <strong style="color:var(--color-obsidian);">${fullConfigText}</strong>`;
    }
    if (summarySkuEl) {
      summarySkuEl.textContent = `SKU: ${activeVariantSku}`;
    }
    if (qtyInput) qtyInput.value = String(quantity);
    if (totalBtnPrice) {
      totalBtnPrice.textContent = String(activeUnitPrice * quantity);
    }
  }

  // Wire Color Swatches
  pdpContainer.querySelectorAll("[data-pdp-color]").forEach((btn, idx) => {
    btn.addEventListener("click", () => {
      pdpContainer
        .querySelectorAll("[data-pdp-color]")
        .forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
      selectedColor = btn.getAttribute("data-pdp-color");
      if (colorLabel) colorLabel.textContent = selectedColor;
      if (galleryImages[idx % galleryImages.length] && mainImg) {
        mainImg.src = galleryImages[idx % galleryImages.length];
      }
      syncVariationState();
    });
  });

  // Wire Size Selector
  pdpContainer.querySelectorAll("[data-pdp-size]").forEach((btn) => {
    btn.addEventListener("click", () => {
      pdpContainer
        .querySelectorAll("[data-pdp-size]")
        .forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
      selectedSize = btn.getAttribute("data-pdp-size");
      if (sizeLabel) sizeLabel.textContent = selectedSize;
      syncVariationState();
    });
  });

  // Wire Additional Variation Attribute Buttons
  pdpContainer.querySelectorAll("[data-pdp-attr-btn]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const groupSlug = btn.getAttribute("data-pdp-attr-btn");
      const val = btn.getAttribute("data-pdp-attr-value");
      pdpContainer
        .querySelectorAll(`[data-pdp-attr-btn="${groupSlug}"]`)
        .forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
      selectedAttributes[groupSlug] = val;
      const labelTarget = pdpContainer.querySelector(
        `[data-pdp-attr-selected="${groupSlug}"]`
      );
      if (labelTarget) labelTarget.textContent = val;
      syncVariationState();
    });
  });

  // Wire Size Guide Modal Open & Close
  const sizeGuideModal = document.getElementById("pdp-size-guide-modal");
  const openSizeGuideBtn = document.getElementById("pdp-open-size-guide");
  const closeSizeGuideBtn = document.getElementById("pdp-size-guide-close");
  if (openSizeGuideBtn && sizeGuideModal) {
    openSizeGuideBtn.addEventListener("click", () => {
      sizeGuideModal.classList.add("active");
    });
  }
  if (closeSizeGuideBtn && sizeGuideModal) {
    closeSizeGuideBtn.addEventListener("click", () => {
      sizeGuideModal.classList.remove("active");
    });
  }
  if (sizeGuideModal) {
    sizeGuideModal.addEventListener("click", (e) => {
      if (e.target === sizeGuideModal) {
        sizeGuideModal.classList.remove("active");
      }
    });
  }

  // Wire Quantity Stepper
  const minusBtn = document.getElementById("pdp-qty-minus");
  const plusBtn = document.getElementById("pdp-qty-plus");

  if (minusBtn) {
    minusBtn.addEventListener("click", () => {
      if (quantity > 1) {
        quantity -= 1;
        syncVariationState();
      }
    });
  }
  if (plusBtn) {
    plusBtn.addEventListener("click", () => {
      if (quantity < 10) {
        quantity += 1;
        syncVariationState();
      }
    });
  }

  // Wire Add to Cart Button
  if (addBtn) {
    addBtn.addEventListener("click", () => {
      if (window.VibeCart) {
        const extraOpts = Object.values(selectedAttributes).filter(Boolean).join(", ");
        const colorWithVariation = extraOpts
          ? `${selectedColor} (${extraOpts})`
          : selectedColor;
        window.VibeCart.addItem(
          product.id,
          quantity,
          selectedSize,
          colorWithVariation
        );
      }
    });
  }

  // Wire Instant Buy Now Button
  const buyNowBtn = document.getElementById("pdp-buy-now-btn");
  if (buyNowBtn) {
    buyNowBtn.addEventListener("click", () => {
      if (window.VibeCart) {
        const extraOpts = Object.values(selectedAttributes).filter(Boolean).join(", ");
        const colorWithVariation = extraOpts
          ? `${selectedColor} (${extraOpts})`
          : selectedColor;
        window.VibeCart.addItem(
          product.id,
          quantity,
          selectedSize,
          colorWithVariation
        );

        buyNowBtn.style.pointerEvents = "none";
        buyNowBtn.innerHTML = `<span>Directing to Checkout...</span> <span>⏳</span>`;

        const items = window.VibeCart.getItems();
        const country = window.VibeCart.getCountry ? window.VibeCart.getCountry() : "Pakistan";
        const ajaxUrl =
          (window.VIBE_WP_CONFIG && window.VIBE_WP_CONFIG.ajaxUrl) ||
          "/wp-admin/admin-ajax.php";

        const formData = new FormData();
        formData.append("action", "vibestore_sync_cart_to_wc");
        formData.append("items", JSON.stringify(items));
        formData.append("country", country);

        fetch(ajaxUrl, {
          method: "POST",
          body: formData,
          credentials: "same-origin"
        })
          .then((res) => res.json())
          .then((data) => {
            if (data && data.success && data.data && data.data.redirect_url) {
              window.location.href = data.data.redirect_url;
            } else {
              window.location.href = window.vibePageUrl("checkout");
            }
          })
          .catch(() => {
            window.location.href = window.vibePageUrl("checkout");
          });
      }
    });
  }

  syncVariationState();

  // Wire Accordions
  pdpContainer.querySelectorAll(".pdp-accordion-trigger").forEach((trigger) => {
    trigger.addEventListener("click", () => {
      const item = trigger.parentElement;
      const isOpen = item.classList.contains("open");
      item.classList.toggle("open");
      const iconSpan = trigger.querySelector("span:last-child");
      if (iconSpan) iconSpan.textContent = isOpen ? "+" : "−";
    });
  });

  // Render Related Products Grid (same category first, then others)
  const relatedGrid = document.getElementById("pdp-related-grid");
  if (relatedGrid) {
    const sameCat = allProducts.filter(
      (p) => p.id !== product.id && p.category === product.category
    );
    const others = allProducts.filter(
      (p) => p.id !== product.id && p.category !== product.category
    );
    const relatedList = [...sameCat, ...others].slice(0, 4);
    relatedGrid.innerHTML = relatedList.map(window.createProductCardHtml).join("");
  }

  // Render & Wire Reviews Section
  const reviewsListEl = document.getElementById("pdp-reviews-list");
  const reviewForm = document.getElementById("pdp-review-form");
  const REVIEWS_KEY = `vibe_reviews_${product.id}`;

  const defaultReviews = [
    {
      author: "Sébastien Moreau",
      location: "Geneva, Switzerland",
      rating: 5,
      date: "October 2026",
      title: "Unmatched Milanese Tailoring",
      comment: `The ${product.name} exceeded every expectation. The weight of the material, the precision of the stitching, and the quiet elegance of the cut make it an instant heirloom.`
    },
    {
      author: "Clara Lindqvist",
      location: "Stockholm, Sweden",
      rating: 5,
      date: "September 2026",
      title: "Effortless Architectural Drape",
      comment:
        "Arrived in 36 hours in a beautiful linen garment bag. True to size and pairs seamlessly with everything in my capsule wardrobe."
    }
  ];

  function loadReviews() {
    try {
      const saved = JSON.parse(localStorage.getItem(REVIEWS_KEY) || "[]");
      return [...saved, ...defaultReviews];
    } catch (e) {
      return defaultReviews;
    }
  }

  function renderReviews() {
    if (!reviewsListEl) return;
    const reviews = loadReviews();
    reviewsListEl.innerHTML = reviews
      .map(
        (r) => `
        <article class="review-item-card">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
            <span style="color:var(--color-champagne);letter-spacing:0.15em;">${"★".repeat(r.rating)}</span>
            <span style="font-size:0.72rem;color:var(--color-muted);">${r.date}</span>
          </div>
          <h4 style="font-family:var(--font-serif);font-size:1.25rem;font-weight:600;color:var(--color-obsidian);">
            ${r.title}
          </h4>
          <p style="font-size:0.88rem;color:var(--color-charcoal);margin:0.6rem 0 1rem;line-height:1.65;">
            “${r.comment}”
          </p>
          <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.75rem;color:var(--color-charcoal);">
            <span><strong>${r.author}</strong> — ${r.location}</span>
            <span class="verified-pill">Verified Client</span>
          </div>
        </article>
      `
      )
      .join("");
  }

  renderReviews();

  if (reviewForm) {
    reviewForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const author = document.getElementById("rev-name")?.value || "Client";
      const location = document.getElementById("rev-location")?.value || "Milan";
      const rating = Number(document.getElementById("rev-rating")?.value || 5);
      const title = document.getElementById("rev-title")?.value || "Exceptional Craft";
      const comment = document.getElementById("rev-comment")?.value || "";

      const existing = JSON.parse(localStorage.getItem(REVIEWS_KEY) || "[]");
      existing.unshift({
        author,
        location,
        rating,
        date: "Just Now",
        title,
        comment
      });
      localStorage.setItem(REVIEWS_KEY, JSON.stringify(existing));
      renderReviews();
      reviewForm.reset();
      if (window.showVibeToast) {
        window.showVibeToast("Thank you. Your client review has been published.");
      }
    });
  }

  if (window.VibeWishlist) window.VibeWishlist.syncButtons();
  initScrollReveal();
}

/* ==========================================================================
   STEP 5A: SHOP PAGE CONTROLLER (Search, Category, Price, Sort & Pagination)
   ========================================================================== */
function initShopPage() {
  const shopGrid = document.getElementById("shop-products-grid");
  if (!shopGrid) return;

  const allProducts = window.VIBE_PRODUCTS || [];
  const ITEMS_PER_PAGE = 6;

  // Dynamically compute max price so WooCommerce products of any price are never hidden
  const highestProductPrice = allProducts.reduce(
    (max, p) => Math.max(max, Number(p.price) || 0),
    800
  );
  const dynamicMaxPrice = Math.max(
    800,
    Math.ceil(highestProductPrice / 50) * 50
  );

  // Dynamically inject any custom WooCommerce categories into pills & sidebar filter
  const pillsContainer = document.querySelector(".shop-category-pills");
  const radioListContainer = document.querySelector(".shop-sidebar .filter-option-list");
  const existingCats = new Set(["All"]);
  document.querySelectorAll("[data-category-pill]").forEach((el) => {
    existingCats.add(el.getAttribute("data-category-pill"));
  });

  allProducts.forEach((p) => {
    const cat = (p.category || "").trim();
    if (cat && !existingCats.has(cat)) {
      existingCats.add(cat);
      if (pillsContainer) {
        const pillBtn = document.createElement("button");
        pillBtn.type = "button";
        pillBtn.className = "category-pill-btn";
        pillBtn.setAttribute("data-category-pill", cat);
        pillBtn.textContent = cat;
        pillsContainer.appendChild(pillBtn);
      }
      if (radioListContainer) {
        const label = document.createElement("label");
        label.className = "filter-radio-label";
        label.innerHTML = `
          <span class="filter-radio-left">
            <input type="radio" name="shop-category" value="${cat}" />
            <span>${cat}</span>
          </span>
          <span class="filter-count-pill" data-cat-count="${cat}">0</span>
        `;
        radioListContainer.appendChild(label);
      }
    }
  });

  // Read initial URL params (?category=... & ?q=...)
  const params = new URLSearchParams(window.location.search);
  const initialCategory = params.get("category") || "All";
  const initialQuery = params.get("q") || "";

  const state = {
    searchQuery: initialQuery,
    category: initialCategory,
    maxPrice: dynamicMaxPrice,
    onlyNew: false,
    onlyBestSeller: false,
    sortBy: "featured",
    visibleCount: ITEMS_PER_PAGE
  };

  // DOM References
  const searchInput = document.getElementById("shop-search-input");
  const priceSlider = document.getElementById("shop-price-range");
  const priceValueLabel = document.getElementById("shop-price-value");
  const sortSelect = document.getElementById("shop-sort-select");
  const onlyNewCheckbox = document.getElementById("filter-new-only");
  const onlyBestCheckbox = document.getElementById("filter-bestseller-only");
  const resultsCountEl = document.getElementById("shop-results-count");
  const paginationArea = document.getElementById("shop-pagination-area");
  const resetBtn = document.getElementById("shop-reset-btn");
  const categoryRadios = document.querySelectorAll('input[name="shop-category"]');
  const categoryPills = document.querySelectorAll("[data-category-pill]");

  if (priceSlider) {
    priceSlider.min = "0";
    priceSlider.max = String(dynamicMaxPrice);
    priceSlider.value = String(dynamicMaxPrice);
  }
  if (priceValueLabel) {
    priceValueLabel.textContent = `$${dynamicMaxPrice}`;
  }

  // Populate Category Counts in Sidebar
  document.querySelectorAll("[data-cat-count]").forEach((badge) => {
    const cat = badge.getAttribute("data-cat-count");
    if (cat === "All") {
      badge.textContent = allProducts.length;
    } else {
      badge.textContent = allProducts.filter((p) => p.category === cat).length;
    }
  });

  // Sync UI controls with initial state
  if (searchInput) searchInput.value = state.searchQuery;

  function syncCategoryControls() {
    categoryRadios.forEach((radio) => {
      radio.checked = radio.value === state.category;
    });
    categoryPills.forEach((pill) => {
      if (pill.getAttribute("data-category-pill") === state.category) {
        pill.classList.add("active");
      } else {
        pill.classList.remove("active");
      }
    });
  }

  function applyFiltersAndRender() {
    let filtered = allProducts.filter((product) => {
      // Category match
      if (state.category !== "All" && product.category !== state.category) {
        return false;
      }
      // Search query match
      if (state.searchQuery.trim() !== "") {
        const q = state.searchQuery.toLowerCase().trim();
        const matchName = product.name.toLowerCase().includes(q);
        const matchCat = product.category.toLowerCase().includes(q);
        const matchDesc = (product.shortDescription || "").toLowerCase().includes(q);
        if (!matchName && !matchCat && !matchDesc) return false;
      }
      // Price match
      if (product.price > state.maxPrice) {
        return false;
      }
      // Checkboxes
      if (state.onlyNew && !product.newArrival) return false;
      if (state.onlyBestSeller && !product.bestSeller) return false;

      return true;
    });

    // Sorting
    filtered = [...filtered].sort((a, b) => {
      if (state.sortBy === "price-asc") return a.price - b.price;
      if (state.sortBy === "price-desc") return b.price - a.price;
      if (state.sortBy === "rating") return b.rating - a.rating;
      if (state.sortBy === "newest") return (b.newArrival ? 1 : 0) - (a.newArrival ? 1 : 0);
      return 0; // featured default order
    });

    const totalFiltered = filtered.length;
    const visibleItems = filtered.slice(0, state.visibleCount);

    // Update Toolbar Count
    if (resultsCountEl) {
      if (totalFiltered === 0) {
        resultsCountEl.innerHTML = `Showing <strong>0</strong> matching pieces`;
      } else {
        resultsCountEl.innerHTML = `Showing <strong>1–${visibleItems.length}</strong> of <strong>${totalFiltered}</strong> Atelier Pieces`;
      }
    }

    // Render Grid or Empty State
    if (totalFiltered === 0) {
      shopGrid.innerHTML = `
        <div class="shop-empty-state" style="grid-column: 1 / -1;">
          <p class="section-eyebrow">No Matching Garments</p>
          <h3 class="section-title" style="font-size:1.75rem;">We couldn't find any pieces matching your filter criteria.</h3>
          <p style="color:var(--color-charcoal);font-size:0.9rem;margin:0.75rem auto 1.75rem;max-width:440px;">
            Try clearing your search query or expanding the price range to explore our complete permanent collection.
          </p>
          <button type="button" class="btn btn-primary" id="empty-clear-filters-btn">
            Reset All Filters
          </button>
        </div>
      `;
      const emptyReset = document.getElementById("empty-clear-filters-btn");
      if (emptyReset) emptyReset.addEventListener("click", resetAllFilters);
    } else {
      shopGrid.innerHTML = visibleItems.map(window.createProductCardHtml).join("");
    }

    // Render Pagination / Load More Controls
    if (paginationArea) {
      if (totalFiltered === 0) {
        paginationArea.innerHTML = "";
      } else {
        const hasMore = state.visibleCount < totalFiltered;
        paginationArea.innerHTML = `
          <p class="pagination-progress-text">
            Viewing ${visibleItems.length} of ${totalFiltered} pieces in this collection
          </p>
          <div class="pagination-buttons">
            ${
              hasMore
                ? `<button type="button" class="btn btn-primary" id="shop-load-more-btn">
                    <span>Load More Pieces (${totalFiltered - visibleItems.length} Remaining)</span>
                    <span>↓</span>
                  </button>`
                : `<span style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--color-muted);">
                    ✓ All ${totalFiltered} Pieces Displayed
                  </span>`
            }
          </div>
        `;
        const loadMoreBtn = document.getElementById("shop-load-more-btn");
        if (loadMoreBtn) {
          loadMoreBtn.addEventListener("click", () => {
            state.visibleCount += ITEMS_PER_PAGE;
            applyFiltersAndRender();
          });
        }
      }
    }

    if (window.VibeWishlist) window.VibeWishlist.syncButtons();
    initScrollReveal();
  }

  function resetAllFilters() {
    state.searchQuery = "";
    state.category = "All";
    state.maxPrice = dynamicMaxPrice;
    state.onlyNew = false;
    state.onlyBestSeller = false;
    state.sortBy = "featured";
    state.visibleCount = ITEMS_PER_PAGE;

    if (searchInput) searchInput.value = "";
    if (priceSlider) priceSlider.value = String(dynamicMaxPrice);
    if (priceValueLabel) priceValueLabel.textContent = `$${dynamicMaxPrice}`;
    if (sortSelect) sortSelect.value = "featured";
    if (onlyNewCheckbox) onlyNewCheckbox.checked = false;
    if (onlyBestCheckbox) onlyBestCheckbox.checked = false;

    syncCategoryControls();
    applyFiltersAndRender();
  }

  // Event Listeners
  if (searchInput) {
    searchInput.addEventListener("input", (e) => {
      state.searchQuery = e.target.value;
      state.visibleCount = ITEMS_PER_PAGE;
      applyFiltersAndRender();
    });
  }

  categoryRadios.forEach((radio) => {
    radio.addEventListener("change", (e) => {
      state.category = e.target.value;
      state.visibleCount = ITEMS_PER_PAGE;
      syncCategoryControls();
      applyFiltersAndRender();
    });
  });

  categoryPills.forEach((pill) => {
    pill.addEventListener("click", () => {
      state.category = pill.getAttribute("data-category-pill") || "All";
      state.visibleCount = ITEMS_PER_PAGE;
      syncCategoryControls();
      applyFiltersAndRender();
    });
  });

  if (priceSlider) {
    priceSlider.addEventListener("input", (e) => {
      state.maxPrice = Number(e.target.value);
      if (priceValueLabel) priceValueLabel.textContent = `$${state.maxPrice}`;
      state.visibleCount = ITEMS_PER_PAGE;
      applyFiltersAndRender();
    });
  }

  if (onlyNewCheckbox) {
    onlyNewCheckbox.addEventListener("change", (e) => {
      state.onlyNew = e.target.checked;
      state.visibleCount = ITEMS_PER_PAGE;
      applyFiltersAndRender();
    });
  }

  if (onlyBestCheckbox) {
    onlyBestCheckbox.addEventListener("change", (e) => {
      state.onlyBestSeller = e.target.checked;
      state.visibleCount = ITEMS_PER_PAGE;
      applyFiltersAndRender();
    });
  }

  if (sortSelect) {
    sortSelect.addEventListener("change", (e) => {
      state.sortBy = e.target.value;
      applyFiltersAndRender();
    });
  }

  if (resetBtn) {
    resetBtn.addEventListener("click", resetAllFilters);
  }

  // Initial Sync & Render
  syncCategoryControls();
  applyFiltersAndRender();
}

