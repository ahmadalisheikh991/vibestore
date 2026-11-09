/* ==========================================================================
   VIBE STORE — SHOPPING CART & ORDER ENGINE (js/cart.js)
   Persists cart items, promo codes, shipping destination & orders in localStorage
   ========================================================================== */

const CART_STORAGE_KEY = "vibe_store_cart_v1";
const PROMO_STORAGE_KEY = "vibe_store_promo_v1";
const ORDERS_STORAGE_KEY = "vibe_store_orders_v1";
const COUNTRY_STORAGE_KEY = "vibe_store_country_v1";

// Default Country Rates Map (synchronized with WooCommerce Shipping Zones)
const DEFAULT_COUNTRY_RATES = {
  Pakistan: {
    code: "PK",
    isFree: true,
    standard: 0,
    express: 10,
    standardLabel: "Free Shipping — Domestic Express Insured (24–48 Hours)",
    expressLabel: "TCS / Leopards Priority Express Courier (Same/Next Day)"
  },
  "United Arab Emirates": {
    code: "AE",
    isFree: false,
    standard: 15,
    express: 30,
    standardLabel: "DHL Express GCC Standard — UAE (2–3 Days)",
    expressLabel: "DHL Priority Air Courier — UAE (Next Day)"
  },
  "Saudi Arabia": {
    code: "SA",
    isFree: false,
    standard: 18,
    express: 32,
    standardLabel: "DHL Express GCC Standard — KSA (3–4 Days)",
    expressLabel: "DHL Priority Air Courier — KSA (1–2 Days)"
  },
  Qatar: {
    code: "QA",
    isFree: false,
    standard: 18,
    express: 32,
    standardLabel: "DHL Express GCC Standard — Qatar (3–4 Days)",
    expressLabel: "DHL Priority Air Courier — Qatar (1–2 Days)"
  },
  Turkey: {
    code: "TR",
    isFree: false,
    standard: 22,
    express: 38,
    standardLabel: "DHL Express Standard — Turkey (3–5 Days)",
    expressLabel: "DHL Priority Air Courier — Turkey (2 Days)"
  },
  "United Kingdom": {
    code: "GB",
    isFree: false,
    standard: 25,
    express: 45,
    standardLabel: "DHL International Express — UK (3–5 Days)",
    expressLabel: "DHL Priority Air Express — UK (1–2 Days)"
  },
  France: {
    code: "FR",
    isFree: false,
    standard: 25,
    express: 45,
    standardLabel: "DHL International Express — France (3–5 Days)",
    expressLabel: "DHL Priority Air Express — France (1–2 Days)"
  },
  Italy: {
    code: "IT",
    isFree: false,
    standard: 25,
    express: 45,
    standardLabel: "DHL Domestic / Express — Italy (2–3 Days)",
    expressLabel: "White-Glove Milan Salon Courier (Same-Day / Next-Day)"
  },
  Germany: {
    code: "DE",
    isFree: false,
    standard: 25,
    express: 45,
    standardLabel: "DHL International Express — Germany (3–5 Days)",
    expressLabel: "DHL Priority Air Express — Germany (1–2 Days)"
  },
  Switzerland: {
    code: "CH",
    isFree: false,
    standard: 28,
    express: 48,
    standardLabel: "DHL International Express — Switzerland (3–5 Days)",
    expressLabel: "DHL Priority Air Express — Switzerland (1–2 Days)"
  },
  "United States": {
    code: "US",
    isFree: false,
    standard: 30,
    express: 50,
    standardLabel: "DHL International Express — USA (3–5 Days)",
    expressLabel: "DHL Priority Air Courier — USA (2–3 Days)"
  },
  Canada: {
    code: "CA",
    isFree: false,
    standard: 32,
    express: 52,
    standardLabel: "DHL International Express — Canada (4–6 Days)",
    expressLabel: "DHL Priority Air Courier — Canada (2–3 Days)"
  },
  Australia: {
    code: "AU",
    isFree: false,
    standard: 35,
    express: 55,
    standardLabel: "DHL International Standard — Australia (5–7 Days)",
    expressLabel: "DHL Priority Air Express — Australia (3–4 Days)"
  },
  Japan: {
    code: "JP",
    isFree: false,
    standard: 35,
    express: 55,
    standardLabel: "DHL International Standard — Japan (5–8 Days)",
    expressLabel: "DHL Priority Air Express — Japan (3–4 Days)"
  }
};

