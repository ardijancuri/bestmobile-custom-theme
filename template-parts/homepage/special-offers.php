<?php
/**
 * Special offers - featured slider + offer list.
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enabled = get_theme_mod( 'flavor_special_offers_enabled', true );
if ( ! $enabled ) {
	return;
}

$title         = get_theme_mod( 'flavor_special_offers_title', __( 'Special Offers', 'flavor' ) );
$countdown_end = get_theme_mod( 'flavor_special_offers_countdown', '' );
$used_ids      = flavor_homepage_get_used_product_ids();

$special_offer_query_args = array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'posts_per_page'      => 6,
	'ignore_sticky_posts' => true,
	'orderby'             => 'rand',
	'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		array(
			'key'   => '_flavor_show_in_special_offers',
			'value' => 'yes',
		),
	),
);

if ( ! empty( $used_ids ) ) {
	$special_offer_query_args['post__not_in'] = $used_ids;
}

$special_offer_query = new WP_Query( $special_offer_query_args );
$initial_products    = array();

if ( $special_offer_query->have_posts() ) {
	while ( $special_offer_query->have_posts() ) {
		$special_offer_query->the_post();
		$product_data = flavor_prepare_special_offer_product_data( wc_get_product( get_the_ID() ) );

		if ( $product_data ) {
			$initial_products[] = $product_data;
		}
	}
}

wp_reset_postdata();

if ( empty( $initial_products ) ) {
	return;
}

$special_offers_payload = wp_json_encode(
	array(
		'initialProducts' => $initial_products,
		'sectionKey'      => 'homepage-special-offers',
	)
);

flavor_homepage_add_used_product_ids( wp_list_pluck( $initial_products, 'id' ) );
?>

<section class="my-6"
		 x-data="flavorSpecialOffers(<?php echo esc_attr( $special_offers_payload ); ?>)"
		 @mouseenter="pauseSlider()"
		 @mouseleave="startSlider()"
		 aria-label="<?php echo esc_attr( $title ); ?>">

	<div class="flex items-center justify-between mb-4">
		<h2 class="text-lg font-bold text-gray-700"><?php echo esc_html( $title ); ?></h2>
		<?php if ( $countdown_end ) : ?>
			<div class="flex items-center gap-1 text-sm" x-show="timeLeft.total > 0">
				<svg class="w-4 h-4 text-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
				</svg>
				<span class="bg-red text-white text-xs font-bold px-1.5 py-0.5 rounded" x-text="timeLeft.days + 'd'"></span>
				<span class="bg-red text-white text-xs font-bold px-1.5 py-0.5 rounded" x-text="timeLeft.hours + 'h'"></span>
				<span class="bg-red text-white text-xs font-bold px-1.5 py-0.5 rounded" x-text="timeLeft.minutes + 'm'"></span>
				<span class="bg-red text-white text-xs font-bold px-1.5 py-0.5 rounded" x-text="timeLeft.seconds + 's'"></span>
			</div>
		<?php endif; ?>
	</div>

	<div class="special-offers-layout flex flex-col lg:flex-row gap-4">
		<div class="special-offers-featured-column w-full lg:w-1/2">
			<template x-if="loading">
				<div class="special-offers-featured-card bg-white rounded-lg border border-gray-300 p-4 animate-pulse">
					<div class="special-offers-featured-media bg-gray-100 rounded-lg mb-4"></div>
					<div class="bg-gray-200 rounded h-6 w-3/4 mx-auto mb-3"></div>
					<div class="bg-gray-200 rounded h-8 w-40 mx-auto mb-6"></div>
					<div class="bg-gray-200 rounded-full h-10 w-40 mx-auto"></div>
				</div>
			</template>

			<template x-if="!loading && featured">
				<div class="special-offers-featured-card bg-white rounded-lg border border-gray-300 p-4 flex flex-col">
					<div class="special-offers-featured-media relative flex items-center justify-center">
						<template x-if="featured.discount">
							<span class="absolute top-3 left-3 bg-red text-white text-xs font-bold px-2 py-0.5 rounded-full" x-text="'-' + featured.discount + '%'"></span>
						</template>

						<template x-if="products.length > 1">
							<span class="absolute top-3 right-3 bg-gray-700 text-white text-xs font-semibold px-2.5 py-1 rounded-full" x-text="(activeIndex + 1) + '/' + products.length"></span>
						</template>

						<template x-if="products.length > 1">
							<button type="button"
									class="absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors"
									@click.prevent="prevSlide()"
									aria-label="<?php esc_attr_e( 'Previous offer', 'flavor' ); ?>">
								<svg class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
									<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
								</svg>
							</button>
						</template>

						<a :href="featured.url" class="flex items-center justify-center w-full h-full px-12">
							<img :src="featured.image"
								 :alt="featured.name"
								 class="special-offers-featured-image"
								 loading="lazy">
						</a>

						<template x-if="products.length > 1">
							<button type="button"
									class="absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors"
									@click.prevent="nextSlide()"
									aria-label="<?php esc_attr_e( 'Next offer', 'flavor' ); ?>">
								<svg class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
									<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
								</svg>
							</button>
						</template>
					</div>

					<div class="mt-4 text-center">
						<h3 class="text-xl font-medium text-gray-900 leading-tight mb-3">
							<a :href="featured.url" x-text="featured.name" class="hover:text-primary transition-colors"></a>
						</h3>

						<div class="flex items-center justify-center gap-3 mb-6 flex-wrap">
							<template x-if="featured.has_sale">
								<span class="text-sm text-gray-500 line-through" x-html="featured.regular_price_label"></span>
							</template>
							<span class="text-2xl font-bold text-gray-900" x-html="featured.price_label"></span>
						</div>

						<button type="button"
								class="inline-flex items-center justify-center border border-gray-700 rounded-full px-6 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-900 hover:text-white disabled:opacity-60 disabled:cursor-not-allowed"
								@click="addFeaturedToCart()"
								:disabled="addingToCart">
							<span x-text="addingToCart ? '<?php echo esc_js( __( 'Adding...', 'flavor' ) ); ?>' : '<?php echo esc_js( __( 'Add to Cart', 'flavor' ) ); ?>'"></span>
						</button>
					</div>
				</div>
			</template>
		</div>

		<div class="special-offers-list-column w-full lg:w-1/2">
			<div class="special-offers-list-card bg-white rounded-lg border border-gray-300 overflow-hidden">
				<template x-if="loading">
					<div>
						<template x-for="n in 6" :key="'special-offer-skeleton-' + n">
							<div class="flex items-center gap-3 px-3 py-4 border-b border-gray-200 last:border-b-0 animate-pulse">
								<div class="bg-gray-200 rounded w-16 h-16 flex-shrink-0"></div>
								<div class="flex-1 min-w-0">
									<div class="bg-gray-200 rounded h-4 w-4/5 mb-2"></div>
									<div class="bg-gray-200 rounded h-6 w-1/3"></div>
								</div>
							</div>
						</template>
					</div>
				</template>

				<template x-if="!loading && deals.length">
					<div class="special-offers-list-scroll">
						<template x-for="(deal, index) in deals" :key="deal.id">
							<button type="button"
									class="block w-full text-left border-b border-gray-200 last:border-b-0 transition-colors"
									:style="activeIndex === index ? 'border-left: 3px solid var(--color-primary, #E15726); background-color: var(--color-primary-light, #FCEEE9);' : 'border-left: 3px solid transparent;'"
									@click="setActive(index); restartSlider();">
								<div class="flex items-center gap-3 px-3 py-4">
									<img :src="deal.image"
										 :alt="deal.name"
										 class="w-16 h-16 object-contain flex-shrink-0"
										 loading="lazy">
									<div class="min-w-0 flex-1">
										<p class="text-base text-gray-900 leading-snug mb-1" x-text="deal.name"></p>
										<div class="text-xl font-bold text-gray-900" x-html="deal.price_label"></div>
									</div>
								</div>
							</button>
						</template>
					</div>
				</template>
			</div>
		</div>
	</div>
</section>

<script>
function flavorSpecialOffers(opts = {}) {
	const endDate = '<?php echo esc_js( $countdown_end ); ?>';
	const initialProducts = Array.isArray(opts.initialProducts) ? opts.initialProducts : [];
	const sectionKey = opts.sectionKey || 'homepage-special-offers';

	return {
		loading: initialProducts.length === 0,
		products: initialProducts,
		featured: initialProducts[0] || null,
		deals: initialProducts,
		sectionKey: sectionKey,
		activeIndex: 0,
		addingToCart: false,
		timeLeft: { total: 0, days: 0, hours: 0, minutes: 0, seconds: 0 },
		interval: null,
		sliderInterval: null,

		init() {
			if (this.products.length) {
				this.loading = false;
				this.setActive(0);
				this.syncSectionProducts();
				this.startSlider();
			} else {
				this.loadDeals();
			}

			if (endDate) {
				this.updateCountdown();
				this.interval = setInterval(() => this.updateCountdown(), 1000);
			}
		},

		destroy() {
			if (this.interval) {
				clearInterval(this.interval);
			}

			if (this.sliderInterval) {
				clearInterval(this.sliderInterval);
			}
		},

		updateCountdown() {
			const diff = new Date(endDate).getTime() - Date.now();

			if (diff <= 0) {
				this.timeLeft = { total: 0, days: 0, hours: 0, minutes: 0, seconds: 0 };

				if (this.interval) {
					clearInterval(this.interval);
				}

				return;
			}

			this.timeLeft = {
				total: diff,
				days: Math.floor(diff / 86400000),
				hours: Math.floor((diff % 86400000) / 3600000),
				minutes: Math.floor((diff % 3600000) / 60000),
				seconds: Math.floor((diff % 60000) / 1000),
			};
		},

		setActive(index) {
			if (!this.products.length) {
				return;
			}

			const total = this.products.length;
			this.activeIndex = (index + total) % total;
			this.featured = this.products[this.activeIndex];
			this.deals = this.products;
		},

		syncSectionProducts() {
			if (!window.Alpine || typeof window.Alpine.store !== 'function') {
				return;
			}

			const homepageStore = window.Alpine.store('homepageProducts');
			if (!homepageStore || typeof homepageStore.setSection !== 'function') {
				return;
			}

			homepageStore.setSection(this.sectionKey, this.products.map((product) => Number(product.id) || 0));
		},

		nextSlide() {
			this.setActive(this.activeIndex + 1);
			this.restartSlider();
		},

		prevSlide() {
			this.setActive(this.activeIndex - 1);
			this.restartSlider();
		},

		pauseSlider() {
			if (this.sliderInterval) {
				clearInterval(this.sliderInterval);
				this.sliderInterval = null;
			}
		},

		startSlider() {
			this.pauseSlider();

			if (this.products.length < 2) {
				return;
			}

			this.sliderInterval = setInterval(() => {
				this.setActive(this.activeIndex + 1);
			}, 5000);
		},

		restartSlider() {
			this.startSlider();
		},

		addFeaturedToCart() {
			if (!this.featured) {
				return;
			}

			if (!this.featured.can_add_direct) {
				window.location.href = this.featured.url;
				return;
			}

			if (this.addingToCart) {
				return;
			}

			this.addingToCart = true;

			const data = new FormData();
			data.append('action', 'flavor_add_to_cart');
			data.append('nonce', (window.flavorData || {}).nonce || '');
			data.append('product_id', this.featured.id);
			data.append('quantity', 1);

			fetch((window.flavorData || {}).ajaxUrl || '/wp-admin/admin-ajax.php', {
				method: 'POST',
				body: data,
			})
				.then((response) => response.json())
				.then((res) => {
					this.addingToCart = false;

					if (!res.success) {
						window.dispatchEvent(new CustomEvent('toast', {
							detail: {
								message: (res.data && res.data.message) || 'Error',
								type: 'error',
							},
						}));
						return;
					}

					if (window.flavorApplyMiniCart && res.data && res.data.mini_cart) {
						window.flavorApplyMiniCart(res.data.mini_cart);
					} else if (window.flavorRefreshMiniCart) {
						window.flavorRefreshMiniCart();
					}
					window.dispatchEvent(new CustomEvent('open-mini-cart'));
				})
				.catch(() => {
					this.addingToCart = false;
				});
		},

		loadDeals() {
			this.loading = true;

			const data = new FormData();
			data.append('action', 'flavor_load_products');
			data.append('nonce', flavorData.nonce);
			data.append('context', 'special_offers');
			data.append('per_page', 6);
			if (window.Alpine && typeof window.Alpine.store === 'function') {
				const homepageStore = window.Alpine.store('homepageProducts');
				if (homepageStore && typeof homepageStore.getIds === 'function') {
					data.append('exclude_ids', homepageStore.getIds(this.sectionKey).join(','));
				}
			}

			fetch(flavorData.ajaxUrl, { method: 'POST', body: data })
				.then((response) => response.json())
				.then((res) => {
					if (res.success && res.data.products) {
						this.products = res.data.products.slice(0, 6);
						this.deals = this.products;
						this.setActive(0);
						this.syncSectionProducts();
						this.startSlider();
					}

					this.loading = false;
				})
				.catch(() => {
					this.loading = false;
				});
		},
	};
}
</script>
