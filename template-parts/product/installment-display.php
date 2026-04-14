<?php
/**
 * Installment display — monthly payment calculator
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$price   = (float) $product->get_price();
$partner = get_post_meta( $product->get_id(), '_installment_partner', true );

if ( $price <= 0 ) {
	return;
}

$monthly_24 = round( $price / 24, 2 );
$monthly_36 = round( $price / 36, 2 );
?>

<div class="border border-gray-200 rounded-lg p-4 mt-4" x-data="{ open: false }">
	<button @click="open = !open" class="flex items-center justify-between w-full text-left">
		<div class="flex items-center gap-2">
			<svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
			<span class="text-sm font-medium text-gray-900">
				<?php printf( esc_html__( 'From %s / month', 'flavor' ), wc_price( $monthly_36 ) ); ?>
			</span>
		</div>
		<svg class="w-4 h-4 text-gray-400 transition-transform" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
	</button>

	<div x-show="open" x-collapse class="mt-3 space-y-3 text-sm">
		<div class="grid grid-cols-2 gap-3">
			<div class="border border-gray-200 rounded-lg p-3 text-center">
				<p class="text-xs text-gray-500 mb-1"><?php esc_html_e( '24 months', 'flavor' ); ?></p>
				<p class="text-lg font-bold text-gray-900"><?php echo wc_price( $monthly_24 ); ?></p>
				<p class="text-xs text-gray-400"><?php esc_html_e( '/ month', 'flavor' ); ?></p>
			</div>
			<div class="border border-gray-200 rounded-lg p-3 text-center">
				<p class="text-xs text-gray-500 mb-1"><?php esc_html_e( '36 months', 'flavor' ); ?></p>
				<p class="text-lg font-bold text-gray-900"><?php echo wc_price( $monthly_36 ); ?></p>
				<p class="text-xs text-gray-400"><?php esc_html_e( '/ month', 'flavor' ); ?></p>
			</div>
		</div>

		<?php if ( $partner ) : ?>
			<p class="text-xs text-gray-400"><?php echo esc_html( $partner ); ?></p>
		<?php endif; ?>

		<p class="text-xs text-gray-400"><?php esc_html_e( '0% interest. No additional fees. Subject to credit approval.', 'flavor' ); ?></p>
	</div>
</div>
