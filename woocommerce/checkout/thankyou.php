<?php
/**
 * Thank You / Order Confirmation
 *
 * @package flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="max-w-3xl mx-auto px-4 py-12">

	<?php if ( $order ) :
		do_action( 'woocommerce_before_thankyou', $order->get_id() );
	?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>
			<div class="text-center mb-8">
				<div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
					<svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
				</div>
				<h1 class="text-2xl font-bold text-gray-900 mb-2"><?php esc_html_e( 'Payment Failed', 'flavor' ); ?></h1>
				<p class="text-gray-500 mb-6"><?php esc_html_e( 'Unfortunately your order cannot be processed. Please try again.', 'flavor' ); ?></p>
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
					class="inline-block bg-[var(--color-primary,#E15726)] text-white font-semibold px-8 py-3 rounded-xl hover:opacity-90 transition-opacity">
					<?php esc_html_e( 'Pay Now', 'flavor' ); ?>
				</a>
			</div>

		<?php else : ?>
			<!-- Success -->
			<div class="text-center mb-10">
				<div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
					<svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
				</div>
				<h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2"><?php esc_html_e( 'Thank you for your order!', 'flavor' ); ?></h1>
				<p class="text-gray-500"><?php esc_html_e( 'Your order has been received and is being processed.', 'flavor' ); ?></p>
			</div>

			<!-- Order Details Grid -->
			<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
				<div class="bg-gray-50 rounded-xl p-4 text-center">
					<span class="block text-xs text-gray-500 uppercase tracking-wide mb-1"><?php esc_html_e( 'Order Number', 'flavor' ); ?></span>
					<span class="font-bold text-gray-900">#<?php echo esc_html( $order->get_order_number() ); ?></span>
				</div>
				<div class="bg-gray-50 rounded-xl p-4 text-center">
					<span class="block text-xs text-gray-500 uppercase tracking-wide mb-1"><?php esc_html_e( 'Date', 'flavor' ); ?></span>
					<span class="font-bold text-gray-900"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
				</div>
				<div class="bg-gray-50 rounded-xl p-4 text-center">
					<span class="block text-xs text-gray-500 uppercase tracking-wide mb-1"><?php esc_html_e( 'Total', 'flavor' ); ?></span>
					<span class="font-bold text-[var(--color-primary,#E15726)]"><?php echo $order->get_formatted_order_total(); // phpcs:ignore ?></span>
				</div>
				<div class="bg-gray-50 rounded-xl p-4 text-center">
					<span class="block text-xs text-gray-500 uppercase tracking-wide mb-1"><?php esc_html_e( 'Payment', 'flavor' ); ?></span>
					<span class="font-bold text-gray-900"><?php echo esc_html( $order->get_payment_method_title() ); ?></span>
				</div>
			</div>

			<!-- Order Items -->
			<div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-8">
				<div class="px-6 py-4 border-b border-gray-200">
					<h2 class="font-bold"><?php esc_html_e( 'Order Items', 'flavor' ); ?></h2>
				</div>
				<div class="divide-y divide-gray-100">
					<?php foreach ( $order->get_items() as $item_id => $item ) :
						$product = $item->get_product();
					?>
						<div class="flex items-center gap-4 px-6 py-4">
							<div class="w-14 h-14 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
								<?php echo $product ? $product->get_image( array( 56, 56 ), array( 'class' => 'w-full h-full object-cover' ) ) : ''; // phpcs:ignore ?>
							</div>
							<div class="flex-1 min-w-0">
								<p class="font-medium text-sm truncate"><?php echo esc_html( $item->get_name() ); ?></p>
								<p class="text-xs text-gray-500"><?php esc_html_e( 'Qty:', 'flavor' ); ?> <?php echo absint( $item->get_quantity() ); ?></p>
							</div>
							<span class="font-medium text-sm"><?php echo $order->get_formatted_line_subtotal( $item ); // phpcs:ignore ?></span>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Totals -->
				<div class="bg-gray-50 px-6 py-4 space-y-2 text-sm">
					<div class="flex justify-between">
						<span class="text-gray-600"><?php esc_html_e( 'Subtotal', 'flavor' ); ?></span>
						<span><?php echo wc_price( $order->get_subtotal() ); // phpcs:ignore ?></span>
					</div>
					<?php if ( $order->get_shipping_total() > 0 ) : ?>
						<div class="flex justify-between">
							<span class="text-gray-600"><?php esc_html_e( 'Shipping', 'flavor' ); ?></span>
							<span><?php echo wc_price( $order->get_shipping_total() ); // phpcs:ignore ?></span>
						</div>
					<?php endif; ?>
					<?php if ( $order->get_total_discount() > 0 ) : ?>
						<div class="flex justify-between text-green-600">
							<span><?php esc_html_e( 'Discount', 'flavor' ); ?></span>
							<span>-<?php echo wc_price( $order->get_total_discount() ); // phpcs:ignore ?></span>
						</div>
					<?php endif; ?>
					<div class="flex justify-between border-t border-gray-200 pt-2 font-bold text-base">
						<span><?php esc_html_e( 'Total', 'flavor' ); ?></span>
						<span class="text-[var(--color-primary,#E15726)]"><?php echo $order->get_formatted_order_total(); // phpcs:ignore ?></span>
					</div>
				</div>
			</div>

			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

			<div class="text-center">
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
					class="inline-flex items-center gap-2 text-[var(--color-primary,#E15726)] font-semibold hover:underline">
					<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
					<?php esc_html_e( 'Continue Shopping', 'flavor' ); ?>
				</a>
			</div>
		<?php endif; ?>

	<?php else : ?>
		<div class="text-center py-12">
			<p class="text-gray-500"><?php esc_html_e( 'Invalid order.', 'flavor' ); ?></p>
		</div>
	<?php endif; ?>
</div>
