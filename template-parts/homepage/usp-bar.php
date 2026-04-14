<?php
/**
 * USP Bar — Trust badges
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_front_page() && ! is_product_category() ) {
	return;
}

$enabled = get_theme_mod( 'flavor_usp_enabled', true );
if ( ! $enabled ) {
	return;
}

$usps = array();
$defaults = array(
	array(
		'icon'     => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>',
		'title'    => __( 'Free Shipping', 'flavor' ),
		'subtitle' => __( 'On orders over €50', 'flavor' ),
	),
	array(
		'icon'     => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
		'title'    => __( 'Secure Payment', 'flavor' ),
		'subtitle' => __( '100% protected', 'flavor' ),
	),
	array(
		'icon'     => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>',
		'title'    => __( 'Easy Returns', 'flavor' ),
		'subtitle' => __( '30-day guarantee', 'flavor' ),
	),
	array(
		'icon'     => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
		'title'    => __( '24/7 Support', 'flavor' ),
		'subtitle' => __( 'Always here to help', 'flavor' ),
	),
);

for ( $i = 0; $i < 4; $i++ ) {
	$title    = get_theme_mod( "flavor_usp_{$i}_title", $defaults[ $i ]['title'] );
	$subtitle = get_theme_mod( "flavor_usp_{$i}_subtitle", $defaults[ $i ]['subtitle'] );
	$icon     = get_theme_mod( "flavor_usp_{$i}_icon", '' );
	$usps[]   = array(
		'icon'     => $icon ? $icon : $defaults[ $i ]['icon'],
		'title'    => $title,
		'subtitle' => $subtitle,
	);
}
?>

<section class="my-4" x-data="{ dismissed: sessionStorage.getItem('flavor_usp_dismissed') === '1' }" x-show="!dismissed" x-cloak
		 aria-label="<?php esc_attr_e( 'Why shop with us', 'flavor' ); ?>">
	<div class="bg-white rounded-lg shadow-sm border border-gray-300 relative">
		<!-- Dismiss button -->
		<button @click="dismissed = true; sessionStorage.setItem('flavor_usp_dismissed', '1')"
				class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 z-10"
				aria-label="<?php esc_attr_e( 'Dismiss', 'flavor' ); ?>">
			<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
		</button>

		<div class="grid grid-cols-2 md:grid-cols-4">
			<?php foreach ( $usps as $index => $usp ) : ?>
				<div class="flex min-w-0 items-center gap-2 px-2.5 py-2 md:gap-3 md:px-4 md:py-3 <?php echo $index % 2 === 1 ? 'border-l border-gray-300' : ''; ?> <?php echo $index > 0 ? 'md:border-l md:border-gray-300' : ''; ?>">
					<span class="text-primary flex-shrink-0"><?php echo $usp['icon']; // phpcs:ignore -- safe, hardcoded SVG from defaults ?></span>
					<div class="min-w-0">
						<p class="text-sm font-medium text-gray-700 truncate"><?php echo esc_html( $usp['title'] ); ?></p>
						<p class="text-xs text-gray-500 truncate"><?php echo esc_html( $usp['subtitle'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
