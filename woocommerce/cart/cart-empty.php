<?php
/**
 * Empty Cart
 *
 * @package flavor
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_cart_is_empty' ); ?>

<div class="flex flex-col items-center justify-center py-16 px-4 text-center">
	<!-- Cart Icon -->
	<div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-6">
		<svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
		</svg>
	</div>

	<h2 class="text-xl font-bold text-gray-900 mb-2"><?php esc_html_e( 'Your cart is empty', 'flavor' ); ?></h2>
	<p class="text-gray-500 mb-8 max-w-sm"><?php esc_html_e( 'Looks like you haven\'t added anything to your cart yet. Start shopping to find great deals!', 'flavor' ); ?></p>

	<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"
		class="inline-flex items-center gap-2 bg-[var(--color-primary,#E15726)] text-white font-semibold px-8 py-3.5 rounded-xl hover:opacity-90 transition-opacity">
		<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
		<?php esc_html_e( 'Continue Shopping', 'flavor' ); ?>
	</a>
</div>
