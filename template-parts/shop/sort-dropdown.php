<?php
/**
 * Sort dropdown for shop page
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="flex items-center gap-2">
	<label for="flavor-sort" class="text-sm text-gray-600 hidden md:inline"><?php esc_html_e( 'Sort by:', 'flavor' ); ?></label>
	<select
		id="flavor-sort"
		x-model="sortBy"
		@change="loadProducts(1)"
		class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:border-primary focus:outline-none cursor-pointer"
	>
		<option value="relevance"><?php esc_html_e( 'Relevance', 'flavor' ); ?></option>
		<option value="price_asc"><?php esc_html_e( 'Price: Low → High', 'flavor' ); ?></option>
		<option value="price_desc"><?php esc_html_e( 'Price: High → Low', 'flavor' ); ?></option>
		<option value="newest"><?php esc_html_e( 'Newest', 'flavor' ); ?></option>
		<option value="discount"><?php esc_html_e( 'Highest Discount %', 'flavor' ); ?></option>
	</select>
</div>
