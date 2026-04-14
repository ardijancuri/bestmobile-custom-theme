<?php
/**
 * Template Name: Wishlist
 * Wishlist Page — reads product IDs from localStorage and displays them in a grid.
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="container-site py-8">
	<h1 class="text-2xl md:text-3xl font-bold mb-8"><?php esc_html_e( 'My Wishlist', 'flavor' ); ?></h1>

	<div x-data="wishlistPage()" x-cloak>
		<!-- Loading -->
		<div x-show="loading" class="grid grid-cols-2 tablet-sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4">
			<?php for ( $i = 0; $i < 5; $i++ ) : ?>
				<div class="bg-gray-100 rounded-lg animate-pulse h-64"></div>
			<?php endfor; ?>
		</div>

		<!-- Empty -->
		<div x-show="!loading && ids.length === 0" class="text-center py-16">
			<svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
			</svg>
			<p class="text-gray-500 text-lg mb-4"><?php esc_html_e( 'Your wishlist is empty.', 'flavor' ); ?></p>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-block bg-[var(--color-primary,#E15726)] text-white font-semibold px-6 py-3 rounded-xl hover:opacity-90 transition-opacity">
				<?php esc_html_e( 'Browse Products', 'flavor' ); ?>
			</a>
		</div>

		<!-- Products Grid -->
		<div x-show="!loading && ids.length > 0" x-html="productsHtml"
			 class="grid grid-cols-2 tablet-sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4"></div>
	</div>
</main>

<script>
document.addEventListener('alpine:init', () => {
	Alpine.data('wishlistPage', () => ({
		ids: [],
		loading: true,
		productsHtml: '',

		init() {
			try {
				const stored = localStorage.getItem('flavor_wishlist');
				this.ids = stored ? JSON.parse(stored) : [];
			} catch (e) {
				this.ids = [];
			}

			if (this.ids.length === 0) {
				this.loading = false;
				return;
			}

			const fd = new FormData();
			fd.append('action', 'flavor_get_wishlist_products');
			fd.append('nonce', (window.flavorData || {}).nonce || '');
			fd.append('product_ids', this.ids.join(','));

			fetch((window.flavorData || {}).ajaxUrl || '/wp-admin/admin-ajax.php', {
				method: 'POST',
				body: fd,
			})
			.then(r => r.json())
			.then(res => {
				if (res.success) {
					this.productsHtml = res.data.html || '';
				}
				this.loading = false;
			})
			.catch(() => { this.loading = false; });
		},
	}));
});
</script>

<?php
get_footer();
