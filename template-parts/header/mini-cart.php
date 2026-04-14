<?php
/**
 * Mini Cart — Slide-out panel
 *
 * @package flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<div x-data="{ open: false }"
	 x-on:open-mini-cart.window="open = true"
	 x-on:keydown.escape.window="open = false"
	 class="relative z-50">

	<!-- Overlay -->
	<div x-show="open" x-cloak
		 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
		 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
		 @click="open = false"
		 class="fixed inset-0 bg-black/40"></div>

	<!-- Panel -->
	<div x-show="open" x-cloak
		 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
		 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
		 class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col">

		<!-- Header -->
		<div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
			<h2 class="text-lg font-bold"><?php esc_html_e( 'Your Cart', 'flavor' ); ?>
				<span class="text-sm font-normal text-gray-500 ml-1">(<span class="mini-cart-count"><?php echo absint( WC()->cart->get_cart_contents_count() ); ?></span>)</span>
			</h2>
			<button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors" aria-label="<?php esc_attr_e( 'Close', 'flavor' ); ?>">
				<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
			</button>
		</div>

		<!-- Items -->
		<div class="flex-1 overflow-y-auto px-6 py-4 mini-cart-items">
			<?php echo flavor_get_mini_cart_items_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<!-- Footer -->
		<div class="mini-cart-footer border-t border-gray-200 px-6 py-4 space-y-3<?php echo WC()->cart->is_empty() ? ' hidden' : ''; ?>">
			<?php echo flavor_get_mini_cart_footer_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</div>
</div>

<script>
function flavorApplyMiniCart(data) {
	if (!data) return;

	var count = Number(data.count) || 0;
	var itemsWrap = document.querySelector('.mini-cart-items');
	if (itemsWrap && data.items_html !== undefined) {
		itemsWrap.innerHTML = data.items_html;
	}

	var footerWrap = document.querySelector('.mini-cart-footer');
	if (footerWrap) {
		var footerHtml = typeof data.footer_html === 'string' ? data.footer_html : '';
		footerWrap.innerHTML = footerHtml;
		footerWrap.classList.toggle('hidden', footerHtml.trim() === '');
	}

	document.querySelectorAll('.cart-count').forEach(function(el) {
		el.textContent = count;
		el.classList.toggle('hidden', count < 1);
	});

	var miniCount = document.querySelector('.mini-cart-count');
	if (miniCount) {
		miniCount.textContent = count;
	}
}

window.flavorApplyMiniCart = flavorApplyMiniCart;

function flavorMiniCartUpdate(action, data) {
	const fd = new FormData();
	fd.append('action', action);
	fd.append('nonce', (window.flavorData || {}).nonce || '');
	Object.keys(data).forEach(k => fd.append(k, data[k]));
	return fetch((window.flavorData || {}).ajaxUrl || '/wp-admin/admin-ajax.php', { method: 'POST', body: fd })
		.then(r => r.json())
		.then(res => {
			if (!res.success || !res.data) return null;
			flavorApplyMiniCart(res.data);
			return res.data;
		});
}

window.flavorRefreshMiniCart = function() {
	return flavorMiniCartUpdate('flavor_get_mini_cart', {});
};

function flavorMiniCartRemove(cartKey) {
	var row = document.querySelector('[data-cart-key="' + cartKey + '"]');
	if (row) { row.style.transition = 'opacity 0.2s, max-height 0.3s'; row.style.opacity = '0'; }
	setTimeout(function() {
		flavorMiniCartUpdate('flavor_mini_cart_remove', { cart_key: cartKey });
	}, 200);
}
function flavorMiniCartQty(cartKey, qty) {
	if (qty < 1) { flavorMiniCartRemove(cartKey); return; }
	flavorMiniCartUpdate('flavor_mini_cart_qty', { cart_key: cartKey, quantity: qty });
}
</script>
