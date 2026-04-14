<?php
/**
 * Orders - Flavor Theme
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$customer_orders = wc_get_orders( array(
    'customer' => get_current_user_id(),
    'limit'    => -1,
    'orderby'  => 'date',
    'order'    => 'DESC',
    'status'   => array_keys( wc_get_order_statuses() ),
    'page'     => max( 1, get_query_var( 'paged' ) ),
    'paginate' => true,
) );

$has_orders = $customer_orders && $customer_orders->orders;

do_action( 'woocommerce_before_account_orders', $has_orders );
?>

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-900"><?php esc_html_e( 'Your Orders', 'flavor' ); ?></h2>
    </div>

    <?php if ( $has_orders ) : ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500"><?php esc_html_e( 'Order', 'flavor' ); ?></th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500"><?php esc_html_e( 'Date', 'flavor' ); ?></th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500"><?php esc_html_e( 'Status', 'flavor' ); ?></th>
                        <th class="px-6 py-3 text-right font-medium text-gray-500"><?php esc_html_e( 'Total', 'flavor' ); ?></th>
                        <th class="px-6 py-3 text-right font-medium text-gray-500"><?php esc_html_e( 'Actions', 'flavor' ); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ( $customer_orders->orders as $order ) :
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
                            <td class="px-6 py-4 text-gray-600">
                                <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo esc_attr( $badge_classes ); ?>">
                                    <?php echo esc_html( wc_get_order_status_name( $status ) ); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-medium">
                                <?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                    <?php esc_html_e( 'View', 'flavor' ); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ( $customer_orders->max_num_pages > 1 ) : ?>
            <div class="p-6 border-t border-gray-100">
                <?php
                echo paginate_links( array(
                    'base'    => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
                    'format'  => '',
                    'current' => max( 1, get_query_var( 'paged' ) ),
                    'total'   => $customer_orders->max_num_pages,
                    'type'    => 'list',
                ) );
                ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <div class="p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-1"><?php esc_html_e( 'No orders yet', 'flavor' ); ?></h3>
            <p class="text-gray-500 mb-6"><?php esc_html_e( 'Browse our products and place your first order.', 'flavor' ); ?></p>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
               class="inline-flex items-center px-6 py-3 bg-[var(--color-primary,#E15726)] text-white font-semibold rounded-lg hover:opacity-90 transition-opacity">
                <?php esc_html_e( 'Start Shopping', 'flavor' ); ?>
            </a>
        </div>
    <?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
