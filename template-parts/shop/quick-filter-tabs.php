<?php
/**
 * Quick filter tabs for shop page
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="overflow-x-auto scrollbar-hide -mx-3 px-3 md:mx-0 md:px-0">
	<div class="flex items-center gap-0 min-w-max border-b border-gray-300">
		<?php
		$tabs = array(
			''            => __( 'All products', 'flavor' ),
			'bestsellers' => __( 'Best sellers', 'flavor' ),
			'most_viewed' => __( 'Most viewed', 'flavor' ),
			'top_rated'   => __( 'Top rated', 'flavor' ),
		);

		foreach ( $tabs as $key => $label ) :
		?>
			<button
				@click="quickFilter = '<?php echo esc_js( $key ); ?>'; loadProducts(1)"
				:class="quickFilter === '<?php echo esc_js( $key ); ?>' ? 'border-primary text-primary font-semibold' : 'border-transparent text-gray-600 hover:text-gray-700'"
				class="px-4 py-3 text-sm whitespace-nowrap border-b-2 transition-colors"
			>
				<?php echo esc_html( $label ); ?>
			</button>
		<?php endforeach; ?>
	</div>
</div>
