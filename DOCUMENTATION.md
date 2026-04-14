# Flavor Theme — Developer Documentation

A modern, high-performance WooCommerce theme built with **Tailwind CSS**, **Alpine.js**, and **Swiper.js**. Designed for electronics/tech e-commerce stores with a clean, mobile-first UI.

---

## Table of Contents

1. [Features](#features)
2. [Requirements & Installation](#requirements--installation)
3. [Template Structure](#template-structure)
4. [Customizer Settings Reference](#customizer-settings-reference)
5. [Homepage Sections](#homepage-sections)
6. [AJAX Product Loading](#ajax-product-loading)
7. [Alpine.js Components](#alpinejs-components)
8. [Tailwind CSS Customization](#tailwind-css-customization)
9. [WooCommerce Template Overrides](#woocommerce-template-overrides)
10. [Troubleshooting](#troubleshooting)

---

## Features

- **Tailwind CSS** utility-first styling with compiled CSS output
- **Alpine.js** for reactive UI components (no jQuery dependency for custom features)
- **Swiper.js** carousels for hero slider, product sliders, brand logos
- **GLightbox** for product image lightbox galleries
- **Mobile-first** responsive design with bottom navigation bar
- **Accordion checkout** with step-by-step flow (billing → shipping → payment → review)
- **AJAX product loading** with infinite scroll and tabbed filtering
- **Live search** with instant product results
- **Mini cart** slide-out drawer with quantity controls
- **Wishlist** system (user meta for logged-in, localStorage for guests)
- **Product filtering** — price range, brand, rating, stock status, sorting
- **Mega menu** with category navigation
- **USP bar**, promo banners, special offers with countdown timers
- **Brand logos** section with Swiper carousel on mobile
- **Cookie consent** banner
- **Toast notifications** for add-to-cart feedback
- **Warranty upsell** on product pages
- **Installment price** display

---

## Requirements & Installation

### Requirements

| Dependency | Minimum Version |
|---|---|
| WordPress | 6.0+ |
| WooCommerce | 7.0+ |
| PHP | 7.4+ |
| Node.js | 16+ (for development/Tailwind compilation) |

### Installation

1. Upload the `flavor-theme` folder to `wp-content/themes/`
2. Activate via **Appearance → Themes**
3. Install and activate **WooCommerce** if not already present
4. Go to **Appearance → Customize** to configure sections
5. Set the homepage to display a static page (Settings → Reading → "A static page") and select a page using the **Front Page** template, or set the front page to your desired page

### Development Setup

```bash
cd wp-content/themes/flavor-theme
npm install          # Install Tailwind + dependencies
npm run dev          # Watch mode for Tailwind compilation
npm run build        # Production build (minified CSS)
```

The compiled CSS outputs to `assets/css/dist/style.css`.

---

## Template Structure

```
flavor-theme/
├── front-page.php              # Homepage template
├── header.php                  # Site header (loads top-bar, main-header, mega-menu)
├── footer.php                  # Site footer + bottom nav + cookie consent
├── functions.php               # Theme bootstrap (loads all inc/ files)
├── page.php                    # Generic page template
├── search.php                  # Search results
├── 404.php                     # Not found page
├── page-wishlist.php           # Wishlist page template
│
├── assets/
│   ├── css/dist/style.css      # Compiled Tailwind CSS
│   └── js/src/
│       ├── alpine-components.js  # Alpine.js data components
│       ├── app.js                # Global JS (mini cart, toast, etc.)
│       ├── header.js             # Header interactions
│       ├── slider.js             # Hero slider init (Swiper)
│       ├── products.js           # Homepage product loading
│       ├── product-page.js       # Single product gallery/tabs
│       ├── filters.js            # Shop page AJAX filtering
│       ├── cart.js               # Cart page interactions
│       └── checkout.js           # Checkout page logic
│
├── inc/
│   ├── theme-setup.php         # add_theme_support, menus, image sizes
│   ├── enqueue.php             # Script/style enqueuing + localization
│   ├── ajax-handlers.php       # All AJAX endpoints
│   ├── woocommerce.php         # WooCommerce hooks/filters
│   ├── template-tags.php       # Helper template functions
│   ├── widgets.php             # Widget registrations
│   └── customizer/
│       ├── customizer.php      # Loads all customizer sections
│       ├── header.php          # Header settings
│       ├── footer.php          # Footer settings (social URLs)
│       ├── homepage.php        # All homepage section settings
│       ├── shop.php            # Shop/archive settings
│       ├── product.php         # Single product settings
│       └── cart.php            # Cart page settings
│
├── template-parts/
│   ├── global/
│   │   ├── bottom-nav.php      # Mobile bottom navigation bar
│   │   ├── breadcrumbs.php     # Breadcrumb trail
│   │   ├── cookie-consent.php  # GDPR cookie banner
│   │   ├── empty-states.php    # Empty state illustrations
│   │   ├── page-skeleton.php   # Loading skeleton placeholder
│   │   ├── scroll-to-top.php   # Scroll-to-top button
│   │   └── toast-notifications.php  # Toast notification container
│   ├── header/
│   │   ├── main-header.php     # Logo, search, cart, account
│   │   ├── top-bar.php         # Top announcement bar
│   │   ├── mega-menu.php       # Category mega menu
│   │   ├── mini-cart.php       # Slide-out mini cart drawer
│   │   ├── mobile-menu.php     # Mobile hamburger menu
│   │   ├── quick-links.php     # Quick link buttons
│   │   └── search-bar.php      # Live search component
│   ├── homepage/
│   │   ├── hero-area.php       # Hero slider (Swiper)
│   │   ├── usp-bar.php         # USP badges strip
│   │   ├── tabbed-products.php # Category-tabbed product grid
│   │   ├── promo-banner.php    # Full-width promo image
│   │   ├── special-offers.php  # On-sale products + countdown
│   │   ├── all-products.php    # All products with load more
│   │   ├── popular-categories.php  # Category grid
│   │   └── brand-logos.php     # Brand logos strip
│   └── product/
│       ├── product-card.php    # Product card component
│       ├── product-card-skeleton.php  # Loading skeleton
│       ├── product-gallery.php # Image gallery (Swiper + GLightbox)
│       ├── product-info.php    # Price, add-to-cart, meta
│       ├── product-tabs.php    # Description/reviews tabs
│       ├── cross-sells.php     # Cross-sell products
│       ├── warranty-upsell.php # Extended warranty option
│       ├── installment-display.php  # Monthly payment calculator
│       └── shipping-estimate.php    # Estimated delivery
│
└── woocommerce/                # WooCommerce template overrides
    ├── archive-product.php     # Shop/category archive
    ├── content-product.php     # Product in loop
    ├── single-product.php      # Single product page
    ├── cart/
    │   ├── cart.php            # Cart page
    │   └── cart-empty.php      # Empty cart
    ├── checkout/
    │   ├── form-checkout.php   # Accordion checkout
    │   └── thankyou.php        # Order confirmation
    └── myaccount/
        ├── my-account.php      # Account dashboard layout
        ├── dashboard.php       # Dashboard tab
        ├── form-login.php      # Login/register form
        ├── form-edit-account.php  # Edit account
        ├── form-edit-address.php  # Edit address
        ├── orders.php          # Order history
        └── wishlist.php        # Wishlist tab
```

---

## Customizer Settings Reference

Access via **Appearance → Customize**.

### Header (`flavor_header` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_topbar_enabled` | Checkbox | `true` | Show/hide top announcement bar |
| `flavor_topbar_text` | Text | — | Top bar message text |
| `flavor_topbar_link` | URL | — | Top bar link URL |
| `flavor_logo` | Image | — | Site logo |
| `flavor_sticky_header` | Checkbox | `true` | Enable sticky header on scroll |

### Homepage (`flavor_homepage` panel)

#### Hero Slider (`flavor_hero_slider` section)
- Up to **5 slides**, each with:
  - `flavor_hero_slide_{n}_image` — Desktop image
  - `flavor_hero_slide_{n}_image_mobile` — Mobile image
  - `flavor_hero_slide_{n}_link` — Click-through URL
  - `flavor_hero_slide_{n}_alt` — Alt text

#### USP Bar (`flavor_usp_bar` section)
| Setting | Type | Description |
|---|---|---|
| `flavor_usp_enabled` | Checkbox | Enable USP bar |
| `flavor_usp_{n}_title` | Text | USP title (4 slots) |
| `flavor_usp_{n}_subtitle` | Text | USP subtitle |
| `flavor_usp_{n}_icon` | Textarea | Inline SVG markup |

#### Tabbed Products (`flavor_tabbed_products` section)
| Setting | Type | Description |
|---|---|---|
| `flavor_tabbed_products_enabled` | Checkbox | Enable section |
| `flavor_tabbed_products_title` | Text | Section heading |
| `flavor_tabbed_products_categories` | Text | Comma-separated category IDs |
| `flavor_tabbed_products_see_all_link` | URL | "See All" link |

#### Promo Banner (`flavor_promo_banner` section)
| Setting | Type | Description |
|---|---|---|
| `flavor_promo_banner_enabled` | Checkbox | Enable banner |
| `flavor_promo_banner_image` | Image | Desktop image (1360×240) |
| `flavor_promo_banner_image_mobile` | Image | Mobile image |
| `flavor_promo_banner_link` | URL | Click-through URL |

#### Special Offers (`flavor_special_offers` section)
| Setting | Type | Description |
|---|---|---|
| `flavor_special_offers_enabled` | Checkbox | Enable section |
| `flavor_special_offers_title` | Text | Section heading |
| `flavor_special_offers_countdown` | Datetime | Countdown end date |

#### All Products (`flavor_all_products` section)
| Setting | Type | Description |
|---|---|---|
| `flavor_all_products_enabled` | Checkbox | Enable section |
| `flavor_all_products_title` | Text | Section heading |
| `flavor_all_products_per_page` | Number | Products per page (4–20) |

#### Popular Categories (`flavor_popular_cats` section)
| Setting | Type | Description |
|---|---|---|
| `flavor_popular_cats_enabled` | Checkbox | Enable section |
| `flavor_popular_cats_title` | Text | Section heading |
| `flavor_popular_cats_ids` | Text | Category IDs (comma-separated, or auto) |

#### Brand Logos (`flavor_brands` section)
| Setting | Type | Description |
|---|---|---|
| `flavor_brands_enabled` | Checkbox | Enable brand logos |
| `flavor_brands_title` | Text | Section heading |
| `flavor_brand_logo_{n}_image` | Image | Brand logo (8 slots) |
| `flavor_brand_logo_{n}_name` | Text | Brand name |
| `flavor_brand_logo_{n}_link` | URL | Brand link |

### Shop Settings (`flavor_shop` section)
| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_products_per_page` | Number | `12` | Products per page on shop/archive |

### Product Page (`flavor_product` section)
| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_installment_display` | Checkbox | `true` | Show installment price calculator |

### Cart (`flavor_cart` section)
| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_cart_cross_sells` | Checkbox | `true` | Show cross-sells on cart page |

### Footer (`flavor_footer` section)
| Setting | Type | Description |
|---|---|---|
| `flavor_social_facebook` | URL | Facebook page URL |
| `flavor_social_twitter` | URL | Twitter/X profile URL |
| `flavor_social_instagram` | URL | Instagram profile URL |

---

## Homepage Sections

The homepage is rendered by `front-page.php`, which loads template parts in this order:

1. **Hero Area** — Full-width Swiper slider
2. **USP Bar** — Trust badges (free shipping, warranty, etc.)
3. **Tabbed Products** — Category-tabbed product grid (AJAX loaded)
4. **Promo Banner** — Full-width promotional image
5. **Special Offers** — On-sale products with countdown timer
6. **All Products** — Product grid with "Load More" infinite scroll
7. **Popular Categories** — Category cards grid
8. **Brand Logos** — Brand logo strip

### Adding a New Homepage Section

1. Create `template-parts/homepage/your-section.php`
2. Add the `get_template_part()` call in `front-page.php` at the desired position
3. Add Customizer settings in `inc/customizer/homepage.php` (inside `flavor_customizer_homepage()`)
4. Use the pattern: check `get_theme_mod('flavor_your_section_enabled', true)` at the top

### Removing/Reordering Sections

Edit `front-page.php` — comment out or reorder the `get_template_part()` calls.

---

## AJAX Product Loading

All AJAX endpoints are in `inc/ajax-handlers.php`. The theme localizes `flavorData` on every page with:

```js
window.flavorData = {
    ajaxUrl: '/wp-admin/admin-ajax.php',
    nonce: '...',
    homeUrl: '/',
    cartUrl: '/cart/',
    checkoutUrl: '/checkout/',
};
```

### Endpoints

| Action | Purpose | Key Parameters |
|---|---|---|
| `flavor_load_products` | Load products for homepage tabs | `category`, `per_page`, `context` |
| `flavor_load_more_products` | Infinite scroll | `page`, `per_page` |
| `flavor_filter_products` | Shop page AJAX filter | `price_min`, `price_max`, `brands`, `rating`, `in_stock`, `sort`, `page`, `product_cat` |
| `flavor_quick_filter` | Quick filter tabs | `tab` (bestseller/most-viewed/top-rated), `product_cat` |
| `flavor_add_to_cart` | Add product with optional warranty | `product_id`, `quantity`, `warranty` |
| `flavor_toggle_wishlist` | Toggle wishlist status | `product_id` |
| `flavor_get_wishlist_products` | Get wishlist product cards | `product_ids` (comma-separated) |
| `flavor_live_search` | Instant search results | `query` |
| `flavor_mini_cart_remove` | Remove cart item | `cart_key` |
| `flavor_mini_cart_qty` | Update cart item qty | `cart_key`, `quantity` |

### Example: Making an AJAX Call

```js
const fd = new FormData();
fd.append('action', 'flavor_load_products');
fd.append('nonce', flavorData.nonce);
fd.append('category', 15);
fd.append('per_page', 10);

fetch(flavorData.ajaxUrl, { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            document.querySelector('.products-grid').innerHTML = res.data.html;
        }
    });
```

---

## Alpine.js Components

Registered in `assets/js/src/alpine-components.js` via `Alpine.data()` inside the `alpine:init` event.

### `flavorTabbedProducts`

Homepage tabbed product grid with category switching.

```html
<div x-data="flavorTabbedProducts({ initialTab: 'for-you', initialCat: 0 })">
```

**Properties:** `activeTab`, `activeCat`, `loading`, `productsHtml`
**Methods:** `switchTab(slug, cat)`, `loadProducts()`

### `flavorSpecialOffers`

Special offers carousel with countdown timer.

**Properties:** `products[]`, `loading`, `countdown`
**Methods:** `loadOffers()`, `startCountdown(endDate)`

### `flavorAllProducts`

Infinite-scroll product grid.

**Properties:** `productsHtml`, `page`, `loading`, `hasMore`
**Methods:** `loadMore()`

### `checkoutAccordion`

Multi-step accordion checkout flow.

**Properties:** `step`, `completed[]`, `placing`, `paymentMethod`, `useSavedAddress`, `shipDifferent`
**Methods:** `toggle(n)`, `validateStep(n)`, `markComplete(n)`

### Other Components

- **`flavorMiniCart`** — Slide-out cart drawer
- **`flavorSearch`** — Live search with debounce
- **`flavorProductGallery`** — Image gallery with Swiper + GLightbox
- **`flavorFilters`** — Shop page sidebar filters
- **`flavorWishlist`** — Wishlist toggle (localStorage + user meta)

---

## Tailwind CSS Customization

### Configuration

The theme uses a `tailwind.config.js` at the theme root. Key customizations:

```js
module.exports = {
    content: [
        './**/*.php',
        './assets/js/src/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                primary: 'var(--color-primary, #E15726)',
            },
        },
    },
};
```

### CSS Custom Properties

The primary color uses a CSS custom property `--color-primary` (default: `#E15726`), allowing runtime color changes via the Customizer or custom CSS.

### Building CSS

```bash
npm run dev    # Watch mode
npm run build  # Production (minified)
```

Output: `assets/css/dist/style.css`

### Common Class Patterns

**Form inputs (consistent across theme):**
```
rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm
focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white
```

**Cards:**
```
bg-white rounded-2xl border border-gray-200 shadow-sm
```

**Primary buttons:**
```
bg-primary text-white font-semibold px-6 py-3 rounded-xl hover:opacity-90
```

---

## WooCommerce Template Overrides

The theme overrides these WooCommerce templates in the `woocommerce/` directory:

| Template | What It Customizes |
|---|---|
| `archive-product.php` | Shop page with AJAX filtering sidebar |
| `content-product.php` | Product card in archive loops |
| `single-product.php` | Single product page layout |
| `cart/cart.php` | Cart page with cross-sells |
| `cart/cart-empty.php` | Empty cart state |
| `checkout/form-checkout.php` | Accordion-style checkout |
| `checkout/thankyou.php` | Order confirmation page |
| `myaccount/my-account.php` | Account page layout |
| `myaccount/dashboard.php` | Account dashboard |
| `myaccount/form-login.php` | Login/register forms |
| `myaccount/form-edit-account.php` | Edit account form |
| `myaccount/form-edit-address.php` | Edit address form |
| `myaccount/orders.php` | Order history list |
| `myaccount/wishlist.php` | Wishlist page |

### Important: WooCommerce Hooks

All template overrides preserve WooCommerce's `do_action()` hooks. When customizing, always keep these hooks intact:

- `woocommerce_before_checkout_form` / `woocommerce_after_checkout_form`
- `woocommerce_checkout_before_customer_details` / `woocommerce_checkout_after_customer_details`
- `woocommerce_before_checkout_billing_form` / `woocommerce_after_checkout_billing_form`
- `woocommerce_checkout_order_review`
- `woocommerce_review_order_before_submit` / `woocommerce_review_order_after_submit`

Removing these hooks will break payment gateways, shipping plugins, and other WooCommerce extensions.

### Updating After WooCommerce Updates

When WooCommerce releases updates, check if the base templates have changed:
1. Compare your overrides against `wp-content/plugins/woocommerce/templates/`
2. WooCommerce logs template version mismatches in **WooCommerce → Status → System Status**

---

## Troubleshooting

### Products Not Loading on Homepage

- Check the browser console for JavaScript errors
- Verify `flavorData.nonce` is present (inspect page source for `flavorData`)
- Confirm AJAX handlers are loaded: check `inc/ajax-handlers.php` is required in `functions.php`

### Tailwind Classes Not Working

- Ensure `assets/css/dist/style.css` exists and is up to date
- Run `npm run build` to recompile
- Check `tailwind.config.js` content paths include your PHP files

### Checkout Accordion Not Expanding

- Verify Alpine.js is loaded (check console for `Alpine` global)
- Ensure `alpine-components.js` loads **before** Alpine.js (check enqueue order in `inc/enqueue.php`)
- Check for `x-cloak` styles: `[x-cloak]{display:none!important}` must be in `<head>`

### Mini Cart Not Updating

- Check AJAX nonce: ensure `flavorData.nonce` matches the server-side nonce
- Verify WooCommerce cart session is active
- Clear any full-page caching (AJAX requests must bypass cache)

### Images Not Showing Correct Size

The theme registers custom image sizes:
- `flavor-product-card` — 300×300 (soft crop)
- `flavor-product-gallery` — 600×600 (soft crop)

After theme activation, regenerate thumbnails:
```bash
wp media regenerate --yes
```

### Customizer Settings Not Saving

- Check for PHP errors in `debug.log`
- Ensure sanitize callbacks are valid functions
- Clear browser cache and try in incognito mode

### Swiper Carousel Not Working

- Verify Swiper JS/CSS is loaded (check Network tab)
- CDN: `cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js`
- Ensure the Swiper initialization runs after DOM ready

### Performance Tips

- Enable object caching (Redis/Memcached) for AJAX-heavy pages
- Use a CDN for static assets
- Consider lazy-loading product images (the theme uses `loading="lazy"`)
- Minify the compiled Tailwind CSS: `npm run build`

---

## License

Flavor Theme is proprietary software. All rights reserved.
