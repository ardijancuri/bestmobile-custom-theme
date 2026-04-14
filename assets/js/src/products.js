/**
 * Products — AJAX loading, tab switching, infinite scroll, wishlist, skeleton management
 *
 * @package Flavor
 */

(function () {
	'use strict';

	// Wishlist toggle (AJAX)
	document.addEventListener('click', function (e) {
		const btn = e.target.closest('.flavor-wishlist-toggle');
		if (!btn) return;

		e.preventDefault();
		const productId = btn.dataset.productId;
		if (!productId) return;

		const icon = btn.querySelector('.wishlist-icon');
		const isFilled = icon.getAttribute('fill') === 'currentColor';

		// Toggle visual state immediately
		if (isFilled) {
			icon.setAttribute('fill', 'none');
			icon.classList.remove('text-red');
			icon.classList.add('text-gray-400');
		} else {
			icon.setAttribute('fill', 'currentColor');
			icon.classList.add('text-red');
			icon.classList.remove('text-gray-400');
		}

		// Send AJAX request
		const ajax = window.flavorAjax || window.flavorData;
		if (!ajax) return;

		const data = new FormData();
		data.append('action', 'flavor_toggle_wishlist');
		data.append('nonce', ajax.nonce);
		data.append('product_id', productId);

		fetch(ajax.url || ajax.ajaxUrl, { method: 'POST', body: data }).catch(() => {
			// Revert on error
			if (isFilled) {
				icon.setAttribute('fill', 'currentColor');
				icon.classList.add('text-red');
				icon.classList.remove('text-gray-400');
			} else {
				icon.setAttribute('fill', 'none');
				icon.classList.remove('text-red');
				icon.classList.add('text-gray-400');
			}
		});
	});
})();
