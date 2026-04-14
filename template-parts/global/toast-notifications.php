<?php
/**
 * Toast notification system
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<div
    x-data="flavorToasts()"
    @toast.window="addToast($event.detail)"
    class="fixed top-4 right-4 z-50 flex flex-col gap-3 w-80 max-w-[calc(100vw-2rem)] pointer-events-none"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            class="pointer-events-auto bg-white rounded-lg shadow-lg overflow-hidden flex items-start gap-3 p-4"
            :class="{
                'border-l-4 border-green-500': toast.type === 'success',
                'border-l-4 border-yellow-500': toast.type === 'warning',
                'border-l-4 border-red-500': toast.type === 'error'
            }"
        >
            <p class="text-sm text-gray-800 flex-1" x-text="toast.message"></p>
            <button @click="removeToast(toast.id)" class="shrink-0 text-gray-400 hover:text-gray-600" aria-label="<?php esc_attr_e( 'Close', 'flavor' ); ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </template>
</div>
