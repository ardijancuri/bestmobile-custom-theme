# COORDINATION.md — Flavor Round 1 (Feb 17, 2026)

## Status
The theme is largely functional. AJAX endpoints work, hero slider renders, all homepage sections load.
The remaining issues are polish items, not major breakages.

## Agent Assignments

### Agent 1: Data & Content Cleanup
**Files owned:** (WordPress DB operations only, no PHP file changes)
- Fix category "20" (term_id 21) — rename to something real or delete
- Exclude "Uncategorized" from hero sidebar query
- Add category thumbnail images via WP CLI
- Set sale prices on products so Special Offers looks right
- Verify all AJAX sections render with proper data

### Agent 2: Homepage Polish
**Files owned:**
- `template-parts/homepage/hero-area.php` — exclude Uncategorized from sidebar query
- `template-parts/homepage/popular-categories.php` — exclude Uncategorized
- `template-parts/homepage/all-products.php` — any needed fixes
- `template-parts/homepage/promo-banner.php` — any needed fixes

### Agent 3: Checkout & Product Page Review  
**Files owned:**
- `woocommerce/checkout/` — all files
- `woocommerce/single-product.php`
- `woocommerce/content-product.php`
- Review and fix checkout flow, single product page styling

## Rules
- Do NOT modify files outside your owned list
- Use `wp --path=/var/www/flavor --allow-root` for WP-CLI
- Git: commit to `develop` branch only
- Test changes by curling the page and checking output
