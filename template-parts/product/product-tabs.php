<?php
/**
 * Product tabs — Description, Specifications, Reviews
 * Desktop: tabs. Mobile: accordion.
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$tabs = array(
	'description'    => __( 'Description', 'flavor' ),
	'specifications' => __( 'Specifications', 'flavor' ),
);

$attributes = $product->get_attributes();
?>

<div class="mt-8 md:mt-12" x-data="{ tab: 'description', isMobile: window.innerWidth < 768 }" @resize.window="isMobile = window.innerWidth < 768">

	<!-- Desktop Tabs Nav -->
	<div class="hidden md:flex border-b border-gray-200 mb-6">
		<?php foreach ( $tabs as $key => $label ) : ?>
			<button
				@click="tab = '<?php echo esc_attr( $key ); ?>'"
				class="px-4 py-3 text-sm font-medium transition-colors relative"
				:class="tab === '<?php echo esc_attr( $key ); ?>' ? 'text-primary' : 'text-gray-500 hover:text-gray-700'"
			>
				<?php echo esc_html( $label ); ?>
				<span
					class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary transition-opacity"
					:class="tab === '<?php echo esc_attr( $key ); ?>' ? 'opacity-100' : 'opacity-0'"
				></span>
			</button>
		<?php endforeach; ?>
	</div>

	<!-- Desktop Tab Panels -->
	<div class="hidden md:block">
		<!-- Description -->
		<div x-show="tab === 'description'">
			<div class="prose prose-sm max-w-none text-gray-700">
				<?php the_content(); ?>
			</div>
		</div>

		<!-- Specifications -->
		<div x-show="tab === 'specifications'">
			<?php if ( ! empty( $attributes ) ) : ?>
				<table class="w-full text-sm">
					<?php $i = 0; foreach ( $attributes as $attr ) :
						if ( ! $attr->get_visible() ) continue;
						$values = array();
						if ( $attr->is_taxonomy() ) {
							$terms = wp_get_post_terms( $product->get_id(), $attr->get_name(), array( 'fields' => 'names' ) );
							$values = is_array( $terms ) ? $terms : array();
						} else {
							$values = $attr->get_options();
						}
					?>
						<tr class="<?php echo $i % 2 === 0 ? 'bg-gray-50' : ''; ?>">
							<td class="px-4 py-2.5 font-medium text-gray-900 w-1/3"><?php echo esc_html( wc_attribute_label( $attr->get_name() ) ); ?></td>
							<td class="px-4 py-2.5 text-gray-600"><?php echo esc_html( implode( ', ', $values ) ); ?></td>
						</tr>
					<?php $i++; endforeach; ?>
				</table>
			<?php else : ?>
				<p class="text-sm text-gray-500"><?php esc_html_e( 'No specifications available.', 'flavor' ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<!-- Mobile Accordion -->
	<div class="md:hidden space-y-2">
		<?php foreach ( $tabs as $key => $label ) : ?>
			<div class="border border-gray-200 rounded-lg overflow-hidden">
				<button
					@click="tab = tab === '<?php echo esc_attr( $key ); ?>' ? '' : '<?php echo esc_attr( $key ); ?>'"
					class="flex items-center justify-between w-full px-4 py-3 text-left text-sm font-medium text-gray-900"
				>
					<span><?php echo esc_html( $label ); ?></span>
					<svg class="w-4 h-4 text-gray-400 transition-transform" :class="tab === '<?php echo esc_attr( $key ); ?>' && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
				</button>
				<div x-show="tab === '<?php echo esc_attr( $key ); ?>'" x-collapse class="px-4 pb-4">
					<?php if ( 'description' === $key ) : ?>
						<div class="prose prose-sm max-w-none text-gray-700"><?php the_content(); ?></div>
					<?php elseif ( 'specifications' === $key ) : ?>
						<?php if ( ! empty( $attributes ) ) : ?>
							<table class="w-full text-sm">
								<?php $i = 0; foreach ( $attributes as $attr ) :
									if ( ! $attr->get_visible() ) continue;
									$values = $attr->is_taxonomy()
										? wp_get_post_terms( $product->get_id(), $attr->get_name(), array( 'fields' => 'names' ) )
										: $attr->get_options();
									if ( ! is_array( $values ) ) $values = array();
								?>
									<tr class="<?php echo $i % 2 === 0 ? 'bg-gray-50' : ''; ?>">
										<td class="px-3 py-2 font-medium text-gray-900"><?php echo esc_html( wc_attribute_label( $attr->get_name() ) ); ?></td>
										<td class="px-3 py-2 text-gray-600"><?php echo esc_html( implode( ', ', $values ) ); ?></td>
									</tr>
								<?php $i++; endforeach; ?>
							</table>
						<?php else : ?>
							<p class="text-sm text-gray-500"><?php esc_html_e( 'No specifications available.', 'flavor' ); ?></p>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
