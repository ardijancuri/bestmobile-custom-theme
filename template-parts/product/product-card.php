<?php
/**
 * Product card partial - used in grids and carousels
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$product_id = $product->get_id();
$permalink  = $product->get_permalink();
$image_id   = $product->get_image_id();
$price_html = flavor_price_html_with_small_decimals( $product->get_price_html() );

if ( $product->is_type( 'variable' ) ) {
	$regular_price = (float) $product->get_variation_regular_price( 'min', false );
	$sale_price    = $product->is_on_sale() ? (float) $product->get_variation_sale_price( 'min', false ) : 0;
} else {
	$regular_price = (float) $product->get_regular_price();
	$sale_price    = $product->is_on_sale() ? (float) $product->get_sale_price() : 0;
}
$discount_pct  = ( $regular_price && $sale_price ) ? round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) : 0;
$rating        = $product->get_average_rating();
$review_count  = $product->get_review_count();
$brand_terms   = wp_get_post_terms( $product_id, 'pa_brand' );
$brand_name    = ( ! is_wp_error( $brand_terms ) && ! empty( $brand_terms ) ) ? $brand_terms[0]->name : '';
$stock_status  = $product->get_stock_status();
?>

<div class="group bg-white rounded-lg border border-gray-300/60 hover:shadow-md transition-shadow overflow-hidden flex flex-col" data-product-id="<?php echo absint( $product_id ); ?>">
	<!-- Image -->
	<a href="<?php echo esc_url( $permalink ); ?>" class="relative block aspect-square overflow-hidden bg-gray-50">
		<?php if ( $image_id ) : ?>
			<?php echo wp_get_attachment_image( $image_id, 'flavor-product-card', false, array(
				'class'   => 'w-full h-full object-contain group-hover:scale-105 transition-transform duration-300',
				'loading' => 'lazy',
			) ); ?>
		<?php else : ?>
			<div class="w-full h-full flex items-center justify-center text-gray-500">
				<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
			</div>
		<?php endif; ?>

		<?php if ( $discount_pct > 0 || 'outofstock' === $stock_status ) : ?>
			<div class="absolute top-2 left-2 z-10 flex max-w-[calc(100%-3.5rem)] flex-col items-start gap-1">
				<?php if ( $discount_pct > 0 ) : ?>
					<span class="bg-red text-white text-xs font-bold px-1.5 py-0.5 rounded">
						-<?php echo absint( $discount_pct ); ?>%
					</span>
				<?php endif; ?>

				<?php if ( 'outofstock' === $stock_status ) : ?>
					<span class="bg-gray-700 text-white text-xs px-1.5 py-0.5 rounded">
						<?php esc_html_e( 'Out of stock', 'flavor' ); ?>
					</span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<!-- Wishlist button -->
		<button
			@click.prevent.stop="$store.wishlist.toggle(<?php echo absint( $product_id ); ?>)"
			class="absolute top-2 right-2 z-10 p-1.5 bg-white/80 rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:text-red"
			:class="$store.wishlist.has(<?php echo absint( $product_id ); ?>) && '!opacity-100 text-red'"
			aria-label="<?php esc_attr_e( 'Toggle wishlist', 'flavor' ); ?>"
		>
			<svg class="w-4 h-4" :fill="$store.wishlist.has(<?php echo absint( $product_id ); ?>) ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
		</button>
	</a>

	<!-- Info -->
	<div class="p-2 md:p-3 flex flex-col flex-1">
		<?php if ( $brand_name ) : ?>
			<span class="text-xs text-gray-500 mb-0.5"><?php echo esc_html( $brand_name ); ?></span>
		<?php endif; ?>

		<a href="<?php echo esc_url( $permalink ); ?>" class="text-sm font-medium text-gray-700 line-clamp-2 hover:text-primary transition-colors mb-auto">
			<?php echo esc_html( $product->get_name() ); ?>
		</a>

		<?php if ( $rating > 0 ) : ?>
		<div class="flex items-center gap-1 mt-1.5">
			<div class="flex items-center">
				<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
					<svg class="w-3 h-3 <?php echo $i <= round( $rating ) ? 'text-yellow-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
				<?php endfor; ?>
			</div>
			<span class="text-xs text-gray-500">(<?php echo absint( $review_count ); ?>)</span>
		</div>
		<?php endif; ?>

		<!-- Price -->
		<?php if ( $price_html ) : ?>
			<div class="product-card-price mt-2 text-base font-bold text-gray-700">
				<?php echo wp_kses_post( $price_html ); ?>
			</div>
		<?php endif; ?>

		<!-- Product CTA -->
		<?php if ( $product->is_purchasable() && $product->is_in_stock() && $product->is_type( 'simple' ) ) : ?>
		<button
			@click.prevent="
				const btn = $el;
				btn.disabled = true;
				btn.textContent = '<?php esc_attr_e( 'Adding…', 'flavor' ); ?>';
				const fd = new FormData();
				fd.append('action', 'flavor_add_to_cart');
				fd.append('nonce', (window.flavorData || {}).nonce || '');
				fd.append('product_id', <?php echo absint( $product_id ); ?>);
				fd.append('quantity', 1);
				fetch((window.flavorData || {}).ajaxUrl || '/wp-admin/admin-ajax.php', { method: 'POST', body: fd })
					.then(r => r.json())
					.then(res => {
						btn.disabled = false;
						btn.textContent = '<?php esc_attr_e( 'Add to Cart', 'flavor' ); ?>';
						if (res.success) {
							if (window.flavorApplyMiniCart && res.data && res.data.mini_cart) {
								window.flavorApplyMiniCart(res.data.mini_cart);
							} else if (window.flavorRefreshMiniCart) {
								window.flavorRefreshMiniCart();
							}
							window.dispatchEvent(new CustomEvent('open-mini-cart'));
						} else {
							window.dispatchEvent(new CustomEvent('toast', { detail: { message: res.data?.message || 'Error', type: 'error' } }));
						}
					}).catch(() => { btn.disabled = false; btn.textContent = '<?php esc_attr_e( 'Add to Cart', 'flavor' ); ?>'; });
			"
			class="mt-2 w-full py-1.5 text-xs font-medium border border-primary text-primary rounded hover:bg-primary hover:text-white transition-colors"
		>
			<?php esc_html_e( 'Add to Cart', 'flavor' ); ?>
		</button>
		<?php elseif ( $product->is_type( 'variable' ) ) : ?>
		<a
			href="<?php echo esc_url( $permalink ); ?>"
			class="mt-2 block w-full rounded border border-primary py-1.5 text-center text-xs font-medium text-primary transition-colors hover:bg-primary hover:text-white"
		>
			<?php esc_html_e( 'Read More', 'flavor' ); ?>
		</a>
		<?php endif; ?>
	</div>
</div>
