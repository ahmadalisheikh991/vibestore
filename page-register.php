<?php
/**
 * Template Name: Create Client Account
 *
 * @package VibeStore
 */

get_header();
?>

  <!-- MAIN REGISTER CONTENT -->
  <main>
    <section class="page-hero-banner" style="padding: 3rem 0;">
      <div class="container">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
          <a href="<?php echo vibestore_page_url( 'home' ); ?>">Home</a>
          <span>/</span>
          <a href="<?php echo vibestore_page_url( 'login' ); ?>">Client Account</a>
          <span>/</span>
          <span style="color:var(--color-obsidian);">Create Account</span>
        </nav>
        <h1 class="section-title" style="font-size:clamp(2.15rem, 3.8vw, 3.1rem);">
          Join the Maison
        </h1>
        <p class="section-subtitle" style="margin-top:0.5rem;">
          Create your private collector profile for early capsule access, bespoke sizing storage, and expedited checkout.
        </p>
      </div>
    </section>

    <section class="section-padding" style="padding-top: 3.5rem;">
      <div class="container">
        <div class="auth-split-container">
          <!-- Left Editorial Column -->
          <div class="auth-editorial-side">
            <div>
              <p class="section-eyebrow" style="color:var(--color-champagne);">Collector Privileges</p>
              <h2 class="section-title" style="color:var(--color-alabaster);font-size:2.2rem;margin-top:0.5rem;">
                Welcome to the Private Atelier.
              </h2>
              <p style="font-size:0.92rem;color:rgba(230,223,211,0.8);margin-top:1rem;line-height:1.7;">
                Every registered Vibe Store client receives complimentary global express shipping privileges on qualifying orders and personal invitations to our Milan, Paris, and New York previews.
              </p>
            </div>

            <div style="padding-top:2rem;border-top:1px solid rgba(255,255,255,0.14);font-size:0.8rem;color:var(--color-beige);display:flex;flex-direction:column;gap:0.55rem;">
              <span>✦ 10% First-Order Privilege Code (VIBE10)</span>
              <span>✦ Complimentary Linen &amp; Cedar Presentation</span>
              <span>✦ Dedicated Personal Concierge</span>
            </div>
          </div>

          <!-- Right Registration Form -->
          <div class="auth-form-side">
            <p class="section-eyebrow">New Client Registration</p>
            <h3 class="section-title" style="font-size:1.85rem;margin-bottom:1.5rem;">
              Create Your Account
            </h3>

            <form id="register-client-form">
              <div class="form-field-grid">
                <div>
                  <label for="reg-name" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                    Full Name *
                  </label>
                  <input
                    type="text"
                    id="reg-name"
                    class="luxury-input"
                    placeholder="Camille Laurent"
                    required
                  />
                </div>
                <div>
                  <label for="reg-email" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                    Email Address *
                  </label>
                  <input
                    type="email"
                    id="reg-email"
                    class="luxury-input"
                    placeholder="camille@domain.com"
                    required
                  />
                </div>
              </div>

              <div class="form-field-grid">
                <div>
                  <label for="reg-password" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                    Create Password *
                  </label>
                  <input
                    type="password"
                    id="reg-password"
                    class="luxury-input"
                    placeholder="Minimum 6 characters"
                    minlength="6"
                    required
                  />
                </div>
                <div>
                  <label for="reg-phone" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                    Mobile Telephone
                  </label>
                  <input
                    type="tel"
                    id="reg-phone"
                    class="luxury-input"
                    placeholder="+33 6 12 34 56 78"
                  />
                </div>
              </div>

              <div class="form-field-grid">
                <div>
                  <label for="reg-city" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                    Preferred Atelier Salon
                  </label>
                  <select id="reg-city" class="luxury-select">
                    <option value="Milan Flagship">Milan Flagship</option>
                    <option value="Paris Salon">Paris Salon</option>
                    <option value="New York Gallery">New York Gallery</option>
                    <option value="Tokyo Showroom">Tokyo Showroom</option>
                  </select>
                </div>
                <div>
                  <label for="reg-address" style="display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.14em;font-weight:600;margin-bottom:0.4rem;">
                    Primary Delivery Address
                  </label>
                  <input
                    type="text"
                    id="reg-address"
                    class="luxury-input"
                    placeholder="Street, City, Country"
                  />
                </div>
              </div>

              <button type="submit" class="btn btn-primary" style="width:100%;margin-top:0.5rem;">
                <span>Complete Registration</span>
                <span>→</span>
              </button>
            </form>

            <p style="margin-top:1.5rem;font-size:0.85rem;color:var(--color-charcoal);text-align:center;">
              Already have a client account?
              <a href="<?php echo vibestore_page_url( 'login' ); ?>" style="color:var(--color-obsidian);font-weight:600;text-decoration:underline;">
                Sign In Here →
              </a>
            </p>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();

