/**
 * Toast notification Alpine.js component
 *
 * Usage: dispatch a custom event to show a toast:
 *   window.dispatchEvent(new CustomEvent('toast', {
 *       detail: { message: 'Item added to cart!', type: 'success' }
 *   }));
 *
 * Types: 'success' (green), 'warning' (yellow), 'error' (red)
 *
 * @package Flavor
 */

function flavorToasts() {
    return {
        toasts: [],

        addToast(detail) {
            const id = Date.now();
            this.toasts.push({
                id,
                message: detail.message,
                type: detail.type || 'success',
            });
            setTimeout(() => this.removeToast(id), 4000);
        },

        removeToast(id) {
            this.toasts = this.toasts.filter((t) => t.id !== id);
        },
    };
}
