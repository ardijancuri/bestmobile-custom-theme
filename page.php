<?php
/**
 * Default Page Template
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
	?>
		<div class="container-site py-8">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</main>

<?php
get_footer();
