# Flavor Theme — Documentation

## Table of Contents

1. [Overview](#1-overview)
2. [Installation](#2-installation)
3. [Customizer Settings](#3-customizer-settings)
4. [Homepage Sections](#4-homepage-sections)
5. [Template Structure](#5-template-structure)
6. [JavaScript Architecture](#6-javascript-architecture)
7. [AJAX Endpoints](#7-ajax-endpoints)
8. [WooCommerce Template Overrides](#8-woocommerce-template-overrides)
9. [CSS / Tailwind](#9-css--tailwind)
10. [Adding Content Guide](#10-adding-content-guide)

---

## 1. Overview

**Flavor** is a modern WooCommerce theme inspired by [gjirafa50.com](https://gjirafa50.com). It delivers a fast, mobile-first e-commerce experience using a modern front-end stack.

| Component | Version |
|---|---|
| WordPress | 6.x |
| WooCommerce | 8.x |
| Tailwind CSS | 3.x |
| Alpine.js | 3.x |
| Swiper.js | Latest |
| GLightbox | Latest |

**Primary color:** `#E15726` (configurable via CSS custom property `--color-primary`)

---

## 2. Installation

### Requirements

- PHP 8.x
- WordPress 6.x
- WooCommerce 8.x
- Node.js (for development / building assets)

### Steps

1. **Upload** the `flavor-theme` folder to `wp-content/themes/` (or install via ZIP in Appearance → Themes → Add New).
2. **Activate** the theme in Appearance → Themes.
3. **Install & activate WooCommerce** if not already present.
4. Go to **Appearance → Customize** to configure all theme settings.
5. Create a **static front page** and set it under Settings → Reading.

### Development Build

```bash
npm install
npm run dev    # watch mode
npm run build  # production
```

---

## 3. Customizer Settings

All settings are registered via `inc/customizer/*.php` and loaded by `inc/customizer/customizer.php`.

### 3.1 Header (`flavor_header` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_topbar_enabled` | Checkbox | `true` | Show/hide the top announcement bar |
| `flavor_topbar_text` | Text | `"Free shipping on orders over €50"` | Top bar message text |
| `flavor_topbar_bg_color` | Color | `#1A1A1A` | Top bar background color |
| `flavor_sticky_header` | Checkbox | `true` | Make header sticky on scroll |
| `flavor_search_placeholder` | Text | `"Search products..."` | Placeholder text in search input |
| `flavor_bottom_nav` | Checkbox | `true` | Show mobile bottom navigation bar |

### 3.2 Homepage (`flavor_homepage` panel)

#### Hero Slider (`flavor_hero_slider` section)

Up to **5 slides**, each with:

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_hero_slide_{n}_image` | Image | `""` | Desktop slide image |
| `flavor_hero_slide_{n}_image_mobile` | Image | `""` | Mobile slide image |
| `flavor_hero_slide_{n}_link` | URL | `""` | Click-through URL |
| `flavor_hero_slide_{n}_alt` | Text | `""` | Alt text for accessibility |

#### USP Bar (`flavor_usp_bar` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_usp_enabled` | Checkbox | `true` | Enable/disable USP bar |

Up to **4 USPs**, each with:

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_usp_{n}_title` | Text | `""` | USP headline (e.g. "Free Shipping") |
| `flavor_usp_{n}_subtitle` | Text | `""` | USP description |
| `flavor_usp_{n}_icon` | Textarea (SVG) | `""` | Inline SVG icon markup |

#### Tabbed Products (`flavor_tabbed_products` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_tabbed_products_enabled` | Checkbox | `true` | Enable/disable section |
| `flavor_tabbed_products_title` | Text | `"Recommended for you"` | Section heading |
| `flavor_tabbed_products_categories` | Text | `""` | Comma-separated category IDs for tabs |
| `flavor_tabbed_products_see_all_link` | URL | `""` | "See All" button destination |

#### Promo Banner (`flavor_promo_banner` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_promo_banner_enabled` | Checkbox | `true` | Enable/disable banner |
| `flavor_promo_banner_image` | Image | `""` | Desktop image (recommended 1360×240) |
| `flavor_promo_banner_image_mobile` | Image | `""` | Mobile image |
| `flavor_promo_banner_link` | URL | `""` | Click-through URL |

#### Special Offers (`flavor_special_offers` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_special_offers_enabled` | Checkbox | `true` | Enable/disable section |
| `flavor_special_offers_title` | Text | `"Special Offers"` | Section heading |
| `flavor_special_offers_countdown` | Datetime | `""` | Countdown timer end date (ISO format) |

#### All Products (`flavor_all_products` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_all_products_enabled` | Checkbox | `true` | Enable/disable section |
| `flavor_all_products_title` | Text | `"All Products"` | Section heading |
| `flavor_all_products_per_page` | Number | `10` | Products to display (4–20) |

#### Popular Categories (`flavor_popular_cats` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_popular_cats_enabled` | Checkbox | `true` | Enable/disable section |
| `flavor_popular_cats_title` | Text | `"Popular Categories"` | Section heading |
| `flavor_popular_cats_ids` | Text | `""` | Comma-separated category IDs (empty = auto) |

#### Brand Logos (`flavor_brands` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_brands_enabled` | Checkbox | `true` | Enable/disable section |
| `flavor_brands_title` | Text | `"Our Brands"` | Section heading |

Up to **8 brands**, each with:

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_brand_logo_{n}_image` | Image | `""` | Brand logo image |
| `flavor_brand_logo_{n}_name` | Text | `""` | Brand name (alt text) |
| `flavor_brand_logo_{n}_link` | URL | `""` | Link to brand page |

### 3.3 Shop Settings (`flavor_shop` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_products_per_page` | Number | `12` | Products per page (4–48) |
| `flavor_default_sort` | Select | `"menu_order"` | Default sort: menu_order, date, popularity, rating, price, price-desc |
| `flavor_grid_columns` | Number | `4` | Desktop grid columns (3–5) |
| `flavor_show_filter_button` | Checkbox | `true` | Show the filter toggle button |
| `flavor_show_quick_filter_tabs` | Checkbox | `true` | Show quick-filter tabs (bestseller, most-viewed, top-rated) |

### 3.4 Product Page Settings (`flavor_product` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_installment_display` | Checkbox | `true` | Show installment payment calculator |
| `flavor_installment_months` | Text | `"24,36"` | Available installment periods |
| `flavor_warranty_upsell` | Checkbox | `true` | Show warranty upsell option |
| `flavor_cross_sells` | Checkbox | `true` | Show cross-sell products |
| `flavor_cross_sells_count` | Number | `4` | Number of cross-sells (4–8) |

Up to **5 shipping zones**, each with:

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_shipping_zone_{n}_name` | Text | `""` | Zone name (e.g. "Prishtina") |
| `flavor_shipping_zone_{n}_days` | Text | `""` | Delivery estimate (e.g. "1-2 days") |

### 3.5 Cart Settings (`flavor_cart` section)

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_cart_cross_sells` | Checkbox | `true` | Show cross-sells on cart page |
| `flavor_cart_warranty` | Checkbox | `true` | Enable warranty toggle per item |
| `flavor_cart_sticky_checkout` | Checkbox | `true` | Sticky checkout button on mobile |
| `flavor_cart_empty_message` | Text | `"Your cart is currently empty."` | Empty cart message |

### 3.6 Footer (`flavor_footer` section)

**Social URLs:**

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_social_facebook` | URL | `""` | Facebook page URL |
| `flavor_social_twitter` | URL | `""` | Twitter / X profile URL |
| `flavor_social_instagram` | URL | `""` | Instagram profile URL |

**Contact Information:**

| Setting | Type | Default | Description |
|---|---|---|---|
| `flavor_contact_email` | Text | `""` | Customer support email |
| `flavor_contact_phone` | Text | `""` | Phone number |
| `flavor_whatsapp_number` | Text | `""` | WhatsApp number |
| `flavor_viber_number` | Text | `""` | Viber number |
| `flavor_business_email` | Text | `""` | Business/B2B email |
| `flavor_address` | Text | `""` | Physical address |

**Ecosystem Logos** (up to 8):

| Setting | Type | Default |
|---|---|---|
| `flavor_ecosystem_logo_{n}` | Image | `""` |

---

## 4. Homepage Sections

The homepage is rendered by `front-page.php` and loads sections in this order:

### 4.1 Hero Area (`template-parts/homepage/hero-area.php`)

Full-width Swiper slider with up to 5 slides. Includes a **category sidebar** on desktop showing product categories alongside the slider. Each slide supports separate desktop/mobile images and a link URL.

### 4.2 USP Bar (`template-parts/homepage/usp-bar.php`)

Horizontal row of up to 4 "Unique Selling Propositions" (e.g. free shipping, easy returns). Each USP has an SVG icon, title, and subtitle. Toggled via `flavor_usp_enabled`.

### 4.3 Tabbed Products (`template-parts/homepage/tabbed-products.php`)

"Recommended for you" section with category tabs. Products load via AJAX (`flavor_load_products`). Categories configured by comma-separated IDs. Includes a "See All" link.

### 4.4 Promo Banner (`template-parts/homepage/promo-banner.php`)

Full-width promotional image banner with responsive desktop/mobile images and click-through link. Ideal for seasonal campaigns.

### 4.5 Special Offers (`template-parts/homepage/special-offers.php`)

Displays on-sale products with discount percentages and an optional countdown timer. Products fetched via AJAX (`flavor_load_products` with `context=special_offers`). Returns structured JSON data for Alpine.js rendering.

### 4.6 All Products (`template-parts/homepage/all-products.php`)

Latest products grid with a "Load More" button (AJAX via `flavor_load_more_products`). Configurable products-per-page count.

### 4.7 Popular Categories (`template-parts/homepage/popular-categories.php`)

Grid of category cards with images. Manually curated via category IDs or auto-selected from top categories.

### 4.8 Brand Logos (`template-parts/homepage/brand-logos.php`)

Logo carousel/grid of up to 8 brand logos with names and links.

---

## 5. Template Structure

### Root Templates

| File | Purpose |
|---|---|
| `front-page.php` | Homepage — loads all homepage sections |
| `header.php` | Site header (top bar, main header, navigation) |
| `footer.php` | Site footer (columns, ecosystem, copyright) |
| `index.php` | Default fallback template |
| `page.php` | Generic page template |
| `search.php` | Search results page |
| `sidebar.php` | Sidebar template |
| `404.php` | Not found page |
| `page-wishlist.php` | Wishlist page |

### Page Templates (`page-templates/`)

| File | Purpose |
|---|---|
| `template-contact.php` | Contact page |
| `template-faq.php` | FAQ page |
| `template-price-guarantee.php` | Price guarantee page |

### Template Parts — Header (`template-parts/header/`)

| File | Purpose |
|---|---|
| `main-header.php` | Primary header bar (logo, search, icons) |
| `top-bar.php` | Announcement/top bar |
| `mega-menu.php` | Desktop mega menu |
| `mobile-menu.php` | Mobile slide-out menu |
| `search-bar.php` | Search bar with live search |
| `mini-cart.php` | Slide-out mini cart |
| `quick-links.php` | Quick access links |

### Template Parts — Homepage (`template-parts/homepage/`)

| File | Purpose |
|---|---|
| `hero-area.php` | Hero slider + category sidebar |
| `usp-bar.php` | USP icons row |
| `tabbed-products.php` | Tabbed product carousel |
| `promo-banner.php` | Promotional banner |
| `special-offers.php` | On-sale products with countdown |
| `all-products.php` | All products grid with load more |
| `popular-categories.php` | Category cards grid |
| `brand-logos.php` | Brand logo row |

### Template Parts — Product (`template-parts/product/`)

| File | Purpose |
|---|---|
| `product-card.php` | Reusable product card (grid item) |
| `product-card-skeleton.php` | Loading skeleton placeholder |
| `product-gallery.php` | Product image gallery (GLightbox) |
| `product-info.php` | Product details (price, stock, meta) |
| `product-tabs.php` | Description / reviews tabs |
| `buy-now.php` | Buy Now button |
| `installment-display.php` | Installment calculator |
| `warranty-upsell.php` | Warranty add-on option |
| `shipping-estimate.php` | Shipping zone delivery estimates |
| `cross-sells.php` | Cross-sell products section |

### Template Parts — Shop (`template-parts/shop/`)

| File | Purpose |
|---|---|
| `product-grid.php` | Product grid layout |
| `filter-sidebar.php` | Desktop filter sidebar |
| `filter-drawer.php` | Mobile filter drawer |
| `quick-filter-tabs.php` | Quick filter tabs (bestseller, etc.) |
| `sort-dropdown.php` | Sort order dropdown |
| `seo-content.php` | Category SEO content block |

### Template Parts — Footer (`template-parts/footer/`)

| File | Purpose |
|---|---|
| `column-brand.php` | Brand/about column |
| `column-contact.php` | Contact info column |
| `column-account.php` | Account links column |
| `column-faq.php` | FAQ/help column |
| `ecosystem.php` | Ecosystem logos row |

### Template Parts — Global (`template-parts/global/`)

| File | Purpose |
|---|---|
| `bottom-nav.php` | Mobile bottom navigation |
| `breadcrumbs.php` | Breadcrumb navigation |
| `cookie-consent.php` | Cookie consent banner |
| `empty-states.php` | Empty state illustrations |
| `page-skeleton.php` | Full-page loading skeleton |
| `scroll-to-top.php` | Scroll-to-top button |
| `toast-notifications.php` | Toast notification container |

### Includes (`inc/`)

| File | Purpose |
|---|---|
| `theme-setup.php` | Theme supports, image sizes, menus |
| `enqueue.php` | Script and style enqueuing |
| `woocommerce.php` | WooCommerce hooks and overrides |
| `ajax-handlers.php` | All AJAX endpoint handlers |
| `template-tags.php` | Helper template tag functions |
| `widgets.php` | Widget area registrations |
| `customizer/customizer.php` | Customizer loader |

---

## 6. JavaScript Architecture

### Source Files (`assets/js/src/`)

| File | Purpose |
|---|---|
| `app.js` | Main entry point |
| `alpine-components.js` | All Alpine.js components and stores |
| `slider.js` | Swiper.js hero slider initialization |
| `header.js` | Header interactions |
| `cart.js` | Cart page logic |
| `checkout.js` | Checkout enhancements |
| `filters.js` | Shop filter logic |
| `products.js` | Product listing interactions |
| `product-page.js` | Single product page logic |
| `notifications.js` | Toast notification system |

### Alpine.js Components (`alpine-components.js`)

#### `flavorTabbedProducts`
Manages the homepage tabbed products section. Switches between category tabs and loads products via AJAX.

- **Properties:** `activeTab`, `activeCat`, `loading`, `productsHtml`
- **Methods:** `switchTab(slug, cat)`, `loadProducts()`
- **AJAX:** `flavor_load_products`

#### `flavorToasts`
Global toast notification manager.

- **Properties:** `toasts[]`
- **Methods:** `addToast(detail)`, `removeToast(id)`
- Auto-dismisses after 4 seconds

#### `flavorCart`
Cart page interactions — remove items, update quantities, toggle warranty, apply coupons.

- **Properties:** `couponCode`, `couponMessage`, `couponSuccess`, `applying`, `cartEmpty`
- **Methods:** `removeItem(key)`, `updateQty(key, qty)`, `toggleWarranty(key, val)`, `applyCoupon()`

#### `productPage`
Single product page — quantity selector, warranty toggle, add-to-cart with optional checkout redirect.

- **Config:** `productId`, `price`, `regularPrice`, `inStock`, `warrantyPrice`
- **Properties:** `quantity`, `warranty`, `addingToCart`
- **Computed:** `displayPrice` (includes warranty if selected)
- **Methods:** `setQty(val)`, `addToCart(redirect)`

#### `shopPage`
Shop/archive page — grid/list view toggle, filters, sorting, quick-filter tabs.

- **Properties:** `view`, `quickFilter`, `sortBy`, `filterDrawerOpen`, `loading`, `currentPage`, `totalProducts`, `filters{}`
- **Computed:** `activeFilterCount`, `activeFilters` (chip list)
- **Methods:** `clearAllFilters()`, `toggleArrayFilter(key, value)`, `toggleAttributeFilter(taxonomy, value)`, `applyFilters()`

#### `mobileStickyBar`
Shows a sticky add-to-cart bar on mobile when the main CTA scrolls out of view. Uses `IntersectionObserver`.

### Alpine.js Stores

#### `$store.wishlist`
Global wishlist powered by `localStorage`.

- **Properties:** `items[]`
- **Methods:** `has(id)`, `toggle(id)`
- Persists to `localStorage` key `flavor_wishlist`

### Slider (`slider.js`)

Initializes the hero Swiper slider with:
- Loop mode, 5s autoplay
- Pagination (clickable dots)
- Navigation arrows
- Optional thumbnail sync (second Swiper instance `#heroThumbs`)

---

## 7. AJAX Endpoints

All endpoints use `wp_ajax_` / `wp_ajax_nopriv_` hooks. Every request requires `nonce` (from `flavorData.nonce`).

### `flavor_filter_products`

Full product filtering for the shop page.

| Parameter | Type | Description |
|---|---|---|
| `price_min` | float | Minimum price |
| `price_max` | float | Maximum price |
| `brands` | string | Comma-separated brand names |
| `rating` | int | Minimum star rating |
| `in_stock` | string | `"1"` for in-stock only |
| `sort` | string | `default`, `price_asc`, `price_desc`, `popularity`, `rating`, `name_asc` |
| `page` | int | Page number |
| `product_cat` | string | Category slug |

**Response:** `{ success: true, data: { html, total, pagination } }`

### `flavor_quick_filter`

Quick-filter tabs on shop page.

| Parameter | Type | Description |
|---|---|---|
| `tab` | string | `bestseller`, `most-viewed`, or `top-rated` |
| `product_cat` | string | Category slug (optional) |

**Response:** `{ success: true, data: { html } }`

### `flavor_add_to_cart`

Add product to cart with optional warranty.

| Parameter | Type | Description |
|---|---|---|
| `product_id` | int | Product ID |
| `quantity` | int | Quantity |
| `warranty` | string | `"1"` to include warranty |

**Response:** `{ success: true, data: { cart_hash, cart_count, fragments } }`

### `flavor_load_products`

Load products for homepage sections.

| Parameter | Type | Description |
|---|---|---|
| `context` | string | `"tabbed"` or `"special_offers"` |
| `category` | int | Category term ID |
| `per_page` | int | Products to return (max 20) |

**Response (tabbed):** `{ success: true, data: { html } }`
**Response (special_offers):** `{ success: true, data: { products: [{ id, name, url, image, regular_price, sale_price, discount }] } }`

### `flavor_load_more_products`

Infinite scroll / load more for All Products section.

| Parameter | Type | Description |
|---|---|---|
| `page` | int | Page number |
| `per_page` | int | Products per page (max 20) |

**Response:** `{ success: true, data: { html } }`

### `flavor_toggle_wishlist`

Toggle product in user's wishlist.

| Parameter | Type | Description |
|---|---|---|
| `product_id` | int | Product ID |

**Response:** `{ success: true, data: { status: "added" | "removed" | "toggled" } }`

### `flavor_get_wishlist_products`

Get product cards HTML for wishlist page.

| Parameter | Type | Description |
|---|---|---|
| `product_ids` | string | Comma-separated product IDs |

**Response:** `{ success: true, data: { html } }`

### `flavor_live_search`

Live search suggestions (no nonce required).

| Parameter | Type | Description |
|---|---|---|
| `query` | string | Search query (min 2 chars) |

**Response:** `{ success: true, data: [{ id, name, url, price, image }] }`

### `flavor_mini_cart_remove`

Remove item from mini cart.

| Parameter | Type | Description |
|---|---|---|
| `cart_key` | string | Cart item key |

**Response:** `{ success: true, data: { html, total, count } }`

### `flavor_mini_cart_qty`

Update mini cart item quantity.

| Parameter | Type | Description |
|---|---|---|
| `cart_key` | string | Cart item key |
| `quantity` | int | New quantity |

**Response:** `{ success: true, data: { html, total, count } }`

---

## 8. WooCommerce Template Overrides

All files in the `woocommerce/` directory override default WooCommerce templates:

| File | Overrides |
|---|---|
| `archive-product.php` | Product archive / shop page layout |
| `content-product.php` | Single product within loops |
| `single-product.php` | Single product page layout |
| `cart/cart.php` | Cart page |
| `cart/cart-empty.php` | Empty cart state |
| `checkout/form-checkout.php` | Checkout form |
| `checkout/thankyou.php` | Order confirmation page |
| `myaccount/my-account.php` | My Account wrapper |
| `myaccount/dashboard.php` | Account dashboard |
| `myaccount/orders.php` | Order history list |
| `myaccount/form-login.php` | Login / register form |
| `myaccount/form-edit-account.php` | Edit account details |
| `myaccount/form-edit-address.php` | Edit billing/shipping address |
| `myaccount/wishlist.php` | Wishlist tab (custom) |

---

## 9. CSS / Tailwind

### Configuration (`tailwind.config.js`)

**Content paths:** All `.php` files, `assets/js/src/**/*.js`

**Custom breakpoints:**

| Name | Width |
|---|---|
| `sm` | 375px |
| `tablet-sm` | 640px |
| `tablet` | 768px |
| `md` | 810px |
| `lg` | 1024px |
| `xl` | 1280px |
| `xxl` | 1360px |

**Custom colors:**

| Token | Value |
|---|---|
| `primary` | `var(--color-primary, #E15726)` |
| `primary-light` | `var(--color-primary-light, #FCEEE9)` |
| `green` | `#36B37E` |
| `red` | `#E34850` |
| `black-dark` | `#1A1A1A` |
| `black-light` | `#4B4B4B` |
| `blue-100` | `#ECF3FF` |
| `blue-500` | `#4B7DF3` |

Custom gray scale from `50` to `900` with design-specific values.

**Max widths:** `site` (1280px), `site-xxl` (1360px)

**Font:** Inter (with system-ui fallback)

### File Structure

```
assets/css/
├── src/
│   └── main.css          ← Tailwind directives + custom styles
└── dist/                  ← Compiled output
```

### Theming

The primary color uses CSS custom properties, making it configurable without rebuilding:

```css
:root {
  --color-primary: #E15726;
  --color-primary-light: #FCEEE9;
}
```

---

## 10. Adding Content Guide

### How to Add Hero Slides

1. Go to **Appearance → Customize → Homepage → Hero Slider**
2. Upload a **Desktop Image** for Slide 1 (recommended: 1360×500px)
3. Optionally upload a **Mobile Image** (recommended: 375×400px)
4. Set the **Link URL** (e.g. a category or sale page)
5. Add **Alt Text** for accessibility
6. Repeat for up to 5 slides
7. Click **Publish**

### How to Set Up Categories with Images

1. Go to **Products → Categories**
2. Edit a category and upload a **Thumbnail** image
3. To feature categories on the homepage, go to **Customize → Homepage → Popular Categories**
4. Enter category IDs in the **Category IDs** field (comma-separated)
5. Leave empty to auto-select the most popular categories

> **Tip:** Find a category's ID by hovering over it in Products → Categories — the ID appears in the URL.

### How to Configure Special Offers

1. Go to **Products** and edit any product
2. Set a **Sale price** in the Product data → General tab
3. The theme automatically displays on-sale products in the Special Offers section
4. To add a countdown timer, go to **Customize → Homepage → Special Offers**
5. Set the **Countdown End Date** to when the promotion expires

### How to Add Brand Logos

1. Go to **Appearance → Customize → Homepage → Brand Logos**
2. Upload a **Logo** image for Brand 1 (recommended: 200×80px, transparent PNG)
3. Enter the **Brand Name** (used as alt text)
4. Optionally add a **Link** URL (e.g. filtered shop page for that brand)
5. Repeat for up to 8 brands
6. Click **Publish**

### How to Set Up USP Icons

1. Go to **Customize → Homepage → USP Bar**
2. For each USP (up to 4):
   - Enter a **Title** (e.g. "Free Shipping")
   - Enter a **Subtitle** (e.g. "On orders over €50")
   - Paste **inline SVG** markup for the icon
3. Toggle the section on/off with the **Enable USP Bar** checkbox

### How to Configure the Promo Banner

1. Go to **Customize → Homepage → Promo Banner**
2. Upload a **Desktop Image** (1360×240px recommended)
3. Upload a **Mobile Image** for smaller screens
4. Set the **Link URL** for the banner destination
5. Click **Publish**
