<?php
/**
 * Brand Logos — Grid on desktop, Swiper carousel on mobile
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enabled = get_theme_mod( 'flavor_brands_enabled', true );
if ( ! $enabled ) {
	return;
}

$title = get_theme_mod( 'flavor_brands_title', __( 'Our Brands', 'flavor' ) );

// Collect brands from Customizer (up to 8 slots)
$brands = array();
for ( $i = 1; $i <= 8; $i++ ) {
	$logo_url  = get_theme_mod( "flavor_brand_logo_{$i}_image", '' );
	$logo_name = get_theme_mod( "flavor_brand_logo_{$i}_name", '' );
	$logo_link = get_theme_mod( "flavor_brand_logo_{$i}_link", '' );
	if ( $logo_url || $logo_name ) {
		$brands[] = array(
			'url'  => $logo_url,
			'name' => $logo_name,
			'link' => $logo_link,
		);
	}
}

// Fallback: default placeholder brands if none configured
if ( empty( $brands ) ) {
	$default_brands = array( 'Apple', 'Samsung', 'Sony', 'Dell', 'Lenovo', 'LG' );
	foreach ( $default_brands as $name ) {
		$brands[] = array(
			'url'  => '',
			'name' => $name,
			'link' => '#',
		);
	}
}
?>

<section class="my-8 md:my-12" aria-label="<?php echo esc_attr( $title ); ?>">
	<?php if ( $title ) : ?>
		<h2 class="text-lg font-bold text-gray-900 mb-5 text-center"><?php echo esc_html( $title ); ?></h2>
	<?php endif; ?>

	<!-- Desktop: Grid -->
	<div class="hidden md:block">
		<div class="bg-white border border-gray-200 rounded-2xl py-6 px-8">
			<div class="grid grid-cols-3 lg:grid-cols-6 gap-6 items-center justify-items-center">
				<?php foreach ( $brands as $brand ) : ?>
					<?php
					$tag_open  = $brand['link'] ? '<a href="' . esc_url( $brand['link'] ) . '" class="group">' : '<span class="group">';
					$tag_close = $brand['link'] ? '</a>' : '</span>';
					echo $tag_open; // phpcs:ignore
					?>
						<div class="flex items-center justify-center h-16 w-full px-4 rounded-xl transition-all group-hover:bg-gray-50 group-hover:shadow-sm">
							<?php if ( $brand['url'] ) : ?>
								<img src="<?php echo esc_url( $brand['url'] ); ?>"
									 alt="<?php echo esc_attr( $brand['name'] ); ?>"
									 class="max-w-[120px] max-h-[40px] object-contain opacity-60 group-hover:opacity-100 transition-opacity grayscale group-hover:grayscale-0"
									 loading="lazy">
							<?php else : ?>
								<span class="text-lg font-bold text-gray-300 group-hover:text-gray-600 transition-colors tracking-wide">
									<?php echo esc_html( $brand['name'] ); ?>
								</span>
							<?php endif; ?>
						</div>
					<?php echo $tag_close; // phpcs:ignore ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- Mobile: Swiper Carousel -->
	<div class="md:hidden">
		<div class="swiper flavor-brands-swiper bg-white border border-gray-200 rounded-xl py-4 px-2">
			<div class="swiper-wrapper items-center">
				<?php foreach ( $brands as $brand ) : ?>
					<div class="swiper-slide !w-auto">
						<?php
						$tag_open  = $brand['link'] ? '<a href="' . esc_url( $brand['link'] ) . '">' : '<span>';
						$tag_close = $brand['link'] ? '</a>' : '</span>';
						echo $tag_open; // phpcs:ignore
						?>
							<div class="flex items-center justify-center h-12 px-6">
								<?php if ( $brand['url'] ) : ?>
									<img src="<?php echo esc_url( $brand['url'] ); ?>"
										 alt="<?php echo esc_attr( $brand['name'] ); ?>"
										 class="max-w-[90px] max-h-[32px] object-contain opacity-60 grayscale"
										 loading="lazy">
								<?php else : ?>
									<span class="text-base font-bold text-gray-300 whitespace-nowrap">
										<?php echo esc_html( $brand['name'] ); ?>
									</span>
								<?php endif; ?>
							</div>
						<?php echo $tag_close; // phpcs:ignore ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	if (typeof Swiper !== 'undefined' && document.querySelector('.flavor-brands-swiper')) {
		new Swiper('.flavor-brands-swiper', {
			slidesPerView: 'auto',
			spaceBetween: 8,
			freeMode: true,
			loop: true,
			autoplay: {
				delay: 2500,
				disableOnInteraction: false,
			},
		});
	}
});
</script>
