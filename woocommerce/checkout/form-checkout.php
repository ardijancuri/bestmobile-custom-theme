<?php
/**
 * Checkout Form — One-Page Accordion
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'flavor' ) ) );
	return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout max-w-6xl mx-auto px-4 py-8 sm:py-12"
	  action="<?php echo esc_url( wc_get_checkout_url() ); ?>"
	  enctype="multipart/form-data"
	  x-data="checkoutAccordion()">

	<h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8"><?php esc_html_e( 'Checkout', 'flavor' ); ?></h1>

	<div class="lg:grid lg:grid-cols-12 lg:gap-10">

		<!-- Left Column: Steps -->
		<div class="lg:col-span-7 xl:col-span-8 space-y-4">

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<!-- ═══ Step 1: Billing Details ═══ -->
			<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-shadow hover:shadow-md">
				<button type="button"
					class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none focus:ring-2 focus:ring-primary focus:ring-inset"
					@click="toggle(1)"
					:aria-expanded="step === 1">
					<div class="flex items-center gap-4">
						<span class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
							  :class="completed.includes(1) ? 'bg-green-500 text-white' : (step >= 1 ? 'bg-primary text-white' : 'bg-gray-100 text-gray-500')">
							<template x-if="completed.includes(1)">
								<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
							</template>
							<template x-if="!completed.includes(1)">
								<span>1</span>
							</template>
						</span>
						<div>
							<span class="font-semibold text-gray-900"><?php esc_html_e( 'Billing Details', 'flavor' ); ?></span>
							<p class="text-xs text-gray-500 mt-0.5" x-show="step !== 1 && completed.includes(1)"><?php esc_html_e( 'Completed', 'flavor' ); ?></p>
						</div>
					</div>
					<svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="step === 1 && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
				</button>

				<div x-show="step === 1" x-collapse x-cloak class="px-6 pb-6 border-t border-gray-100">
					<div class="pt-5">
						<?php if ( is_user_logged_in() ) :
							$customer   = WC()->customer;
							$saved_addr = $customer->get_billing_address_1();
							if ( $saved_addr ) : ?>
								<div class="mb-5 p-4 border-2 rounded-xl cursor-pointer transition-colors"
									 :class="useSavedAddress ? 'border-primary bg-orange-50' : 'border-gray-200 hover:border-gray-300'"
									 @click="useSavedAddress = true">
									<div class="flex items-center gap-2 mb-1">
										<svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
										<span class="text-sm font-medium text-primary"><?php esc_html_e( 'Saved Address', 'flavor' ); ?></span>
									</div>
									<p class="text-sm text-gray-700 leading-relaxed">
										<?php echo esc_html( $customer->get_billing_first_name() . ' ' . $customer->get_billing_last_name() ); ?><br>
										<?php echo esc_html( $saved_addr ); ?><br>
										<?php echo esc_html( $customer->get_billing_postcode() . ' ' . $customer->get_billing_city() ); ?>
									</p>
								</div>
								<button type="button" class="text-sm text-primary font-medium mb-4 hover:underline"
									@click="useSavedAddress = false">
									<?php esc_html_e( '+ Use a different address', 'flavor' ); ?>
								</button>
							<?php endif; ?>
						<?php endif; ?>

						<div x-show="!useSavedAddress || <?php echo is_user_logged_in() ? 'false' : 'true'; ?>">
							<div id="customer_details">
								<div class="woocommerce-billing-fields">
									<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

									<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
										<?php
										$fields = $checkout->get_checkout_fields( 'billing' );
										foreach ( $fields as $key => $field ) {
											$field['class']       = array( 'col-span-1' );
											$field['input_class'] = array( 'w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors' );
											$field['label_class'] = array( 'block text-sm font-medium text-gray-700 mb-1.5' );

											if ( in_array( $key, array( 'billing_address_1', 'billing_email' ), true ) ) {
												$field['class'] = array( 'sm:col-span-2' );
											}

											woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
										}
										?>
									</div>

									<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
								</div>

								<!-- Business Invoice Toggle -->
								<div class="mt-5" x-data="{ business: false }">
									<label class="inline-flex items-center gap-2.5 cursor-pointer">
										<input type="checkbox" x-model="business" class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
										<span class="text-sm font-medium text-gray-700"><?php esc_html_e( 'I need a business invoice', 'flavor' ); ?></span>
									</label>
									<div x-show="business" x-collapse x-cloak class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
										<div>
											<label class="block text-sm font-medium text-gray-700 mb-1.5"><?php esc_html_e( 'Company Name', 'flavor' ); ?></label>
											<input type="text" name="billing_company" class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors">
										</div>
										<div>
											<label class="block text-sm font-medium text-gray-700 mb-1.5"><?php esc_html_e( 'VAT Number', 'flavor' ); ?></label>
											<input type="text" name="billing_vat" class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors">
										</div>
									</div>
								</div>
							</div>
						</div>

						<button type="button"
							class="mt-6 inline-flex items-center gap-2 bg-primary text-white font-semibold px-8 py-3 rounded-xl hover:opacity-90 transition-opacity text-sm"
							@click="if(validateStep(1)){markComplete(1); step = 2}">
							<?php esc_html_e( 'Continue to Shipping', 'flavor' ); ?>
							<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
						</button>
					</div>
				</div>
			</div>

			<!-- ═══ Step 2: Shipping ═══ -->
			<?php if ( WC()->cart->needs_shipping() ) : ?>
			<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-shadow hover:shadow-md">
				<button type="button"
					class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none focus:ring-2 focus:ring-primary focus:ring-inset"
					@click="toggle(2)"
					:aria-expanded="step === 2">
					<div class="flex items-center gap-4">
						<span class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
							  :class="completed.includes(2) ? 'bg-green-500 text-white' : (step >= 2 ? 'bg-primary text-white' : 'bg-gray-100 text-gray-500')">
							<template x-if="completed.includes(2)">
								<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
							</template>
							<template x-if="!completed.includes(2)">
								<span>2</span>
							</template>
						</span>
						<div>
							<span class="font-semibold text-gray-900"><?php esc_html_e( 'Shipping', 'flavor' ); ?></span>
							<p class="text-xs text-gray-500 mt-0.5" x-show="step !== 2 && completed.includes(2)"><?php esc_html_e( 'Completed', 'flavor' ); ?></p>
						</div>
					</div>
					<svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="step === 2 && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
				</button>

				<div x-show="step === 2" x-collapse x-cloak class="px-6 pb-6 border-t border-gray-100">
					<div class="pt-5">
						<label class="inline-flex items-center gap-2.5 cursor-pointer mb-4">
							<input type="checkbox" name="ship_to_different_address" value="1"
								x-model="shipDifferent"
								class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
							<span class="text-sm font-medium text-gray-700"><?php esc_html_e( 'Ship to a different address?', 'flavor' ); ?></span>
						</label>

						<div x-show="shipDifferent" x-collapse x-cloak class="mt-3">
							<div class="woocommerce-shipping-fields">
								<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>
								<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
									<?php
									$shipping_fields = $checkout->get_checkout_fields( 'shipping' );
									foreach ( $shipping_fields as $key => $field ) {
										$field['input_class'] = array( 'w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors' );
										$field['label_class'] = array( 'block text-sm font-medium text-gray-700 mb-1.5' );
										woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
									}
									?>
								</div>
								<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
							</div>
						</div>

						<!-- Shipping Methods -->
						<div class="mt-4">
							<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
							<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
								<?php wc_cart_totals_shipping_html(); ?>
							<?php endif; ?>
							<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
						</div>

						<button type="button"
							class="mt-6 inline-flex items-center gap-2 bg-primary text-white font-semibold px-8 py-3 rounded-xl hover:opacity-90 transition-opacity text-sm"
							@click="markComplete(2); step = 3">
							<?php esc_html_e( 'Continue to Payment', 'flavor' ); ?>
							<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
						</button>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<!-- ═══ Step 3: Payment ═══ -->
			<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-shadow hover:shadow-md">
				<button type="button"
					class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none focus:ring-2 focus:ring-primary focus:ring-inset"
					@click="toggle(<?php echo WC()->cart->needs_shipping() ? 3 : 2; ?>)"
					:aria-expanded="step === <?php echo WC()->cart->needs_shipping() ? 3 : 2; ?>">
					<div class="flex items-center gap-4">
						<span class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
							  :class="completed.includes(<?php echo WC()->cart->needs_shipping() ? 3 : 2; ?>) ? 'bg-green-500 text-white' : (step >= <?php echo WC()->cart->needs_shipping() ? 3 : 2; ?> ? 'bg-primary text-white' : 'bg-gray-100 text-gray-500')">
							<template x-if="completed.includes(<?php echo WC()->cart->needs_shipping() ? 3 : 2; ?>)">
								<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
							</template>
							<template x-if="!completed.includes(<?php echo WC()->cart->needs_shipping() ? 3 : 2; ?>)">
								<span><?php echo WC()->cart->needs_shipping() ? '3' : '2'; ?></span>
							</template>
						</span>
						<div>
							<span class="font-semibold text-gray-900"><?php esc_html_e( 'Payment Method', 'flavor' ); ?></span>
							<p class="text-xs text-gray-500 mt-0.5" x-show="step !== <?php echo WC()->cart->needs_shipping() ? 3 : 2; ?> && completed.includes(<?php echo WC()->cart->needs_shipping() ? 3 : 2; ?>)"><?php esc_html_e( 'Completed', 'flavor' ); ?></p>
						</div>
					</div>
					<svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="step === <?php echo WC()->cart->needs_shipping() ? 3 : 2; ?> && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
				</button>

				<div x-show="step === <?php echo WC()->cart->needs_shipping() ? 3 : 2; ?>" x-collapse x-cloak class="px-6 pb-6 border-t border-gray-100">
					<div class="pt-5">
						<div id="payment" class="woocommerce-checkout-payment">
							<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

							<ul class="wc_payment_methods payment_methods methods space-y-3 list-none p-0 m-0">
								<?php
								$available_gateways = WC()->payment_gateways->get_available_payment_gateways();
								if ( $available_gateways ) :
									foreach ( $available_gateways as $gateway ) :
								?>
									<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
										<label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all"
											:class="paymentMethod === '<?php echo esc_js( $gateway->id ); ?>' ? 'border-primary bg-orange-50 shadow-sm' : 'border-gray-200 hover:border-gray-300'">
											<input type="radio" name="payment_method"
												value="<?php echo esc_attr( $gateway->id ); ?>"
												<?php checked( $gateway->chosen, true ); ?>
												x-model="paymentMethod"
												class="text-primary focus:ring-primary w-4 h-4"
												id="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
											<?php if ( $gateway->icon ) : ?>
												<span class="flex-shrink-0"><?php echo $gateway->icon; // phpcs:ignore ?></span>
											<?php endif; ?>
											<span class="font-medium text-sm text-gray-900"><?php echo esc_html( $gateway->get_title() ); ?></span>
										</label>
										<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
											<div x-show="paymentMethod === '<?php echo esc_js( $gateway->id ); ?>'" x-collapse x-cloak
												class="mt-3 ml-7 p-4 bg-gray-50 rounded-lg text-sm text-gray-600 payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>">
												<?php $gateway->payment_fields(); ?>
											</div>
										<?php endif; ?>
									</li>
								<?php endforeach; endif; ?>
							</ul>

							<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
						</div>

						<button type="button"
							class="mt-6 inline-flex items-center gap-2 bg-primary text-white font-semibold px-8 py-3 rounded-xl hover:opacity-90 transition-opacity text-sm"
							@click="markComplete(<?php echo WC()->cart->needs_shipping() ? 3 : 2; ?>); step = <?php echo WC()->cart->needs_shipping() ? 4 : 3; ?>">
							<?php esc_html_e( 'Review Order', 'flavor' ); ?>
							<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
						</button>
					</div>
				</div>
			</div>

			<!-- ═══ Step 4: Review & Place Order ═══ -->
			<?php $final_step = WC()->cart->needs_shipping() ? 4 : 3; ?>
			<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-shadow hover:shadow-md">
				<button type="button"
					class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none focus:ring-2 focus:ring-primary focus:ring-inset"
					@click="toggle(<?php echo $final_step; ?>)"
					:aria-expanded="step === <?php echo $final_step; ?>">
					<div class="flex items-center gap-4">
						<span class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
							  :class="step >= <?php echo $final_step; ?> ? 'bg-primary text-white' : 'bg-gray-100 text-gray-500'">
							<?php echo $final_step; ?>
						</span>
						<span class="font-semibold text-gray-900"><?php esc_html_e( 'Review & Place Order', 'flavor' ); ?></span>
					</div>
					<svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="step === <?php echo $final_step; ?> && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
				</button>

				<div x-show="step === <?php echo $final_step; ?>" x-collapse x-cloak class="px-6 pb-6 border-t border-gray-100">
					<div class="pt-5">
						<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

						<!-- Cart Items -->
						<div class="divide-y divide-gray-100 mb-6">
							<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
								$_product = $cart_item['data'];
							?>
								<div class="flex items-center gap-4 py-4">
									<div class="w-14 h-14 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
										<?php echo $_product->get_image( array( 56, 56 ), array( 'class' => 'w-full h-full object-cover' ) ); // phpcs:ignore ?>
									</div>
									<div class="flex-1 min-w-0">
										<p class="text-sm font-medium text-gray-900 truncate"><?php echo esc_html( $_product->get_name() ); ?></p>
										<p class="text-xs text-gray-500 mt-0.5"><?php esc_html_e( 'Qty:', 'flavor' ); ?> <?php echo absint( $cart_item['quantity'] ); ?></p>
									</div>
									<span class="text-sm font-semibold text-gray-900"><?php echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); // phpcs:ignore ?></span>
								</div>
							<?php endforeach; ?>
						</div>

						<!-- Order Notes -->
						<div class="mb-5">
							<label for="order_comments" class="block text-sm font-medium text-gray-700 mb-1.5"><?php esc_html_e( 'Order notes (optional)', 'flavor' ); ?></label>
							<textarea name="order_comments" id="order_comments" rows="3"
								class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors"
								placeholder="<?php esc_attr_e( 'Notes about your order, e.g. special delivery instructions.', 'flavor' ); ?>"><?php echo esc_textarea( $checkout->get_value( 'order_comments' ) ); ?></textarea>
						</div>

						<!-- Promo Code -->
						<div class="mb-5" x-data="{ showPromo: false }">
							<button type="button" @click="showPromo = !showPromo" class="text-sm text-primary font-medium hover:underline inline-flex items-center gap-1">
								<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
								<?php esc_html_e( 'Have a promo code?', 'flavor' ); ?>
							</button>
							<div x-show="showPromo" x-collapse x-cloak class="mt-3 flex gap-2">
								<input type="text" name="coupon_code_checkout"
									class="flex-1 rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors"
									placeholder="<?php esc_attr_e( 'Enter code', 'flavor' ); ?>">
								<button type="button" class="px-5 py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-colors">
									<?php esc_html_e( 'Apply', 'flavor' ); ?>
								</button>
							</div>
						</div>

						<!-- Terms -->
						<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

						<div class="woocommerce-terms-and-conditions-wrapper mb-5">
							<?php wc_get_template( 'checkout/terms.php' ); ?>
						</div>

						<?php echo wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>

						<button type="submit"
							class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:opacity-90 transition-all text-base shadow-lg shadow-primary/25"
							name="woocommerce_checkout_place_order" id="place_order"
							value="<?php esc_attr_e( 'Place Order', 'flavor' ); ?>"
							:disabled="placing" :class="{ 'opacity-50 cursor-not-allowed': placing }">
							<span x-show="!placing" class="inline-flex items-center gap-2">
								<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
								<?php esc_html_e( 'Place Order', 'flavor' ); ?>
							</span>
							<span x-show="placing" x-cloak class="inline-flex items-center gap-2">
								<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
								<?php esc_html_e( 'Processing…', 'flavor' ); ?>
							</span>
						</button>

						<!-- Security Badge -->
						<div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400">
							<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
							<?php esc_html_e( 'Secure checkout — your data is encrypted', 'flavor' ); ?>
						</div>

						<?php do_action( 'woocommerce_review_order_after_submit' ); ?>
					</div>
				</div>
			</div>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		</div>

		<!-- ═══ Order Summary Sidebar ═══ -->
		<div class="mt-8 lg:mt-0 lg:col-span-5 xl:col-span-4">
			<!-- Mobile: Collapsible -->
			<div class="lg:hidden mb-4" x-data="{ showSummary: false }">
				<button type="button" @click="showSummary = !showSummary"
					class="w-full flex items-center justify-between bg-gray-50 border border-gray-200 rounded-xl px-5 py-4">
					<span class="font-semibold text-gray-900 inline-flex items-center gap-2">
						<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
						<?php esc_html_e( 'Order Summary', 'flavor' ); ?>
					</span>
					<svg class="w-5 h-5 text-gray-400 transition-transform" :class="showSummary && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
				</button>
				<div x-show="showSummary" x-collapse x-cloak class="mt-2 bg-white rounded-xl border border-gray-200 p-5">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>
			</div>

			<!-- Desktop: Sticky sidebar -->
			<div class="hidden lg:block">
				<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sticky top-24">
					<h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
						<svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
						<?php esc_html_e( 'Order Summary', 'flavor' ); ?>
					</h2>
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>
			</div>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
