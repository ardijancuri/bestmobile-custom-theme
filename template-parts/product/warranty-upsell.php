<?php
/**
 * Warranty upsell — Yes/No radio cards
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$warranty_price = (float) get_post_meta( $product->get_id(), '_flavor_warranty_price', true );

if ( $warranty_price <= 0 ) {
	return;
}
?>

<div class="mt-4" x-data>
	<p class="text-sm font-medium text-gray-900 mb-2 flex items-center gap-1.5">
		<svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
		<?php esc_html_e( 'Extended Warranty', 'flavor' ); ?>
	</p>

	<div class="grid grid-cols-2 gap-3">
		<!-- Yes -->
		<label
			class="relative flex items-center gap-2 border rounded-lg p-3 cursor-pointer transition-colors text-sm"
			:class="warranty ? 'border-primary bg-primary/5' : 'border-gray-200 hover:border-gray-300'"
		>
			<input type="radio" name="warranty" :checked="warranty" @change="warranty = true" class="sr-only">
			<span class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="warranty ? 'border-primary' : 'border-gray-300'">
				<span x-show="warranty" class="w-2 h-2 rounded-full bg-primary"></span>
			</span>
			<div>
				<span class="font-medium text-gray-900"><?php esc_html_e( 'Yes', 'flavor' ); ?></span>
				<span class="text-gray-500 ml-1">+<?php echo wc_price( $warranty_price ); ?></span>
			</div>
		</label>

		<!-- No -->
		<label
			class="relative flex items-center gap-2 border rounded-lg p-3 cursor-pointer transition-colors text-sm"
			:class="!warranty ? 'border-primary bg-primary/5' : 'border-gray-200 hover:border-gray-300'"
		>
			<input type="radio" name="warranty" :checked="!warranty" @change="warranty = false" class="sr-only">
			<span class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="!warranty ? 'border-primary' : 'border-gray-300'">
				<span x-show="!warranty" class="w-2 h-2 rounded-full bg-primary"></span>
			</span>
			<span class="font-medium text-gray-900"><?php esc_html_e( 'No, thanks', 'flavor' ); ?></span>
		</label>
	</div>
</div>