window.VibeCart = {
  getItems() {
    try {
      const raw = localStorage.getItem(CART_STORAGE_KEY);
      if (!raw) {
        // Seed with 1 signature piece on first visit so live count is visible
        const initial = [
          {
            productId: "vibe-001",
            quantity: 1,
            size: "M",
            color: "Warm Sand"
          }
        ];
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(initial));
        return initial;
      }
      return JSON.parse(raw);
    } catch (e) {
      return [];
    }
  },

  saveItems(items) {
    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(items));
    this.updateHeaderBadge(true);
  },

  getDetailedItems() {
    const items = this.getItems();
    const catalog = window.VIBE_PRODUCTS || [];
    return items
      .map((item, index) => {
        const product = catalog.find((p) => p.id === item.productId);
        if (!product) return null;
        return {
          index,
          productId: item.productId,
          product,
          quantity: Number(item.quantity) || 1,
          size: item.size || (product.sizes && product.sizes[0]) || "One Size",
          color:
            item.color ||
            (product.colors && product.colors[0] && product.colors[0].name) ||
            "Default",
          lineTotal: product.price * (Number(item.quantity) || 1)
        };
      })
      .filter(Boolean);
  },

  addItem(productId, quantity = 1, size = "M", color = "Default") {
    const items = this.getItems();
    const product = (window.VIBE_PRODUCTS || []).find((p) => p.id === productId);
    const resolvedSize =
      size || (product && product.sizes && product.sizes[0]) || "One Size";
    const resolvedColor =
      color === "Default" && product && product.colors && product.colors[0]
        ? product.colors[0].name
        : color;

    const existing = items.find(
      (item) =>
        item.productId === productId &&
        item.size === resolvedSize &&
        item.color === resolvedColor
    );

    if (existing) {
      existing.quantity += Number(quantity) || 1;
    } else {
      items.push({
        productId,
        quantity: Number(quantity) || 1,
        size: resolvedSize,
        color: resolvedColor
      });
    }

    this.saveItems(items);

    const summary = this.calculateSummary("express");
    const shippingNote =
      summary.shippingCost === 0 ? " — ✓ Free Shipping Applied" : "";

    if (window.showVibeToast && product) {
      window.showVibeToast(
        `Added "${product.name}" (${resolvedSize}) to your bag${shippingNote}`
      );
    }
  },

  updateQuantity(index, newQuantity) {
    const items = this.getItems();
    if (!items[index]) return;
    if (newQuantity <= 0) {
      items.splice(index, 1);
    } else {
      items[index].quantity = Math.min(20, Number(newQuantity));
    }
    this.saveItems(items);
  },

  removeItemAtIndex(index) {
    const items = this.getItems();
    if (!items[index]) return;
    items.splice(index, 1);
    this.saveItems(items);
  },

  clearCart() {
    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify([]));
    localStorage.removeItem(PROMO_STORAGE_KEY);
    this.updateHeaderBadge(false);
  },

  getPromoCode() {
    return localStorage.getItem(PROMO_STORAGE_KEY) || "";
  },

  setPromoCode(code) {
    const cleaned = (code || "").trim().toUpperCase();
    if (cleaned === "VIBE10" || cleaned === "ATELIER10") {
      localStorage.setItem(PROMO_STORAGE_KEY, cleaned);
      return { valid: true, code: cleaned, discountRate: 0.1 };
    }
    if (!cleaned) {
      localStorage.removeItem(PROMO_STORAGE_KEY);
      return { valid: false, code: "", discountRate: 0 };
    }
    return { valid: false, code: cleaned, discountRate: 0 };
  },

  getCountry() {
    try {
      const stored = localStorage.getItem(COUNTRY_STORAGE_KEY);
      if (stored && typeof stored === "string" && stored.trim() !== "") {
        return stored.trim();
      }
    } catch (e) {
      // ignore
    }
    const wpDefault =
      window.VIBE_WP_CONFIG &&
      window.VIBE_WP_CONFIG.shipping &&
      window.VIBE_WP_CONFIG.shipping.defaultCountry;
    return wpDefault || "Pakistan";
  },

  setCountry(country) {
    if (!country) return;
    try {
      localStorage.setItem(COUNTRY_STORAGE_KEY, country);
    } catch (e) {
      // ignore
    }
  },

  getCountryShippingInfo(countryName) {
    const activeCountry = countryName || this.getCountry();
    const wpCountries =
      (window.VIBE_WP_CONFIG &&
        window.VIBE_WP_CONFIG.shipping &&
        window.VIBE_WP_CONFIG.shipping.countries) ||
      {};

    const found = wpCountries[activeCountry] || DEFAULT_COUNTRY_RATES[activeCountry];
    if (found) {
      return {
        country: activeCountry,
        code: found.code || "PK",
        isFree: !!found.isFree,
        standard: typeof found.standard === "number" ? found.standard : 0,
        express: typeof found.express === "number" ? found.express : 10,
        standardLabel:
          found.standardLabel ||
          (found.isFree
            ? "Free Shipping — Domestic Express (24–48 Hours)"
            : `DHL International Express — ${activeCountry} (3–5 Days)`),
        expressLabel:
          found.expressLabel ||
          `DHL Priority Air Courier — ${activeCountry} (1–2 Days)`
      };
    }

    // Fallback for unknown country
    const isPk = activeCountry.toLowerCase() === "pakistan";
    return {
      country: activeCountry,
      code: isPk ? "PK" : "INTL",
      isFree: isPk,
      standard: isPk ? 0 : 25,
      express: isPk ? 10 : 45,
      standardLabel: isPk
        ? "Free Shipping — Domestic Express Insured (24–48 Hours)"
        : `DHL International Express — ${activeCountry} (3–5 Days)`,
      expressLabel: isPk
        ? "TCS / Leopards Priority Express Courier (Same/Next Day)"
        : `DHL Priority Air Express — ${activeCountry} (1–2 Days)`
    };
  },

  getAllCountries() {
    const wpCountries =
      (window.VIBE_WP_CONFIG &&
        window.VIBE_WP_CONFIG.shipping &&
        window.VIBE_WP_CONFIG.shipping.countries) ||
      {};
    const keys = Object.keys(wpCountries);
    if (keys.length > 0) return keys;
    return Object.keys(DEFAULT_COUNTRY_RATES);
  },

  calculateSummary(shippingTier = "express", countryOverride = null) {
    const detailed = this.getDetailedItems();
    const subtotal = detailed.reduce((sum, item) => sum + item.lineTotal, 0);
    const activePromo = this.getPromoCode();
    const discountRate =
      activePromo === "VIBE10" || activePromo === "ATELIER10" ? 0.1 : 0;
    const discountAmount = Math.round(subtotal * discountRate);
    const discountedSubtotal = Math.max(0, subtotal - discountAmount);

    const country = countryOverride || this.getCountry();
    const shipInfo = this.getCountryShippingInfo(country);

    let shippingCost = 0;
    let shippingTitle = "";
    if (detailed.length === 0) {
      shippingCost = 0;
      shippingTitle = "Free";
    } else if (shippingTier === "sameday") {
      shippingCost = shipInfo.express;
      shippingTitle = shipInfo.expressLabel;
    } else {
      // Standard / Express Tier: Free for Pakistan ($0), paid rate for other countries
      shippingCost = shipInfo.standard;
      shippingTitle = shipInfo.standardLabel;
    }

    const total = discountedSubtotal + shippingCost;

    return {
      items: detailed,
      itemCount: this.getTotalCount(),
      subtotal,
      activePromo,
      discountAmount,
      country,
      shipInfo,
      shippingTier,
      shippingCost,
      shippingTitle,
      isFreeShipping: shippingCost === 0,
      standardCost: shipInfo.standard,
      expressCost: shipInfo.express,
      standardLabel: shipInfo.standardLabel,
      expressLabel: shipInfo.expressLabel,
      total,
      amountToFreeShipping: 0,
      freeShippingProgress: 100
    };
  },

  saveOrder(orderDetails) {
    const orders = this.getOrders();
    const newOrder = {
      orderId: "VB-ORD-" + Math.floor(100000 + Math.random() * 900000),
      createdAt: new Date().toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric"
      }),
      status: "Confirmed — Preparing in Milan Atelier",
      ...orderDetails
    };
    orders.unshift(newOrder);
    localStorage.setItem(ORDERS_STORAGE_KEY, JSON.stringify(orders));
    this.clearCart();
    return newOrder;
  },

  getOrders() {
    try {
      return JSON.parse(localStorage.getItem(ORDERS_STORAGE_KEY) || "[]");
    } catch (e) {
      return [];
    }
  },

  getTotalCount() {
    return this.getItems().reduce((sum, item) => sum + (Number(item.quantity) || 1), 0);
  },

  updateHeaderBadge(animate = false) {
    const badges = document.querySelectorAll("[data-cart-count]");
    const count = this.getTotalCount();
    badges.forEach((badge) => {
      badge.textContent = count;
      if (animate) {
        badge.classList.add("bump");
        setTimeout(() => badge.classList.remove("bump"), 300);
      }
    });
  }
};
