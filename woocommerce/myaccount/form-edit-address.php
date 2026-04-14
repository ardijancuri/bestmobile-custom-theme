<?php
/**
 * Edit Address Form - Flavor Theme
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
    $get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
        'billing'  => __( 'Billing address', 'flavor' ),
        'shipping' => __( 'Shipping address', 'flavor' ),
    ), $customer_id );
} else {
    $get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
        'billing' => __( 'Billing address', 'flavor' ),
    ), $customer_id );
}

$oldcol = 1;
$col    = 1;
?>

<?php if ( ! $load_address ) : ?>

    <?php do_action( 'woocommerce_before_edit_account_address_form' ); ?>

    <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-900"><?php esc_html_e( 'Your Addresses', 'flavor' ); ?></h2>
        <p class="text-gray-500"><?php esc_html_e( 'The following addresses will be used on the checkout page by default.', 'flavor' ); ?></p>

        <div class="grid gap-6 md:grid-cols-2">
            <?php foreach ( $get_addresses as $name => $address_title ) :
                $address = wc_get_account_formatted_address( $name );
                $col     = $col + 1;
            ?>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900"><?php echo esc_html( $address_title ); ?></h3>
                        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>"
                           class="inline-flex items-center gap-1 text-sm font-medium text-[var(--color-primary,#E15726)] hover:underline">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                            <?php esc_html_e( 'Edit', 'flavor' ); ?>
                        </a>
                    </div>

                    <?php if ( $address ) : ?>
                        <address class="text-gray-600 not-italic leading-relaxed">
                            <?php echo wp_kses_post( $address ); ?>
                        </address>
                    <?php else : ?>
                        <p class="text-gray-400 italic"><?php esc_html_e( 'You have not set up this address yet.', 'flavor' ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>

<?php else : ?>

    <?php do_action( 'woocommerce_before_edit_address_form_' . $load_address ); ?>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 lg:p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">
            <?php echo 'billing' === $load_address ? esc_html__( 'Billing Address', 'flavor' ) : esc_html__( 'Shipping Address', 'flavor' ); ?>
        </h2>

        <form method="post" class="space-y-5">

            <?php do_action( 'woocommerce_before_edit_address_form_fields_' . $load_address ); ?>

            <div class="grid gap-5 sm:grid-cols-2">
                <?php
                $address_fields = WC()->countries->get_address_fields( '', $load_address . '_' );
                foreach ( $address_fields as $key => $field ) {
                    $field['return'] = false;
                    woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ?? '' ) );
                }
                ?>
            </div>

            <?php do_action( 'woocommerce_after_edit_address_form_fields_' . $load_address ); ?>

            <?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
            <input type="hidden" name="action" value="edit_address" />
            <input type="hidden" name="save_address" value="<?php echo esc_attr( $load_address ); ?>" />

            <button type="submit"
                    class="px-8 py-3 bg-[var(--color-primary,#E15726)] text-white font-semibold rounded-lg hover:opacity-90 transition-opacity">
                <?php esc_html_e( 'Save address', 'flavor' ); ?>
            </button>

        </form>
    </div>

    <?php do_action( 'woocommerce_after_edit_address_form_' . $load_address ); ?>

<?php endif; ?>
