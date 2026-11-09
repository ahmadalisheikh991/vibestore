/* ==========================================================================
   VIBE STORE — WISHLIST MODULE (js/wishlist.js)
   Persists wishlist state in localStorage & syncs heart icons
   ========================================================================== */

const WISHLIST_STORAGE_KEY = "vibe_store_wishlist_v1";

window.VibeWishlist = {
  getIds() {
    try {
      const raw = localStorage.getItem(WISHLIST_STORAGE_KEY);
      if (!raw) {
        const initial = ["vibe-002"];
        localStorage.setItem(WISHLIST_STORAGE_KEY, JSON.stringify(initial));
        return initial;
      }
      return JSON.parse(raw);
    } catch (e) {
      return [];
    }
  },

  saveIds(ids) {
    localStorage.setItem(WISHLIST_STORAGE_KEY, JSON.stringify(ids));
    this.updateHeaderBadge(true);
    this.syncButtons();
  },

  toggle(productId) {
    const ids = this.getIds();
    const index = ids.indexOf(productId);
    let added = false;

    if (index > -1) {
      ids.splice(index, 1);
    } else {
      ids.push(productId);
      added = true;
    }

    this.saveIds(ids);

    const product = (window.VIBE_PRODUCTS || []).find((p) => p.id === productId);
    if (window.showVibeToast && product) {
      window.showVibeToast(
        added
          ? `Saved "${product.name}" to Wishlist`
          : `Removed "${product.name}" from Wishlist`
      );
    }
    return added;
  },

  has(productId) {
    return this.getIds().includes(productId);
  },

  updateHeaderBadge(animate = false) {
    const badges = document.querySelectorAll("[data-wishlist-count]");
    const count = this.getIds().length;
    badges.forEach((badge) => {
      badge.textContent = count;
      if (animate) {
        badge.classList.add("bump");
        setTimeout(() => badge.classList.remove("bump"), 300);
      }
    });
  },

  syncButtons() {
    const buttons = document.querySelectorAll("[data-wishlist-btn]");
    buttons.forEach((btn) => {
      const id = btn.getAttribute("data-wishlist-btn");
      if (this.has(id)) {
        btn.classList.add("active");
      } else {
        btn.classList.remove("active");
      }
    });
  }
};

