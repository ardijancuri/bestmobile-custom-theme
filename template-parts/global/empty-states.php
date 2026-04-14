<?php
/**
 * Reusable Empty State Component
 *
 * Usage: get_template_part( 'template-parts/global/empty-states', null, array(
 *   'icon'     => '<path ... />', // SVG path (Heroicons)
 *   'title'    => 'Title text',
 *   'message'  => 'Description text',
 *   'cta_url'  => 'https://...',
 *   'cta_text' => 'Button label',
 * ) );
 *
 * @package flavor
 */

defined( 'ABSPATH' ) || exit;

$icon     = $args['icon'] ?? '';
$title    = $args['title'] ?? '';
$message  = $args['message'] ?? '';
$cta_url  = $args['cta_url'] ?? '';
$cta_text = $args['cta_text'] ?? '';
?>

<div class="flex flex-col items-center justify-center py-16 px-4 text-center">
	<?php if ( $icon ) : ?>
		<div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-6">
			<svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
				<?php echo $icon; // phpcs:ignore — trusted SVG path from template call ?>
			</svg>
		</div>
	<?php endif; ?>

	<?php if ( $title ) : ?>
		<h2 class="text-xl font-bold text-gray-900 mb-2"><?php echo esc_html( $title ); ?></h2>
	<?php endif; ?>

	<?php if ( $message ) : ?>
		<p class="text-gray-500 mb-8 max-w-sm"><?php echo esc_html( $message ); ?></p>
	<?php endif; ?>

	<?php if ( $cta_url && $cta_text ) : ?>
		<a href="<?php echo esc_url( $cta_url ); ?>"
			class="inline-flex items-center gap-2 bg-[var(--color-primary,#E15726)] text-white font-semibold px-8 py-3.5 rounded-xl hover:opacity-90 transition-opacity">
			<?php echo esc_html( $cta_text ); ?>
		</a>
	<?php endif; ?>
</div>
