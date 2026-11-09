<?php
/**
 * Template Name: Contact Client Concierge
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- MAIN CONTACT PAGE CONTENT -->
  <main>
    <!-- 3. EDITORIAL HERO BANNER -->
    <section class="page-hero-banner">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <span style="color:var(--color-obsidian);">Client Concierge</span>
        </nav>
        <p class="section-eyebrow">Personal Assistance — Global Salons</p>
        <h1 class="section-title" style="font-size:clamp(2.35rem, 4vw, 3.5rem);">
          Contact Our Concierge
        </h1>
        <p class="section-subtitle" style="margin-top:0.75rem;max-width:580px;">
          Whether you require bespoke garment measurements, private showroom
          appointments, or assistance with an existing order, our directors are
          at your service.
        </p>
      </div>
    </section>

    <!-- 4. CONTACT INFORMATION + INTERACTIVE CONTACT FORM -->
    <section class="section-padding">
      <div class="container contact-layout">
        <!-- Left: Email, Phone, Business Addresses & Socials -->
        <aside class="contact-info-panel reveal-on-scroll">
          <p class="section-eyebrow" style="color:var(--color-beige);">Direct Channels</p>
          <h2 class="section-title" style="color:var(--color-alabaster);font-size:2rem;margin-bottom:1.5rem;">
            Maison Directory
          </h2>

          <!-- Email Information -->
          <div class="contact-detail-block">
            <p class="contact-detail-label">Electronic Mail</p>
            <p style="font-size:0.95rem;color:var(--color-alabaster);font-weight:500;">
              Client Care: <a href="mailto:concierge@vibestore.luxury" style="text-decoration:underline;">concierge@vibestore.luxury</a>
            </p>
            <p style="font-size:0.86rem;color:rgba(230,223,211,0.75);margin-top:0.25rem;">
              Private Styling: bespoke@vibestore.luxury<br />
              Press &amp; Editorial: press@vibestore.luxury
            </p>
          </div>

          <!-- Phone Information -->
          <div class="contact-detail-block">
            <p class="contact-detail-label">Telephone Concierge</p>
            <p style="font-size:0.95rem;color:var(--color-alabaster);font-weight:500;">
              Milan Flagship: <a href="tel:+390289452100">+39 02 8945 2100</a>
            </p>
            <p style="font-size:0.86rem;color:rgba(230,223,211,0.75);margin-top:0.25rem;">
              New York Salon: +1 (212) 555-0194<br />
              Hours: Mon – Sat, 9:00 AM – 7:00 PM CET
            </p>
          </div>

          <!-- Business Address -->
          <div class="contact-detail-block">
            <p class="contact-detail-label">Global Showrooms &amp; Addresses</p>
            <p style="font-size:0.92rem;color:var(--color-alabaster);font-weight:500;">
              Milan Atelier &amp; Flagship
            </p>
            <p style="font-size:0.84rem;color:rgba(230,223,211,0.75);margin-bottom:0.75rem;">
              Via Montenapoleone 18, 20121 Milano MI, Italy
            </p>

            <p style="font-size:0.92rem;color:var(--color-alabaster);font-weight:500;">
              Paris Salon
            </p>
            <p style="font-size:0.84rem;color:rgba(230,223,211,0.75);margin-bottom:0.75rem;">
              242 Rue Saint-Honoré, 75001 Paris, France
            </p>

            <p style="font-size:0.92rem;color:var(--color-alabaster);font-weight:500;">
              New York Gallery
            </p>
            <p style="font-size:0.84rem;color:rgba(230,223,211,0.75);">
              114 Mercer Street, SoHo, New York, NY 10012
            </p>
          </div>

          <!-- Social Media Links -->
          <div class="contact-detail-block" style="padding-bottom:0;">
            <p class="contact-detail-label">Social Channels</p>
            <div class="footer-socials" style="margin-top:0.75rem;">
              <a href="https://instagram.com" target="_blank" rel="noreferrer" class="social-pill">Instagram</a>
              <a href="https://pinterest.com" target="_blank" rel="noreferrer" class="social-pill">Pinterest</a>
              <a href="https://linkedin.com" target="_blank" rel="noreferrer" class="social-pill">LinkedIn</a>
              <a href="https://youtube.com" target="_blank" rel="noreferrer" class="social-pill">Runway Film</a>
            </div>
          </div>
        </aside>

        <!-- Right: Interactive Contact Concierge Form -->
        <div class="contact-form-panel reveal-on-scroll">
          <p class="section-eyebrow">Send a Dispatch</p>
          <h2 class="section-title" style="font-size:2rem;margin-bottom:0.5rem;">
            Private Client Inquiry Form
          </h2>
          <p style="font-size:0.88rem;color:var(--color-charcoal);margin-bottom:2rem;">
            Complete the form below. Every inquiry is assigned a personal
            concierge reference number and answered within 4 business hours.
          </p>

          <div
            id="contact-success-box"
            style="display:none;margin-bottom:1.75rem;padding:1.25rem 1.5rem;background-color:var(--color-beige-light);border:1px solid var(--color-champagne);border-radius:var(--radius-sm);font-size:0.88rem;color:var(--color-obsidian);"
          ></div>

          <form id="contact-concierge-form">
            <div class="form-field-grid">
              <div>
                <label for="contact-name" style="display:block;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.45rem;">
                  Full Name *
                </label>
                <input
                  type="text"
                  id="contact-name"
                  class="luxury-input"
                  placeholder="e.g., Camille Laurent"
                  required
                />
              </div>
              <div>
                <label for="contact-email" style="display:block;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.45rem;">
                  Email Address *
                </label>
                <input
                  type="email"
                  id="contact-email"
                  class="luxury-input"
                  placeholder="camille@domain.com"
                  required
                />
              </div>
            </div>

            <div class="form-field-grid">
              <div>
                <label for="contact-phone" style="display:block;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.45rem;">
                  Telephone (Optional)
                </label>
                <input
                  type="tel"
                  id="contact-phone"
                  class="luxury-input"
                  placeholder="+33 6 00 00 00 00"
                />
              </div>
              <div>
                <label for="contact-subject" style="display:block;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.45rem;">
                  Inquiry Topic *
                </label>
                <select id="contact-subject" class="luxury-select" required>
                  <option value="Bespoke Sizing & Fit Advice">Bespoke Sizing &amp; Fit Advice</option>
                  <option value="Order Status & Express Delivery">Order Status &amp; Express Delivery</option>
                  <option value="Private Showroom Appointment">Private Showroom Appointment</option>
                  <option value="Returns & Exchanges">Returns &amp; Exchanges</option>
                  <option value="Press & Wholesale">Press &amp; Archive Loans</option>
                </select>
              </div>
            </div>

            <div style="margin-bottom:1.5rem;">
              <label for="contact-message" style="display:block;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.45rem;">
                Your Message *
              </label>
              <textarea
                id="contact-message"
                rows="5"
                class="luxury-textarea"
                placeholder="Please share any garment names, order numbers, or preferred salon appointment dates..."
                required
              ></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
              <span>Transmit to Client Concierge</span>
              <span>→</span>
            </button>
          </form>
        </div>
      </div>
    </section>

    <!-- 5. FREQUENTLY ASKED QUESTIONS SECTION ON CONTACT PAGE -->
    <section
      id="contact-faq-section"
      class="section-padding"
      style="background-color:var(--color-stone);border-top:1px solid var(--color-border);"
    >
      <div class="container">
        <div class="section-header reveal-on-scroll" style="max-width:880px;margin:0 auto 2.5rem;">
          <div>
            <p class="section-eyebrow">Immediate Answers</p>
            <h2 class="section-title">Frequently Asked Questions</h2>
          </div>
          <a href="<?php echo vibestore_page_url( 'faq' ); ?>" class="nav-link active">View Complete FAQ Directory →</a>
        </div>

        <div class="faq-accordion-list reveal-on-scroll">
          <div class="faq-item open">
            <button type="button" class="faq-trigger">
              <span>How quickly are orders dispatched and delivered?</span>
              <span class="faq-icon">−</span>
            </button>
            <div class="faq-body">
              <p>
                All orders placed before 2:00 PM CET are dispatched the same
                business day from our Milan logistics studio via insured DHL
                Express. Delivery takes 24–48 hours to Europe and North America,
                and 48–72 hours to Asia-Pacific and the Middle East. Orders over
                $250 receive complimentary express shipping automatically.
              </p>
            </div>
          </div>

          <div class="faq-item">
            <button type="button" class="faq-trigger">
              <span>What is your return and exchange policy?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-body">
              <p>
                We offer complimentary 30-day returns and exchanges on all
                unworn garments with original tags and linen presentation bags
                intact. Simply contact our concierge or initiate a courier pickup
                from your client account for an instant size exchange or full
                refund.
              </p>
            </div>
          </div>

          <div class="faq-item">
            <button type="button" class="faq-trigger">
              <span>Can I book a private styling appointment in Milan, Paris, or online?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-body">
              <p>
                Yes. Select “Private Showroom Appointment” in the inquiry form
                above to schedule a one-on-one session with our senior wardrobe
                stylists either in person at our Milan, Paris, or New York
                locations, or via private high-definition video consultation.
              </p>
            </div>
          </div>

          <div class="faq-item">
            <button type="button" class="faq-trigger">
              <span>How do I care for double-faced cashmere and extra-fine merino wool?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-body">
              <p>
                Brush outerwear gently with a soft garment bristle brush after
                wear and air out on the wide cedar hanger provided with your
                order. For knitwear, hand wash cold using pH-neutral cashmere
                shampoo and dry flat on a towel away from direct heat.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();

