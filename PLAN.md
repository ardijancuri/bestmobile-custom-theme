# Flavor — Custom WooCommerce E-Commerce Theme
## Reference: gjirafa50.com (v3 FINAL — All agent reviews incorporated)

---

## 🎯 Project Overview
Build a **modern, flexible WordPress/WooCommerce custom theme** that replicates the UI/UX of gjirafa50.com. The theme should be **generic** (not hardcoded to one brand), fully editable via WordPress Customizer, and ready for any e-commerce niche.

**Theme Name:** Flavor
**Stack:** WordPress 6.x + WooCommerce 8.x + Tailwind CSS + Alpine.js
**Font:** Inter (Google Fonts)
**Primary Color:** #E15726 (orange) — configurable via Customizer
**Color Palette (from reference CSS):**
- Primary: #E15726
- Primary light bg: #FCEEE9
- Gray-50: #F9FAFB
- Gray-300: #E2E2E2
- Gray-500: #CACACA
- Gray-600: #6E6E6E
- Gray-700: #2C2C2C
- Green: #36B37E
- Red: #E34850
- Black-light: #4B4B4B
- Blue-100: #ECF3FF
- Blue-500: #4B7DF3

**Max-width containers:** 1280px (xl) / 1360px (xxl)

---

## 📐 Complete Site Structure (gjirafa50.com)

