<?php
/**
 * My Account Dashboard - Flavor Theme
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();

// Get recent orders
$customer_orders = wc_get_orders( array(
    'customer' => $current_user->ID,
    'limit'    => 3,
    'orderby'  => 'date',
    'order'    => 'DESC',
    'status'   => array_keys( wc_get_order_statuses() ),
) );
?>

<?php do_action( 'woocommerce_account_dashboard' ); ?>

<div class="space-y-8">

    <!-- Welcome -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-2xl font-bold text-gray-900">
            <?php printf( esc_html__( 'Welcome back, %s!', 'flavor' ), esc_html( $current_user->display_name ) ); ?>
        </h2>
        <p class="mt-1 text-gray-500">
            <?php esc_html_e( 'From your account dashboard you can view your recent orders, manage your addresses and edit your account details.', 'flavor' ); ?>
        </p>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900"><?php esc_html_e( 'Recent Orders', 'flavor' ); ?></h3>
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="text-sm font-medium text-[var(--color-primary,#E15726)] hover:underline">
                <?php esc_html_e( 'View All', 'flavor' ); ?>
            </a>
        </div>

        <?php if ( $customer_orders ) : ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium text-gray-500"><?php esc_html_e( 'Order', 'flavor' ); ?></th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500"><?php esc_html_e( 'Date', 'flavor' ); ?></th>
                            <th class="px-6 py-3 text-left font-medium text-gray-500"><?php esc_html_e( 'Status', 'flavor' ); ?></th>
                            <th class="px-6 py-3 text-right font-medium text-gray-500"><?php esc_html_e( 'Total', 'flavor' ); ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ( $customer_orders as $order ) :
                            $status = $order->get_status();
                            $badge_classes = match( $status ) {
                                'completed' => 'bg-green-100 text-green-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'on-hold' => 'bg-yellow-100 text-yellow-800',
                                'cancelled', 'failed', 'refunded' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="font-medium text-[var(--color-primary,#E15726)] hover:underline">
                                        #<?php echo esc_html( $order->get_order_number() ); ?>
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo esc_attr( $badge_classes ); ?>">
                                        <?php echo esc_html( wc_get_order_status_name( $status ) ); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="p-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                <p><?php esc_html_e( 'No orders yet.', 'flavor' ); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <?php
        $quick_links = array(
            array(
                'url'   => wc_get_account_endpoint_url( 'orders' ),
                'label' => __( 'Orders', 'flavor' ),
                'icon'  => '<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>',
            ),
            array(
                'url'   => wc_get_account_endpoint_url( 'edit-address' ),
                'label' => __( 'Addresses', 'flavor' ),
                'icon'  => '<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>',
            ),
            array(
                'url'   => wc_get_account_endpoint_url( 'edit-account' ),
                'label' => __( 'Account Details', 'flavor' ),
                'icon'  => '<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>',
            ),
            array(
                'url'   => wc_get_account_endpoint_url( 'wishlist' ),
                'label' => __( 'Wishlist', 'flavor' ),
                'icon'  => '<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>',
            ),
            array(
                'url'   => wc_logout_url(),
                'label' => __( 'Logout', 'flavor' ),
                'icon'  => '<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/></svg>',
            ),
        );

        foreach ( $quick_links as $link ) : ?>
            <a href="<?php echo esc_url( $link['url'] ); ?>"
               class="flex flex-col items-center gap-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:border-[var(--color-primary,#E15726)] hover:shadow-md transition-all group">
                <span class="text-gray-400 group-hover:text-[var(--color-primary,#E15726)] transition-colors">
                    <?php echo $link['icon']; // phpcs:ignore WordPress.Security.EscapeOutput ?>
                </span>
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900"><?php echo esc_html( $link['label'] ); ?></span>
            </a>
        <?php endforeach; ?>
    </div>

</div>
