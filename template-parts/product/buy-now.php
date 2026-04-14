<?php
/**
 * Buy Now — hidden form that adds to cart and redirects to checkout
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>

<form id="flavor-buy-now-form" method="post" action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" style="display:none;">
	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>">
	<input type="hidden" name="quantity" value="1" id="flavor-buy-now-qty">
	<?php wp_nonce_field( 'flavor_buy_now', 'flavor_buy_now_nonce' ); ?>
</form>

<script>
	document.addEventListener('alpine:init', () => {
		/* Buy-now redirect is handled via JS in product-page.js */
	});
</script>
