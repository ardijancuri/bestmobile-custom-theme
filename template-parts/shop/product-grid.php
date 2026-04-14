<?php
/**
 * Product grid with infinite scroll
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="py-4">
	<!-- Result count -->
	<p class="text-sm text-gray-600 mb-3">
		<span x-text="totalProducts"></span> <?php esc_html_e( 'products found', 'flavor' ); ?>
	</p>

	<!-- Product grid -->
	<div
		id="flavor-product-grid"
		class="grid grid-cols-2 tablet-sm:grid-cols-3 md:grid-cols-4 gap-4"
		x-ref="productGrid"
	>
		<?php
		if ( woocommerce_product_loop() ) {
			while ( have_posts() ) {
				the_post();
				wc_get_template_part( 'content', 'product' );
			}
		} else {
			echo '<div class="col-span-full text-center py-12 text-gray-600">';
			esc_html_e( 'No products found.', 'flavor' );
			echo '</div>';
		}
		?>
	</div>

	<!-- Skeleton placeholders -->
	<template x-if="loading">
		<div class="grid grid-cols-2 tablet-sm:grid-cols-3 md:grid-cols-4 gap-4 mt-3">
			<template x-for="i in 8" :key="i">
				<div class="animate-pulse">
					<div class="bg-gray-300 rounded-lg aspect-square mb-2"></div>
					<div class="h-3 bg-gray-300 rounded w-3/4 mb-1"></div>
					<div class="h-3 bg-gray-300 rounded w-1/2 mb-1"></div>
					<div class="h-4 bg-gray-300 rounded w-1/3"></div>
				</div>
			</template>
		</div>
	</template>

	<!-- Infinite scroll sentinel -->
	<div x-ref="scrollSentinel" class="h-1"></div>

	<!-- Show More fallback -->
	<div x-show="hasMore && !loading" class="text-center py-4">
		<button @click="loadMore()" class="px-6 py-2.5 bg-primary border border-primary text-white rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors">
			<?php esc_html_e( 'Show More', 'flavor' ); ?>
		</button>
	</div>

	<!-- End of results -->
	<div x-show="!hasMore && totalProducts > 0 && currentPage > 1" class="text-center py-4">
		<p class="text-sm text-gray-500"><?php esc_html_e( 'You\'ve reached the end of results', 'flavor' ); ?></p>
	</div>
</div>
