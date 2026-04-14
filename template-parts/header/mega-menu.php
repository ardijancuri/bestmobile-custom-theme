<?php
/**
 * Mega Menu - Category Sidebar + Latest Products Flyout
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$product_categories = get_terms(
	array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
		'parent'     => 0,
		'exclude'    => get_option( 'default_product_cat' ),
	)
);

if ( is_wp_error( $product_categories ) ) {
	$product_categories = array();
}

$default_active_category = ! empty( $product_categories ) ? (int) $product_categories[0]->term_id : null;
?>

<div
	x-data="{ open: false, activeCategory: <?php echo null !== $default_active_category ? $default_active_category : 'null'; ?> }"
	@toggle-mega-menu.window="open = !open"
	@keydown.escape.window="open = false"
	x-show="open"
	x-cloak
	@click.outside="open = false"
	x-transition:enter="transition ease-out duration-200"
	x-transition:enter-start="opacity-0 -translate-y-2"
	x-transition:enter-end="opacity-100 translate-y-0"
	x-transition:leave="transition ease-in duration-150"
	x-transition:leave-start="opacity-100 translate-y-0"
	x-transition:leave-end="opacity-0 -translate-y-2"
	class="hidden tablet-sm:block absolute top-full left-0 right-0 z-40 bg-white shadow-xl rounded-b-lg"
>
	<div class="container-site">
		<div class="flex min-h-[338px]">
			<!-- Sidebar: Category List -->
			<div class="w-64 border-r border-gray-100 py-4">
				<ul class="space-y-0.5">
					<?php foreach ( $product_categories as $cat ) : ?>
						<?php $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true ); ?>
						<li @mouseenter="activeCategory = <?php echo (int) $cat->term_id; ?>" class="relative">
							<a
								href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
								class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors rounded-md"
								:class="{ 'bg-gray-50 text-primary': activeCategory === <?php echo (int) $cat->term_id; ?> }"
							>
								<?php if ( $thumbnail_id ) : ?>
									<img
										src="<?php echo esc_url( wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' ) ); ?>"
										alt=""
										class="w-6 h-6 rounded object-contain flex-shrink-0"
										loading="lazy"
									>
								<?php else : ?>
									<span class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
										<svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
											<path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
										</svg>
									</span>
								<?php endif; ?>
								<span class="flex-1"><?php echo esc_html( $cat->name ); ?></span>
								<svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
									<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
								</svg>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Flyout: Latest Products -->
			<div class="flex-1 overflow-hidden py-4 px-6">
				<?php foreach ( $product_categories as $cat ) : ?>
					<?php
					$latest_products = wc_get_products(
						array(
							'status'   => 'publish',
							'limit'    => 4,
							'orderby'  => 'date',
							'order'    => 'DESC',
							'category' => array( $cat->slug ),
						)
					);
					$mega_menu_image_id = function_exists( 'flavor_get_product_cat_mega_menu_image_id' ) ? flavor_get_product_cat_mega_menu_image_id( $cat->term_id ) : 0;
					?>
					<div
						x-show="activeCategory === <?php echo (int) $cat->term_id; ?>"
						x-transition:enter="transition ease-out duration-150"
						x-transition:enter-start="opacity-0"
						x-transition:enter-end="opacity-100"
					>
						<div class="flex items-start justify-between gap-6">
							<div class="flex-1 min-w-0">
								<div class="mb-4 flex items-center justify-between gap-4">
									<div>
										<p class="text-xs text-gray-400"><?php esc_html_e( 'Latest products', 'flavor' ); ?></p>
										<h3 class="text-lg font-semibold text-gray-900"><?php echo esc_html( $cat->name ); ?></h3>
									</div>
									<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="text-sm text-primary hover:underline">
										<?php esc_html_e( 'View all', 'flavor' ); ?>
									</a>
								</div>

								<?php if ( ! empty( $latest_products ) ) : ?>
									<div class="grid grid-cols-2 gap-4">
										<?php foreach ( $latest_products as $menu_product ) : ?>
											<?php
											$menu_product_image = $menu_product->get_image_id();
											$menu_product_price = flavor_price_html_with_small_decimals( $menu_product->get_price_html() );
											?>
											<a
												href="<?php echo esc_url( $menu_product->get_permalink() ); ?>"
												class="group flex items-center gap-3 rounded-lg border border-gray-100 bg-white p-3 hover:border-gray-200 transition-colors"
											>
												<div class="flex h-20 w-20 flex-shrink-0 items-center justify-center overflow-hidden rounded-md bg-gray-50">
													<?php if ( $menu_product_image ) : ?>
														<?php
														echo wp_get_attachment_image(
															$menu_product_image,
															'flavor-product-card',
															false,
															array(
																'class'   => 'block max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-105',
																'loading' => 'lazy',
															)
														);
														?>
													<?php else : ?>
														<div class="text-gray-300">
															<svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
																<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
															</svg>
														</div>
													<?php endif; ?>
												</div>

												<div class="min-w-0 flex-1">
													<p class="text-sm font-medium text-gray-900 line-clamp-2">
														<?php echo esc_html( $menu_product->get_name() ); ?>
													</p>

													<?php if ( $menu_product_price ) : ?>
														<div class="product-card-price mt-2 text-sm font-bold text-gray-900">
															<?php echo wp_kses_post( $menu_product_price ); ?>
														</div>
													<?php endif; ?>
												</div>
											</a>
										<?php endforeach; ?>
									</div>
								<?php else : ?>
									<div class="flex items-center justify-center rounded-lg border border-gray-100 bg-gray-50 text-center" style="min-height: 220px;">
										<div class="px-6">
											<p class="text-base font-semibold text-gray-900"><?php echo esc_html( $cat->name ); ?></p>
											<p class="mt-2 text-sm text-gray-500">
												<?php esc_html_e( 'No products are available in this category yet.', 'flavor' ); ?>
											</p>
											<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="mt-4 inline-flex text-sm text-primary hover:underline">
												<?php esc_html_e( 'Shop category', 'flavor' ); ?>
											</a>
										</div>
									</div>
								<?php endif; ?>
							</div>

							<?php if ( $mega_menu_image_id ) : ?>
								<a
									href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
									class="block flex-shrink-0 overflow-hidden rounded-lg"
									style="width: 210px; max-width: 100%;"
								>
									<?php
									echo wp_get_attachment_image(
										$mega_menu_image_id,
										'large',
										false,
										array(
											'class'   => 'block w-full',
											'style'   => 'height: 300px; object-fit: cover;',
											'loading' => 'lazy',
										)
									);
									?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>

				<div x-show="!activeCategory" class="flex items-center justify-center h-full text-gray-400 text-sm">
					<?php esc_html_e( 'Hover over a category to explore', 'flavor' ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
