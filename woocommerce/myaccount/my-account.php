<?php
/**
 * My Account — Sidebar Nav Wrapper
 *
 * @package flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="max-w-7xl mx-auto px-4 py-8">
	<h1 class="text-2xl md:text-3xl font-bold mb-8"><?php esc_html_e( 'My Account', 'flavor' ); ?></h1>

	<div class="lg:grid lg:grid-cols-4 lg:gap-8">
		<!-- Sidebar Navigation -->
		<aside class="mb-8 lg:mb-0">
			<nav class="bg-white rounded-xl border border-gray-200 overflow-hidden sticky top-24">
				<?php
				$menu_items = wc_get_account_menu_items();
				$current    = WC()->query->get_current_endpoint();
				foreach ( $menu_items as $endpoint => $label ) :
					$is_active = ( $endpoint === $current ) || ( ! $current && $endpoint === 'dashboard' );
					$icon = '';
					switch ( $endpoint ) {
						case 'dashboard':
							$icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>';
							break;
						case 'orders':
							$icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>';
							break;
						case 'downloads':
							$icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>';
							break;
						case 'edit-address':
							$icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>';
							break;
						case 'edit-account':
							$icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>';
							break;
						case 'customer-logout':
							$icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>';
							break;
						default:
							$icon = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>';
					}
				?>
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
						class="flex items-center gap-3 px-5 py-3.5 text-sm font-medium border-b border-gray-100 last:border-0 transition-colors <?php echo $is_active ? 'bg-orange-50 text-[var(--color-primary,#E15726)] border-l-2 border-l-[var(--color-primary,#E15726)]' : 'text-gray-700 hover:bg-gray-50'; ?>">
						<svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><?php echo $icon; // phpcs:ignore ?></svg>
						<?php echo esc_html( $label ); ?>
					</a>
				<?php endforeach; ?>
			</nav>
		</aside>

		<!-- Content -->
		<div class="lg:col-span-3">
			<?php do_action( 'woocommerce_account_content' ); ?>
		</div>
	</div>
</div>
