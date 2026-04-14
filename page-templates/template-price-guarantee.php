<?php
/**
 * Template Name: Price Guarantee
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="max-w-site-xxl mx-auto px-3 md:px-4 py-6">

	<?php get_template_part( 'template-parts/global/breadcrumbs' ); ?>

	<div class="text-center max-w-2xl mx-auto mb-10">
		<h1 class="text-2xl md:text-3xl font-bold text-gray-700 mb-3"><?php esc_html_e( 'Our Price Guarantee', 'flavor' ); ?></h1>
		<p class="text-gray-500"><?php esc_html_e( 'We are committed to offering you the best prices. If you find a lower price elsewhere, we\'ll match it.', 'flavor' ); ?></p>
	</div>

	<!-- Three Pillars -->
	<div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto mb-12">

		<!-- Pillar 1: Best Price -->
		<div class="text-center border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
			<div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
				<svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
			</div>
			<h3 class="text-base font-bold text-gray-700 mb-2"><?php esc_html_e( 'Best Price Promise', 'flavor' ); ?></h3>
			<p class="text-sm text-gray-500 leading-relaxed"><?php esc_html_e( 'We continuously monitor the market to ensure our prices are the most competitive. You always get the best deal with us, no haggling needed.', 'flavor' ); ?></p>
		</div>

		<!-- Pillar 2: Price Match -->
		<div class="text-center border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
			<div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
				<svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
			</div>
			<h3 class="text-base font-bold text-gray-700 mb-2"><?php esc_html_e( 'Price Match Guarantee', 'flavor' ); ?></h3>
			<p class="text-sm text-gray-500 leading-relaxed"><?php esc_html_e( 'Found a lower price at a local authorized retailer? Send us the link and we\'ll match the price. It\'s that simple — your satisfaction is our priority.', 'flavor' ); ?></p>
		</div>

		<!-- Pillar 3: Money Back -->
		<div class="text-center border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow">
			<div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
				<svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
			</div>
			<h3 class="text-base font-bold text-gray-700 mb-2"><?php esc_html_e( 'Money Back Assurance', 'flavor' ); ?></h3>
			<p class="text-sm text-gray-500 leading-relaxed"><?php esc_html_e( 'If the price drops within 14 days of your purchase, we\'ll refund the difference as store credit. Shop with confidence knowing you\'re always protected.', 'flavor' ); ?></p>
		</div>

	</div>

	<!-- Page Content -->
	<?php
	while ( have_posts() ) :
		the_post();
		$content = get_the_content();
		if ( trim( $content ) ) :
	?>
		<div class="prose max-w-3xl mx-auto">
			<?php the_content(); ?>
		</div>
	<?php
		endif;
	endwhile;
	?>

</div>

<?php get_footer(); ?>
