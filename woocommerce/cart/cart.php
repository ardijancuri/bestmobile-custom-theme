<?php
/**
 * Cart Page
 *
 * @package suspended flavor
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="flavor-cart max-w-7xl mx-auto px-4 py-8" x-data="flavorCart()">

	<?php if ( WC()->cart->is_empty() ) : ?>
		<?php wc_get_template( 'cart/cart-empty.php' ); ?>
	<?php else : ?>

	<h1 class="text-2xl md:text-3xl font-bold mb-8"><?php esc_html_e( 'Shopping Cart', 'flavor' ); ?></h1>

	<div class="lg:grid lg:grid-cols-3 lg:gap-8">

		<!-- Cart Items -->
		<div class="lg:col-span-2">
			<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_before_cart_table' ); ?>

				<!-- Mobile: Cards / Desktop: Table -->
				<div class="space-y-4">
					<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							$warranty_price    = get_post_meta( $product_id, '_warranty_price', true );
							$has_warranty      = ! empty( $cart_item['warranty_added'] );
					?>
						<div class="bg-white rounded-xl border border-gray-200 p-4 flex flex-col md:flex-row md:items-center gap-4 group"
							 data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>">

							<!-- Thumbnail -->
							<div class="flex-shrink-0 w-20 h-20">
								<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( array( 80, 80 ), array( 'class' => 'w-full h-full object-cover rounded-lg' ) ), $cart_item, $cart_item_key );
								if ( $product_permalink ) {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
								} else {
									echo $thumbnail; // phpcs:ignore
								}
								?>
							</div>

							<!-- Info -->
							<div class="flex-1 min-w-0">
								<div class="flex items-start justify-between">
									<div>
										<h3 class="font-medium text-gray-900 truncate">
											<?php
											if ( $product_permalink ) {
												printf( '<a href="%s" class="hover:text-[var(--color-primary,#E15726)]">%s</a>',
													esc_url( $product_permalink ),
													wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) )
												);
											} else {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) );
											}
											?>
										</h3>
										<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore ?>
									</div>

									<!-- Remove -->
									<button type="button"
										class="text-gray-400 hover:text-red-500 transition-colors ml-2 flex-shrink-0"
										@click="removeItem('<?php echo esc_js( $cart_item_key ); ?>')"
										aria-label="<?php esc_attr_e( 'Remove item', 'flavor' ); ?>">
										<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
									</button>
								</div>

								<!-- Price -->
								<div class="text-sm text-gray-500 mt-1">
									<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore ?>
								</div>

								<!-- Warranty -->
								<?php if ( $warranty_price && floatval( $warranty_price ) > 0 ) : ?>
									<div class="mt-2 flex items-center gap-3 text-sm">
										<span class="text-gray-600">
											<svg class="w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
											<?php esc_html_e( 'Warranty', 'flavor' ); ?> +<?php echo wc_price( $warranty_price ); ?>
										</span>
										<label class="inline-flex items-center gap-1 cursor-pointer">
											<input type="radio" name="warranty_<?php echo esc_attr( $cart_item_key ); ?>" value="yes"
												<?php checked( $has_warranty ); ?>
												@change="toggleWarranty('<?php echo esc_js( $cart_item_key ); ?>', true)"
												class="text-[var(--color-primary,#E15726)] focus:ring-[var(--color-primary,#E15726)]">
											<span><?php esc_html_e( 'Yes', 'flavor' ); ?></span>
										</label>
										<label class="inline-flex items-center gap-1 cursor-pointer">
											<input type="radio" name="warranty_<?php echo esc_attr( $cart_item_key ); ?>" value="no"
												<?php checked( ! $has_warranty ); ?>
												@change="toggleWarranty('<?php echo esc_js( $cart_item_key ); ?>', false)"
												class="text-[var(--color-primary,#E15726)] focus:ring-[var(--color-primary,#E15726)]">
											<span><?php esc_html_e( 'No', 'flavor' ); ?></span>
										</label>
									</div>
								<?php endif; ?>

								<!-- Qty + Subtotal -->
								<div class="flex items-center justify-between mt-3">
									<div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
										<button type="button"
											class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors"
											@click="updateQty('<?php echo esc_js( $cart_item_key ); ?>', <?php echo esc_attr( max( 0, $cart_item['quantity'] - 1 ) ); ?>)">
											<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/></svg>
										</button>
										<input type="number"
											class="w-12 h-8 text-center text-sm border-x border-gray-300 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
											value="<?php echo esc_attr( $cart_item['quantity'] ); ?>"
											min="0"
											@change="updateQty('<?php echo esc_js( $cart_item_key ); ?>', parseInt($el.value))"
											aria-label="<?php esc_attr_e( 'Quantity', 'flavor' ); ?>">
										<button type="button"
											class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors"
											@click="updateQty('<?php echo esc_js( $cart_item_key ); ?>', <?php echo esc_attr( $cart_item['quantity'] + 1 ); ?>)">
											<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
										</button>
									</div>

									<span class="font-semibold text-gray-900">
										<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore ?>
									</span>
								</div>
							</div>
						</div>
					<?php endif; endforeach; ?>
				</div>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>

				<!-- Coupon -->
				<div class="mt-6 flex flex-col sm:flex-row gap-3">
					<div class="flex-1 flex gap-2">
						<input type="text" name="coupon_code" x-model="couponCode"
							class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[var(--color-primary,#E15726)] focus:border-transparent"
							placeholder="<?php esc_attr_e( 'Coupon code', 'flavor' ); ?>">
						<button type="button"
							class="px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors"
							@click="applyCoupon()"
							:disabled="!couponCode || applying"
							:class="{ 'opacity-50 cursor-not-allowed': !couponCode || applying }">
							<span x-show="!applying"><?php esc_html_e( 'Apply', 'flavor' ); ?></span>
							<span x-show="applying" x-cloak><?php esc_html_e( 'Applying…', 'flavor' ); ?></span>
						</button>
					</div>
				</div>

				<!-- Coupon message -->
				<div x-show="couponMessage" x-cloak class="mt-2 text-sm" :class="couponSuccess ? 'text-green-600' : 'text-red-600'" x-text="couponMessage"></div>

			</form>

			<?php do_action( 'woocommerce_after_cart' ); ?>
		</div>

		<!-- Order Summary Sidebar -->
		<div class="mt-8 lg:mt-0">
			<div class="bg-gray-50 rounded-xl p-6 sticky top-24">
				<h2 class="text-lg font-bold mb-4"><?php esc_html_e( 'Order Summary', 'flavor' ); ?></h2>

				<div class="space-y-3 text-sm">
					<div class="flex justify-between">
						<span class="text-gray-600"><?php esc_html_e( 'Subtotal', 'flavor' ); ?></span>
						<span class="font-medium"><?php wc_cart_totals_subtotal_html(); ?></span>
					</div>

					<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
						<div class="flex justify-between text-green-600">
							<span><?php echo esc_html( $code ); ?></span>
							<span>-<?php wc_cart_totals_coupon_html( $coupon ); ?></span>
						</div>
					<?php endforeach; ?>

					<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
						<div class="flex justify-between">
							<span class="text-gray-600"><?php esc_html_e( 'Shipping', 'flavor' ); ?></span>
							<span class="font-medium"><?php wc_cart_totals_shipping_html(); ?></span>
						</div>
					<?php endif; ?>

					<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
						<div class="flex justify-between">
							<span class="text-gray-600"><?php echo esc_html( $fee->name ); ?></span>
							<span class="font-medium"><?php wc_cart_totals_fee_html( $fee ); ?></span>
						</div>
					<?php endforeach; ?>

					<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
						<?php foreach ( WC()->cart->get_tax_totals() as $tax ) : ?>
							<div class="flex justify-between">
								<span class="text-gray-600"><?php echo esc_html( $tax->label ); ?></span>
								<span class="font-medium"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>

					<div class="border-t border-gray-200 pt-3 flex justify-between">
						<span class="text-base font-bold"><?php esc_html_e( 'Total', 'flavor' ); ?></span>
						<span class="text-base font-bold text-[var(--color-primary,#E15726)]"><?php wc_cart_totals_order_total_html(); ?></span>
					</div>
				</div>

				<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
					class="mt-6 w-full block text-center bg-primary text-white font-semibold py-3.5 rounded-xl hover:opacity-90 transition-opacity">
					<?php esc_html_e( 'Proceed to Checkout', 'flavor' ); ?>
				</a>

				<?php do_action( 'woocommerce_after_cart_totals' ); ?>
			</div>
		</div>
	</div>

	<!-- Sticky Mobile Checkout -->
	<div class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 p-4 lg:hidden z-40 safe-area-bottom"
		 x-show="!cartEmpty" x-cloak>
		<div class="flex items-center justify-between mb-2">
			<span class="text-sm text-gray-600"><?php esc_html_e( 'Total', 'flavor' ); ?></span>
			<span class="font-bold text-[var(--color-primary,#E15726)]"><?php wc_cart_totals_order_total_html(); ?></span>
		</div>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
			class="w-full block text-center bg-primary text-white font-semibold py-3.5 rounded-xl hover:opacity-90 transition-opacity">
			<?php esc_html_e( 'Checkout', 'flavor' ); ?>
		</a>
	</div>

	<?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
