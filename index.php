<?php
/**
 * Main Index Template (fallback)
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main">
	<div class="container-site py-8">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'mb-8' ); ?>>
					<h2 class="text-xl font-bold mb-2">
						<a href="<?php the_permalink(); ?>" class="hover:text-primary"><?php the_title(); ?></a>
					</h2>
					<div class="text-gray-600"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p class="text-gray-500"><?php esc_html_e( 'Nothing found.', 'flavor' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
