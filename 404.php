<?php
/**
 * 404 - Page Not Found
 *
 * @package flavor
 */

get_header(); ?>

<main class="max-w-4xl mx-auto px-4 py-16 text-center">

	<!-- Error Icon -->
	<div class="mb-8">
		<span class="text-8xl md:text-9xl font-black text-gray-200">404</span>
	</div>

	<h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3"><?php esc_html_e( 'Page Not Found', 'flavor' ); ?></h1>
	<p class="text-gray-500 mb-8 max-w-md mx-auto"><?php esc_html_e( 'The page you\'re looking for doesn\'t exist or has been moved. Try searching or browse our popular categories.', 'flavor' ); ?></p>

	<!-- Search -->
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="max-w-md mx-auto mb-12">
		<div class="flex gap-2">
			<input type="search" name="s"
				class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[var(--color-primary,#E15726)] focus:border-transparent"
				placeholder="<?php esc_attr_e( 'Search…', 'flavor' ); ?>">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<input type="hidden" name="post_type" value="product">
			<?php endif; ?>
			<button type="submit" class="px-5 py-2.5 bg-[var(--color-primary,#E15726)] text-white font-medium rounded-lg hover:opacity-90 transition-opacity">
				<?php esc_html_e( 'Search', 'flavor' ); ?>
			</button>
		</div>
	</form>

	<!-- Back to Shop -->
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
		class="inline-flex items-center gap-2 bg-gray-900 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-gray-800 transition-colors">
		<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
		<?php esc_html_e( 'Back to Shop', 'flavor' ); ?>
	</a>

</main>

<?php get_footer(); ?>
