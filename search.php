<?php
/**
 * Search Results
 *
 * @package flavor
 */

get_header(); ?>

<main class="max-w-7xl mx-auto px-4 py-8">

	<div class="mb-8">
		<h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'Search results for: "%s"', 'flavor' ),
				'<span class="text-[var(--color-primary,#E15726)]">' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
		<p class="text-gray-500 text-sm">
			<?php
			printf(
				/* translators: %d: result count */
				esc_html( _n( '%d result found', '%d results found', (int) $wp_query->found_posts, 'flavor' ) ),
				(int) $wp_query->found_posts
			);
			?>
		</p>
	</div>

	<!-- Search Bar -->
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mb-8">
		<div class="flex gap-2 max-w-xl">
			<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
				class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[var(--color-primary,#E15726)] focus:border-transparent"
				placeholder="<?php esc_attr_e( 'Search products…', 'flavor' ); ?>">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<input type="hidden" name="post_type" value="product">
			<?php endif; ?>
			<button type="submit" class="px-6 py-2.5 bg-[var(--color-primary,#E15726)] text-white font-medium rounded-lg hover:opacity-90 transition-opacity">
				<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
			</button>
		</div>
	</form>

	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( 'product' === get_post_type() && function_exists( 'wc_get_template_part' ) ) : ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php else : ?>
					<article class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="block aspect-square overflow-hidden">
								<?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300' ) ); ?>
							</a>
						<?php endif; ?>
						<div class="p-4">
							<h3 class="font-medium text-sm text-gray-900 mb-1 line-clamp-2">
								<a href="<?php the_permalink(); ?>" class="hover:text-[var(--color-primary,#E15726)]"><?php the_title(); ?></a>
							</h3>
							<p class="text-xs text-gray-500 line-clamp-2"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p>
						</div>
					</article>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>

		<!-- Pagination -->
		<div class="mt-8 flex justify-center">
			<?php
			the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>',
				'next_text' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>',
				'class'     => 'flex items-center gap-2',
			) );
			?>
		</div>

	<?php else : ?>
		<?php get_template_part( 'template-parts/global/empty-states', null, array(
			'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>',
			'title'   => __( 'No results found', 'flavor' ),
			'message' => sprintf(
				/* translators: %s: search query */
				__( 'Sorry, no results were found for "%s". Try a different search term.', 'flavor' ),
				esc_html( get_search_query() )
			),
<<<<<<< Updated upstream
			'cta_url' => wc_get_page_permalink( 'shop' ),
=======
			'cta_url' => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ),
>>>>>>> Stashed changes
			'cta_text'=> __( 'Browse All Products', 'flavor' ),
		) ); ?>
	<?php endif; ?>

</main>

<?php get_footer(); ?>
