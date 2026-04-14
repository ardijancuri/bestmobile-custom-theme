<?php
/**
 * Hero Area — Category sidebar + Slider + Thumbnails
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get slides from customizer
$slides = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$img     = get_theme_mod( "flavor_hero_slide_{$i}_image", '' );
	$img_mob = get_theme_mod( "flavor_hero_slide_{$i}_image_mobile", '' );
	$link    = get_theme_mod( "flavor_hero_slide_{$i}_link", '' );
	$alt     = get_theme_mod( "flavor_hero_slide_{$i}_alt", '' );
	if ( $img ) {
		$slides[] = compact( 'img', 'img_mob', 'link', 'alt' );
	}
}

// Get product categories for sidebar
$categories = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'parent'     => 0,
	'number'     => 12,
	'orderby'    => 'count',
	'order'      => 'DESC',
	'exclude'    => array( get_option( 'default_product_cat' ) ),
) );
if ( is_wp_error( $categories ) ) {
	$categories = array();
}
?>

<section class="container-site mt-4 mb-6" aria-label="<?php esc_attr_e( 'Hero area', 'flavor' ); ?>">
	<div class="flex gap-4">

		<!-- Category Sidebar (Desktop only) -->
		<nav class="hidden lg:flex flex-col w-[280px] flex-shrink-0 bg-white rounded-lg border border-gray-300 min-h-[338px] relative z-20"
			 aria-label="<?php esc_attr_e( 'Product categories', 'flavor' ); ?>">
			<?php foreach ( $categories as $index => $cat ) :
				$thumb_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
				$children = get_terms( array(
					'taxonomy'   => 'product_cat',
					'hide_empty' => true,
					'parent'     => $cat->term_id,
					'number'     => 10,
				) );
				if ( is_wp_error( $children ) ) {
					$children = array();
				}
			?>
				<div class="group relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
					<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
					   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors <?php echo $index === 0 ? 'rounded-t-lg' : ''; ?> <?php echo $index === count( $categories ) - 1 ? 'rounded-b-lg' : ''; ?>">
						<?php if ( $thumb_id ) : ?>
							<img src="<?php echo esc_url( wp_get_attachment_image_url( $thumb_id, 'thumbnail' ) ); ?>" alt="" class="w-5 h-5 object-contain flex-shrink-0 rounded" loading="lazy">
						<?php else : ?>
							<svg class="w-5 h-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
						<?php endif; ?>
						<span class="flex-1 truncate"><?php echo esc_html( $cat->name ); ?></span>
						<?php if ( ! empty( $children ) ) : ?>
							<svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
						<?php endif; ?>
					</a>

					<?php if ( ! empty( $children ) ) : ?>
						<!-- Mega Menu Flyout -->
						<div x-show="open" x-cloak x-transition.opacity style="display: none;"
							 class="absolute left-full top-0 ml-0 bg-white rounded-lg border border-gray-300 shadow-lg p-4 min-w-[500px] z-30 grid grid-cols-2 gap-3"
							 @mouseenter="open = true" @mouseleave="open = false">
							<?php foreach ( $children as $child ) : ?>
								<a href="<?php echo esc_url( get_term_link( $child ) ); ?>"
								   class="flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-primary hover:bg-gray-50 rounded transition-colors">
									<?php
									$thumb_id = get_term_meta( $child->term_id, 'thumbnail_id', true );
									if ( $thumb_id ) :
									?>
										<img src="<?php echo esc_url( wp_get_attachment_image_url( $thumb_id, 'thumbnail' ) ); ?>"
											 alt="" class="w-8 h-8 object-contain rounded" loading="lazy">
									<?php endif; ?>
									<span><?php echo esc_html( $child->name ); ?></span>
								</a>
							<?php endforeach; ?>
							<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
							   class="col-span-2 text-center text-sm text-primary font-medium py-2 hover:underline">
								<?php
								/* translators: %s: category name */
								printf( esc_html__( 'View all %s', 'flavor' ), esc_html( $cat->name ) );
								?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</nav>

		<!-- Slider Area -->
		<div class="flex-1 min-w-0">
			<?php if ( ! empty( $slides ) ) : ?>
				<!-- Main Slider -->
				<div class="swiper flavor-hero-slider rounded-lg overflow-hidden" id="heroSlider">
					<div class="swiper-wrapper">
						<?php foreach ( $slides as $i => $slide ) : ?>
							<div class="swiper-slide">
								<?php if ( $slide['link'] ) : ?>
									<a href="<?php echo esc_url( $slide['link'] ); ?>" class="block">
								<?php endif; ?>
									<picture>
										<?php if ( $slide['img_mob'] ) : ?>
											<source media="(max-width: 599px)" srcset="<?php echo esc_url( $slide['img_mob'] ); ?>">
										<?php endif; ?>
										<source media="(min-width: 600px)" srcset="<?php echo esc_url( $slide['img'] ); ?>">
										<img src="<?php echo esc_url( $slide['img'] ); ?>"
											 alt="<?php echo esc_attr( $slide['alt'] ); ?>"
											 class="w-full aspect-[3.5/1] object-cover"
											 width="960" height="274"
											 <?php echo $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
									</picture>
								<?php if ( $slide['link'] ) : ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="swiper-button-prev !text-white !w-10 !h-10 !bg-black/30 !rounded-full after:!text-sm"></div>
					<div class="swiper-button-next !text-white !w-10 !h-10 !bg-black/30 !rounded-full after:!text-sm"></div>
					<div class="swiper-pagination"></div>
				</div>

				<!-- Thumbnail Strip -->
				<?php if ( count( $slides ) > 1 ) : ?>
					<div class="swiper flavor-hero-thumbs mt-2 hidden md:block" id="heroThumbs">
						<div class="swiper-wrapper">
							<?php foreach ( $slides as $i => $slide ) : ?>
								<div class="swiper-slide cursor-pointer" style="width:180px !important; flex-shrink:0">
									<img src="<?php echo esc_url( $slide['img'] ); ?>"
										 alt="" class="w-full h-14 object-cover rounded opacity-50 transition-all"
										 loading="lazy">
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<div class="bg-gray-100 rounded-lg aspect-[3.5/1] flex items-center justify-center text-gray-500">
					<?php esc_html_e( 'Add slides in Customizer → Homepage → Hero Slider', 'flavor' ); ?>
				</div>
			<?php endif; ?>
		</div>

	</div>
</section>
