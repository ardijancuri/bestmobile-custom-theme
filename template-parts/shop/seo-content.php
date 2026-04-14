<?php
/**
 * SEO content and FAQ accordion for category pages
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$term = get_queried_object();
if ( ! $term || ! is_a( $term, 'WP_Term' ) ) {
	return;
}

$description = term_description( $term->term_id );
$faq_items   = get_term_meta( $term->term_id, 'flavor_faq', true );
?>

<?php if ( $description || ! empty( $faq_items ) ) : ?>
<div class="py-8 border-t border-gray-300 mt-8">

	<?php if ( $description ) : ?>
	<div class="prose prose-sm max-w-none text-gray-600 mb-6">
		<?php echo wp_kses_post( $description ); ?>
	</div>
	<?php endif; ?>

	<?php if ( ! empty( $faq_items ) && is_array( $faq_items ) ) : ?>
	<div class="mt-6" x-data="{ openFaq: null }">
		<h2 class="text-lg font-bold mb-4"><?php esc_html_e( 'Frequently Asked Questions', 'flavor' ); ?></h2>
		<div class="space-y-2">
			<?php foreach ( $faq_items as $index => $faq ) : ?>
			<div class="border border-gray-300 rounded-lg overflow-hidden">
				<button
					@click="openFaq === <?php echo absint( $index ); ?> ? openFaq = null : openFaq = <?php echo absint( $index ); ?>"
					class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-left hover:bg-gray-50 transition-colors"
				>
					<span><?php echo esc_html( $faq['question'] ?? '' ); ?></span>
					<svg :class="openFaq === <?php echo absint( $index ); ?> && 'rotate-180'" class="w-4 h-4 flex-shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
				</button>
				<div x-show="openFaq === <?php echo absint( $index ); ?>" x-collapse class="px-4 pb-3 text-sm text-gray-600">
					<?php echo wp_kses_post( $faq['answer'] ?? '' ); ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

</div>
<?php endif; ?>