### Homepage Layout (top to bottom):
1. Announcement bar (promo text + megaphone icon, dark bg)
2. Header (dark bg, logo left, search center, wishlist/cart/user/chat right)
3. Quick links bar (Outlet, What's New, Gift Card, Apple Official + Categories button)
4. **Hero area** = Category sidebar (left, desktop only) + Banner slider with thumbnail strip (right)
5. USP trust badges bar (4 badges, dismissable, cookie-persisted)
6. Recommended products (tabbed grid with category filter tabs, AJAX loaded)
7. Promotional banner (single, full-width, ~1360×240)
8. Special offers spotlight (featured deal with countdown + side deal list)
9. All products grid (infinite scroll with "Load More" button)
10. Popular categories (large CTA cards with product images)
11. Brand logos strip (6 logos, scrollable)
12. Footer (4-column dark, collapsible on mobile)

### Category/Shop Page:
- Breadcrumbs (custom, home icon, schema.org)
- Quick-filter tabs (Best sellers / Most viewed / Top rated / All)
- Toolbar (Filter button + Sort dropdown)
- Filter drawer (slide-in, AJAX)
- Product grid (infinite scroll)
- SEO content + FAQ accordion at bottom

### Product Detail Page:
- International supplier notice (conditional)
- Image carousel (Swiper, counter "1/10", lightbox)
- Product info: title, warranty badge, brand, SKU
- Price block: original/sale/discount/savings/VAT
- Installment payment calculator
- Stock quantity indicator (range-based)
- Protection plan / warranty upsell toggle
- Shipping estimation by region
- Payment methods icons
- Add to cart + wishlist + "Buy Now"
- Tabs: Description, Specifications, Reviews
- Cross-sells carousel ("Also bought")

### Cart:
- Product table with AJAX quantity +/-
- Warranty add-on per item (radio buttons)
- Coupon/promo code input
- Order summary sidebar
- Empty cart state
- Flyout mini-cart from header
- Sticky mobile checkout button

### Checkout (One-Page Accordion):
- Collapsible step sections (address → payment → confirm)
- Saved address selection cards
- 7+ payment method groups (hierarchical UI)
- Order comment/notes (collapsible)
- Business invoicing fields (company + fiscal number)
- Gift card / promo code application

### Account:
- Dashboard, Orders, Wishlist, Addresses, Account Details
- Store credit system
- Login/Register

### Other:
- Search (AJAX live + results page)
- FAQ (categorized, anchor links)
- Contact page
- Terms, Privacy, Price Guarantee
- 404 page

---

## 🏗️ Development Plan — 8 Phases

### Phase 1: Theme Scaffolding & Build System
```
flavor/
├── assets/
│   ├── css/src/main.css → dist/style.css
│   ├── js/src/ (app, header, slider, filters, products, product-page, cart, checkout, notifications)
│   ├── images/
│   └── fonts/
├── inc/
│   ├── customizer/ (customizer, header, homepage, shop, product, cart, footer)
│   ├── enqueue.php
│   ├── theme-setup.php
│   ├── widgets.php
│   ├── woocommerce.php
│   ├── ajax-handlers.php
│   └── template-tags.php
├── template-parts/
│   ├── header/ (top-bar, main-header, mega-menu, mobile-menu, mini-cart, search-bar, quick-links)
│   ├── footer/ (footer-columns, footer-bottom, footer-social, ecosystem-strip)
│   ├── homepage/ (hero-area, category-sidebar, slider, slider-thumbs, usp-bar, tabbed-products, promo-banner, special-offers, all-products, popular-categories, brand-logos)
│   ├── product/ (product-card, product-card-skeleton, product-gallery, product-info, product-tabs, installment-display, warranty-upsell, shipping-estimate, cross-sells, buy-now)
│   ├── shop/ (filter-drawer, quick-filter-tabs, sort-dropdown, product-grid, seo-content)
│   └── global/ (cookie-consent, toast-notifications, scroll-to-top, breadcrumbs, empty-states)
├── woocommerce/ (archive-product, single-product, content-product, cart/, checkout/, myaccount/)
├── page-templates/ (template-faq, template-contact, template-price-guarantee)
├── functions.php, front-page.php, header.php, footer.php, index.php, search.php, 404.php
├── style.css, screenshot.png
├── tailwind.config.js, postcss.config.js, package.json
```

**Tasks:**
- Theme boilerplate with WooCommerce support
- Tailwind build (PostCSS, purge) with custom breakpoints: `tablet-sm` (640px), `tablet` (768px), `md` (810px), `lg` (1024px), `xl` (1280px), `xxl` (1360px)
- Alpine.js, Swiper.js, GLightbox dependencies
- Register nav menus: primary, mega-menu, quick-links, mobile, footer x4
- Custom image sizes for cards, banners, categories
- AJAX endpoint registration
- Inter font enqueue from Google Fonts

---

### Phase 2: Header, Navigation & Global Elements

**2a. Announcement Bar:**
- Dark gray bg (#2C2C2C), white text, text-xs
- Megaphone icon + editable promo text
- Dismissable (cookie-based)
- Centered on tablet+, left on mobile
- Customizer: on/off, text, bg color, link

**2b. Main Header:**
- Dark/black bg, white text, sticky on md+ (`sticky top-0 z-30`)
- Max-width container 1280/1360px centered
- **Left:** Logo (SVG, 110×32px configurable)
- **Center:** Search bar (md:w-1/2, absolute bottom on mobile, relative on desktop)
  - AJAX live search dropdown (product image + name + price suggestions)
  - Placeholder: "Search products" (editable)
- **Right icons:** Wishlist (heart + badge count), Cart (icon + badge count + flyout mini-cart), User (icon + "Login" text on md+), Chat (icon + notification badge)
- **Mini-cart flyout:** White dropdown with product list, qty +/-, remove, totals, checkout link
- **Mobile:** Header 110px tall, stacked layout (icons top, search bottom)
- **On scroll:** `header-scrolled` class on body (for subtle CSS adjustments)

**2c. Quick Links Bar:**
- White bg, below header
- Left: "Categories" button (hamburger + text, triggers mega menu/sidebar)
- Links: Outlet, What's New, Gift Card (with icon), Apple Official (with logo image)
- Right: Chat button
- Desktop only for full layout; condensed on mobile

**2d. Homepage Category Sidebar:**
- Left of hero slider, ~280px wide, desktop only (hidden on mobile)
- Vertical list: custom icon + category name + chevron arrow per item
- Hover → mega menu flyout to the right (overlaps slider area)
- Min-height matches slider (~338px)

**2e. Mega Menu Flyout:**
- 4-column grid: 3 cols subcategories + 1 col promo image
- Each column: bold parent subcategory heading + child links + "Show more"
- Hover-triggered with delay
- Full-width overlay within container
- Promo image column only on xl+

**2f. Mobile Menu:**
- Full-screen slide-in drawer from left
- Nested accordion categories with icons
- Search bar at top, close button
- Quick links included

**2g. Bottom Navigation Bar (mobile):**
- `#header-menu-mobile` — fixed bottom, 4-5 icons (Home, Categories, Cart w/badge, Account)
- Dynamic stacking with other sticky elements (cookie bar, product CTA, checkout CTA)
- Body gets extra `pb-24` to account for bar
- Active below 768px/810px breakpoint

**2h. Global Elements:**
- **Cookie consent bar:** Bottom-positioned, "Close" button, above bottom nav on mobile
- **Toast notification system:** `displayBarNotification(message, type, duration)` — success/warning/error types, positioned top or bottom, auto-dismiss
- **Dialog modals:** For confirmations, warnings
- **Scroll-to-top button:** Fixed bottom-right, primary color bg, chevron-up icon, shows after scroll threshold
- **Cart badge animation:** `.animate-flip` on count change

**Customizer:** Top bar on/off/text/color, logo, sticky on/off, search placeholder, bottom nav on/off, chat widget slot

---

### Phase 3: Homepage

**3a. Hero Area (Sidebar + Slider):**
- Desktop: sidebar (~280px) + slider (remaining)
- Mobile: slider only (full-width)
- **Slider:** Swiper.js, autoplay, prev/next arrows, pagination dots
  - Responsive images: `<picture>` with `<source>` at 600px
  - First slide `fetchpriority=high`, rest lazy-loaded
  - Aspect ~3.5:1, max-height ~340px
- **Thumbnail strip** below slider: mini slide previews, active highlight, scrollable
- Customizer: slide manager (desktop img, mobile img, link), autoplay speed

**3b. USP Trust Badges:**
- 4 badges in row (md:grid-cols-4), scrollable on mobile
- Each: icon + title (sm, medium) + subtitle (xs)
- White bg, shadow, rounded, divide-x between
- Dismissable X button (sessionStorage persisted)
- Appears on homepage AND category pages
- Customizer: 4 slots (icon, title, subtitle), on/off

**3c. Recommended Products (Tabbed Grid):**
- Horizontal scrollable category tabs with bottom-border active highlight
- First tab: "For you" (default/personalized)
- Product grid: 2 cols (mobile) → 3 → 4 → 5 (xl)
- AJAX load with 10 skeleton card placeholders
- "See all" link → category page
- Customizer: on/off, title, product count, tab categories

**3d. Promotional Banner:**
- Single full-width (1360×240 desktop), rounded, shadow-sm
- Responsive srcset at 600px breakpoint
- Linked URL
- Customizer: desktop img, mobile img, link, on/off

**3e. Special Offers Spotlight:**
- Split: Featured deal (w-2/5 desktop) + Deal list (w-3/5)
- **Featured deal:** Countdown timer (d/h/m/s), large product image (200-240px), name, original+sale price, discount badge, CTA button
- **Deal list (right):** 6 items, each: thumbnail (64px) + name + price + discount badge
- AJAX loaded with skeleton states
- Mobile: stacked (featured top, list below)
- Customizer: on/off, title, product source (sale/category/manual), countdown end time

**3f. All Products Grid (Infinite Scroll):**
- Grid: 2/3/4/5 cols responsive
- Initial 10 products, "Show More" button loads next batch
- "End of results" message
- Skeleton placeholders during load
- Customizer: on/off, initial count, per-load count

**3g. Popular Categories:**
- Large cards: category name + "Buy now" CTA + product image
- First card wider (3 cols), rest 2 cols on lg
- bg-gray-100, rounded, flex (text left + image right)
- Images 140-180px
- Customizer: on/off, category selection (3-6)

**3h. Brand Logos:**
- Horizontal row, white bg, border, rounded, h-16
- Logos: 100×40px, object-contain, hover:shadow-md
- Scrollable on mobile
- Customizer: logo repeater (image + link), on/off

**Product Card Component (shared):**
- Image (hover: 2nd image swap if exists)
- Discount badge: top-left, red/orange pill, "-X%"
- Wishlist heart: top-right, toggleable
- Name: 2 lines, truncated
- Price: original (strikethrough, gray) + sale (bold, larger)
- Currency: after price (€), configurable
- Card: white bg, md:border, hover:shadow-md, rounded, p-2 md:p-3
- **Skeleton version:** matching dimensions, animated pulse

---

### Phase 4: Shop/Category Page

**4a. Breadcrumbs:**
- Custom component (NOT WooCommerce native)
- Home icon (`icon-home`) → chevron → parent → chevron → current (bold)
- text-xs text-gray-700
- Schema.org BreadcrumbList structured data
- Truncated width on mobile

**4b. Quick-Filter Tabs:**
- Row above grid: "All products" (default) | "Best sellers" | "Most viewed" | "Top rated"
- Horizontal scrollable, bottom-border highlight on active
- AJAX loads products per tab

**4c. Toolbar:**
- Left: "Filter" button (opens drawer) + active filter count badge
- Right: Sort dropdown
- Sort options: Relevance (default), Price low→high, Price high→low, Newest, Highest discount %

**4d. Filter Drawer (slide-in from left):**
- Overlay backdrop, close X button
- Collapsible accordion filter groups:
  - Price range slider (min/max inputs)
  - Brand checkboxes (with in-list search)
  - Dynamic product attributes per category
  - Rating filter (stars)
  - Stock status
- Sticky "Apply Filters" button at bottom
- "Clear All" link
- Active filters as removable chips above grid
- Full AJAX filtering (no reload)

**4e. Product Grid:**
- Same card component, 2/3/4/5 cols
- Infinite scroll + "Load More" button
- "End of results" message
- Result count: "X products found"
- Skeleton loading during AJAX

**4f. SEO Content Block (bottom):**
- Rich text from category description
- FAQ accordion (collapsible Q&A pairs)
- Only on initial load

---

### Phase 5: Product Detail Page

**5a. International Supplier Notice (conditional):**
- Top banner: shipping notice for international items
- Configurable via product meta

**5b. Product Gallery (left ~50%):**
- Swiper.js carousel, slide counter "1 / N"
- Prev/next arrows, pagination dots
- Click → GLightbox fullscreen gallery
- Mobile: full-width, swipeable
- 10+ images support, lazy loaded

**5c. Product Info (right ~50%):**
- Title (h1), warranty badge, brand (linked), SKU
- **Price block:**
  - Original price (strikethrough, gray)
  - Sale price (large, bold)
  - Discount badge (-X%)
  - Savings: "You save X €"
  - "VAT included" + price without VAT
- **Installment calculator:**
  - Monthly payment for 24/36 months
  - Partner logo configurable
  - Expandable details
- **Stock:** Quantity range ("More than 10 items" / "In stock" / "Out of stock")
- **Protection plan:** Yes/No toggle, +X € price, per product meta
- **Shipping estimation:** Delivery dates by zone/region, region selector
- **Payment methods:** Icons (cash, online, bank transfer)
- **Add to Cart:** Qty +/- buttons, large CTA button
- **Buy Now button:** Direct checkout, bypasses cart
- **Wishlist button:** Heart icon toggle
- **Mobile:** Sticky bottom bar (price + Add to Cart)

**5d. Product Tabs:**
- Description | Specifications | Reviews (3 tabs only)
- **Specs:** Key-value table, alternating rows, 50+ rows possible
- **Reviews:** Rating overview, star breakdown, individual reviews, write review form
- Mobile: accordion instead of tabs

**5e. Cross-sells:**
- "Customers who bought this also bought"
- Swiper.js carousel, same product card
- 4-5 visible, swipeable

---

### Phase 6: Cart & Checkout

**6a. Cart Page:**
- Table: thumbnail (80px) + name + unit price + qty (+/- AJAX) + subtotal + remove (X)
- **Warranty add-on per item:** Radio buttons (Yes/No) for extended protection
- Coupon code + promo code / gift card input
- Order summary sidebar: subtotal, shipping, total
- Cross-sells section below
- **Empty cart state:** Cart icon + message + "Continue Shopping" CTA
- Sticky mobile checkout button (shows on scroll)

**6b. Flyout Mini-Cart:**
- Triggered from header cart icon
- Slide-out panel with full AJAX controls
- Product list: image + name + qty +/- + remove
- Totals + "View Cart" + "Checkout" buttons

**6c. Checkout (One-Page Accordion - OPC):**
- Collapsible step sections with `.active` / `.allow` states:
  - **Step 1: Shipping/Billing Address**
    - Saved address cards (`.address-grid`) for logged-in users
    - New address form
    - Business invoicing toggle (company name + fiscal number)
  - **Step 2: Payment Method**
    - Hierarchical UI: payment groups → methods → details
    - Payment info loads dynamically per selection
    - Support for: Cash on delivery, Bank transfer, Online card, Installment plans
  - **Step 3: Order Review + Confirm**
- Order comment/notes (collapsible textarea)
- Gift card / promo code application
- Form validation (inline errors)
- Steps have rounded borders, 12px border-radius, 8px gap

**6d. "Buy Now" Quick Checkout:**
- Separate 3-step flow for guest/quick purchase
- Bypasses cart entirely
- Simplified form

---

### Phase 7: Account, Search & Static Pages

**7a. Account:**
- Sidebar nav: Dashboard, Orders, Addresses, Account Details, Wishlist, Logout
- **Dashboard:** Welcome, recent orders, quick links
- **Orders:** Table (order #, date, status, total, "View")
- **Order detail:** Full info, items, tracking
- **Addresses:** Billing + Shipping, edit forms, saved address cards
- **Wishlist:** Product grid, remove, add-to-cart from wishlist
- **Login/Register:** Split layout (login left, register right), tabbed on mobile
- Store credit display (from returns)

**7b. Search:**
- **AJAX live search:** Header dropdown with product image + name + price suggestions
- **Results page:** Same layout as category (breadcrumbs, sort, filter drawer, infinite scroll)
- Result count: "X products found for 'query'"
- "No results" state with suggestions

**7c. FAQ Page (template):**
- 5 categorized sections with anchor links
- Q&A format: bold question headings + paragraph answers
- Category nav at top: About, Payments, Technical, Shipping, Orders

**7d. Contact Page (template):**
- Contact form (name, email, subject, message)
- Contact sidebar: phone, email, WhatsApp, Viber, social links, address
- Operating hours display

**7e. Static Pages:**
- Terms & Conditions, Privacy Policy, Price Guarantee
- Clean typography template

**7f. 404 Page:**
- Error message + search bar + popular categories + "Go Home" CTA

---

### Phase 8: Mobile, Performance & Polish

**8a. Mobile Specifics:**
- Bottom nav bar (fixed, 4 icons, dynamic stacking with other sticky elements)
- Mobile menu drawer (full-screen, accordion categories)
- Sticky add-to-cart bar on product page
- Sticky checkout button on cart page
- Touch-friendly filter drawer
- Swipeable carousels
- 2-col product grid on mobile
- Responsive images with 600px srcset breakpoint
- Body `pb-24` for bottom nav

**8b. Breakpoints (Tailwind config):**
```
screens: {
  'sm': '375px',
  'tablet-sm': '640px',
  'tablet': '768px',
  'md': '810px',
  'lg': '1024px',
  'xl': '1280px',
  'xxl': '1360px',
}
```

**8c. Performance:**
- Lazy load all images below fold
- First hero slide: `fetchpriority=high`
- Tailwind compiled + purged, critical CSS inline
- JS minified + deferred for non-critical
- Skeleton loading states everywhere (matching card dimensions, animated pulse)
- Inter font preloaded
- WooCommerce AJAX add-to-cart
- WebP with fallbacks

**8d. SEO & Accessibility:**
- Schema.org structured data (Product, BreadcrumbList, Organization)
- Proper heading hierarchy
- Alt text, ARIA labels, keyboard nav, focus management
- OpenGraph + Twitter Card meta

**8e. Theme Quality:**
- i18n ready (.pot file)
- RTL support (Tailwind RTL plugin)
- Child theme compatible (hooks & filters)
- Customizer live preview
- WordPress Coding Standards
- Escape output, sanitize input
- All colors configurable via Customizer

---

## 🔧 Technical Stack

| Component | Choice |
|---|---|
| CSS | Tailwind CSS 3.x (compiled, purged) |
| JS Reactivity | Alpine.js 3.x |
| Slider | Swiper.js 11.x |
| Lightbox | GLightbox |
| Icons | Heroicons SVG (swappable) |
| Font | Inter (Google Fonts) |
| AJAX | WP REST API + fetch() |
| Build | PostCSS + Tailwind CLI + terser + cssnano |

---

## 👥 Sub-Agent Work Distribution

| Agent | Phases | Key Deliverables |
|---|---|---|
| **Agent 1** | 1 + 2 | Scaffolding, build system, header, nav, mega menu, mobile menu, bottom nav, global elements (cookie, toast, scroll-top) |
| **Agent 2** | 3 | Homepage — all sections, product card + skeleton, hero area, tabbed products, special offers, infinite scroll |
| **Agent 3** | 4 + 5 | Shop page, filter drawer, breadcrumbs, product detail, gallery, tabs, installments, warranty upsell |
| **Agent 4** | 6 + 7 | Cart, mini-cart, OPC checkout, buy-now flow, account pages, search, FAQ, static pages, empty states |
| **Main (Trunks)** | 8 + QA | Customizer, mobile polish, performance, SEO, integration, Git, coordination |

---

## 📁 Repository
- **Name:** `flavor-theme`
- **Branches:** `main` (protected) → `develop` → feature branches
- **GitHub:** `ardijancuri/flavor-theme`

---

## ✅ Definition of Done
- [ ] Pixel-accurate to gjirafa50.com reference UI/UX
- [ ] All WooCommerce pages functional
- [ ] Fully responsive mobile-first
- [ ] Customizer for all sections/colors/content
- [ ] AJAX product loading with skeletons
- [ ] Filter drawer (slide-in, not sidebar)
- [ ] Infinite scroll + load more
- [ ] One-page accordion checkout
- [ ] Product card component reused everywhere
- [ ] Toast notification system
- [ ] Cookie consent bar
- [ ] Bottom nav bar (mobile)
- [ ] Sticky CTAs (add-to-cart, checkout)
- [ ] Clean, documented, WP-standards code
- [ ] 90+ Lighthouse target
- [ ] i18n + RTL ready
- [ ] Child theme compatible
- [ ] Zero page builder dependency
