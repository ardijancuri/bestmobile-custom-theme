<?php
/**
 * Page Skeleton — Full page loading placeholder
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$type = $args['type'] ?? 'default';
?>

<?php if ( 'shop' === $type ) : ?>
	<!-- Shop page skeleton -->
	<div class="animate-pulse">
		<div class="h-5 bg-gray-200 rounded w-48 mb-4"></div>
		<div class="h-10 bg-gray-200 rounded w-full mb-6"></div>
		<div class="grid grid-cols-2 tablet-sm:grid-cols-3 md:grid-cols-4 gap-4">
			<?php for ( $i = 0; $i < 8; $i++ ) : ?>
				<?php get_template_part( 'template-parts/product/product-card-skeleton' ); ?>
			<?php endfor; ?>
		</div>
	</div>

<?php elseif ( 'product' === $type ) : ?>
	<!-- Single product skeleton -->
	<div class="animate-pulse flex flex-col lg:flex-row gap-8 mt-4">
		<div class="w-full lg:w-1/2">
			<div class="aspect-square bg-gray-200 rounded-lg"></div>
			<div class="flex gap-2 mt-3">
				<?php for ( $i = 0; $i < 4; $i++ ) : ?>
					<div class="w-16 h-16 bg-gray-200 rounded"></div>
				<?php endfor; ?>
			</div>
		</div>
		<div class="w-full lg:w-1/2 space-y-4">
			<div class="h-6 bg-gray-200 rounded w-3/4"></div>
			<div class="h-4 bg-gray-200 rounded w-1/2"></div>
			<div class="h-8 bg-gray-200 rounded w-1/3"></div>
			<div class="h-4 bg-gray-200 rounded w-full"></div>
			<div class="h-4 bg-gray-200 rounded w-full"></div>
			<div class="h-4 bg-gray-200 rounded w-2/3"></div>
			<div class="h-12 bg-gray-200 rounded w-full mt-4"></div>
		</div>
	</div>

<?php elseif ( 'cart' === $type ) : ?>
	<!-- Cart skeleton -->
	<div class="animate-pulse space-y-4 mt-4">
		<?php for ( $i = 0; $i < 3; $i++ ) : ?>
			<div class="flex items-center gap-4 p-4 bg-white rounded-lg border border-gray-200">
				<div class="w-20 h-20 bg-gray-200 rounded flex-shrink-0"></div>
				<div class="flex-1 space-y-2">
					<div class="h-4 bg-gray-200 rounded w-3/4"></div>
					<div class="h-3 bg-gray-200 rounded w-1/2"></div>
				</div>
				<div class="h-5 bg-gray-200 rounded w-16"></div>
			</div>
		<?php endfor; ?>
		<div class="h-12 bg-gray-200 rounded w-full mt-6"></div>
	</div>

<?php elseif ( 'account' === $type ) : ?>
	<!-- Account skeleton -->
	<div class="animate-pulse space-y-4 mt-4">
		<div class="h-6 bg-gray-200 rounded w-48 mb-6"></div>
		<div class="flex flex-col md:flex-row gap-6">
			<div class="w-full md:w-1/4 space-y-3">
				<?php for ( $i = 0; $i < 5; $i++ ) : ?>
					<div class="h-10 bg-gray-200 rounded"></div>
				<?php endfor; ?>
			</div>
			<div class="flex-1 space-y-4">
				<div class="h-4 bg-gray-200 rounded w-full"></div>
				<div class="h-4 bg-gray-200 rounded w-3/4"></div>
				<div class="h-4 bg-gray-200 rounded w-1/2"></div>
			</div>
		</div>
	</div>

<?php else : ?>
	<!-- Default page skeleton -->
	<div class="animate-pulse space-y-4 mt-4">
		<div class="h-6 bg-gray-200 rounded w-64 mb-4"></div>
		<div class="h-4 bg-gray-200 rounded w-full"></div>
		<div class="h-4 bg-gray-200 rounded w-full"></div>
		<div class="h-4 bg-gray-200 rounded w-3/4"></div>
		<div class="h-4 bg-gray-200 rounded w-1/2"></div>
	</div>
<?php endif; ?>
