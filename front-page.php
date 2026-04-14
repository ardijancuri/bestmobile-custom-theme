<?php
/**
 * Homepage Template
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

flavor_homepage_reset_used_product_ids();

get_header();
?>

<main id="primary" class="site-main">

	<?php get_template_part( 'template-parts/homepage/hero-area' ); ?>

	<div class="container-site">

		<?php get_template_part( 'template-parts/homepage/usp-bar' ); ?>

		<?php get_template_part( 'template-parts/homepage/tabbed-products' ); ?>

		<?php get_template_part( 'template-parts/homepage/promo-banner' ); ?>

		<?php get_template_part( 'template-parts/homepage/special-offers' ); ?>

		<?php get_template_part( 'template-parts/homepage/all-products' ); ?>

		<?php get_template_part( 'template-parts/homepage/popular-categories' ); ?>

	</div>

</main>

<?php
get_footer();
