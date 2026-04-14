<?php
/**
 * Wishlist Page (My Account endpoint)
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user_id  = get_current_user_id();
$wishlist = get_user_meta( $user_id, '_flavor_wishlist', true );
$wishlist = is_array( $wishlist ) ? $wishlist : array();
?>

<h2 class="text-lg font-bold text-gray-700 mb-4"><?php esc_html_e( 'My Wishlist', 'flavor' ); ?></h2>

<?php if ( ! empty( $wishlist ) ) : ?>

	<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
		<?php foreach ( $wishlist as $product_id ) :
			$product = wc_get_product( $product_id );
			if ( ! $product ) continue;
		?>
			<div class="border border-gray-200 rounded-xl overflow-hidden group relative">
				<!-- Remove -->
				<button class="wishlist-remove absolute top-2 right-2 z-10 bg-white rounded-full p-1.5 shadow text-gray-400 hover:text-red transition-colors" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php esc_attr_e( 'Remove from wishlist', 'flavor' ); ?>">
					<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
				</button>

				<!-- Image -->
				<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block aspect-square overflow-hidden">
					<?php echo wp_kses_post( $product->get_image( 'flavor-product-card', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ) ) ); ?>
				</a>

				<div class="p-3">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="text-xs font-medium text-gray-700 hover:text-primary line-clamp-2 block mb-1">
						<?php echo esc_html( $product->get_name() ); ?>
					</a>

					<div class="flex items-center justify-between mt-2">
						<span class="text-sm font-bold text-primary"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>

						<?php if ( $product->is_in_stock() ) : ?>
							<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="inline-flex items-center gap-1 bg-primary hover:bg-orange-600 text-white text-xs font-medium px-2.5 py-1.5 rounded-lg transition-colors" data-quantity="1" data-product_id="<?php echo esc_attr( $product_id ); ?>">
								<svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
								<?php esc_html_e( 'Cart', 'flavor' ); ?>
							</a>
						<?php else : ?>
							<span class="text-xs text-red"><?php esc_html_e( 'Out of stock', 'flavor' ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

<?php else : ?>
	<?php
	get_template_part( 'template-parts/global/empty-states', null, array(
		'icon'     => '<svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>',
		'title'    => esc_html__( 'Your wishlist is empty', 'flavor' ),
		'message'  => esc_html__( 'Browse our products and add your favorites to your wishlist.', 'flavor' ),
		'cta_url'  => esc_url( wc_get_page_permalink( 'shop' ) ),
		'cta_text' => esc_html__( 'Browse Products', 'flavor' ),
	) );
	?>
<?php endif; ?>
