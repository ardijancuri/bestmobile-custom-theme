<?php
/**
 * Shipping estimate — fixed 2–3 business day delivery window
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_timestamp = current_time( 'timestamp' );

$get_business_day_timestamp = static function ( $business_days ) use ( $current_timestamp ) {
	$timestamp = $current_timestamp;
	$added     = 0;

	while ( $added < $business_days ) {
		$timestamp += DAY_IN_SECONDS;

		if ( (int) wp_date( 'N', $timestamp ) < 6 ) {
			++$added;
		}
	}

	return $timestamp;
};

$delivery_from = wp_date( 'M j', $get_business_day_timestamp( 2 ) );
$delivery_to   = wp_date( 'M j', $get_business_day_timestamp( 3 ) );
?>

<div class="border border-gray-200 rounded-lg p-4 mt-4">
	<div class="flex items-center gap-2 mb-3">
		<svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
		<span class="text-sm font-medium text-gray-900"><?php esc_html_e( 'Delivery Estimate', 'flavor' ); ?></span>
	</div>

	<div class="flex items-center gap-2 text-sm">
		<svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
		<span class="text-gray-700">
			<?php
			printf(
				esc_html__( 'Estimated delivery in 2–3 business days: %1$s – %2$s', 'flavor' ),
				esc_html( $delivery_from ),
				esc_html( $delivery_to )
			);
			?>
		</span>
	</div>
</div>
