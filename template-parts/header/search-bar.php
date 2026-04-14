<?php
/**
 * Search Bar - AJAX Live Search
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<div x-data="flavorSearch()" class="relative w-full" @click.outside="showResults = false">
    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="relative" @submit.prevent="goToResults()">
        <input
            type="search"
            name="s"
            x-model="query"
            @input.debounce.300ms="search()"
            @focus="query.length >= 2 && (showResults = true)"
            placeholder="<?php esc_attr_e( 'Search products...', 'flavor' ); ?>"
            autocomplete="off"
            class="w-full bg-white rounded-full pl-10 pr-4 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-transparent border border-gray-200"
        >
        <input type="hidden" name="post_type" value="product">
        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2" aria-label="<?php esc_attr_e( 'Search', 'flavor' ); ?>">
            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
        <!-- Loading spinner -->
        <div x-show="loading" class="absolute right-3 top-1/2 -translate-y-1/2">
            <svg class="animate-spin w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>
    </form>

    <!-- Results Dropdown -->
    <div
        x-show="showResults && results.length > 0"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden z-50"
    >
        <ul class="divide-y divide-gray-50">
            <template x-for="item in results" :key="item.id">
                <li>
                    <a :href="item.url" class="flex items-center gap-3 p-3 hover:bg-gray-50 transition-colors">
                        <img :src="item.image" :alt="item.name" class="w-10 h-10 object-cover rounded flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate" x-text="item.name"></p>
                            <p class="text-sm text-primary font-semibold [&_del]:line-through [&_del]:text-gray-400 [&_del]:font-normal [&_del]:mr-1 [&_ins]:no-underline [&_ins]:text-primary" x-html="item.price"></p>
                        </div>
                    </a>
                </li>
            </template>
        </ul>
        <a
            :href="'<?php echo esc_url( home_url( '/?s=' ) ); ?>' + encodeURIComponent(query) + '&post_type=product'"
            class="block text-center py-3 text-sm font-medium text-primary hover:bg-gray-50 border-t border-gray-100"
        >
            <?php esc_html_e( 'See all results', 'flavor' ); ?>
        </a>
    </div>

    <!-- No results -->
    <div
        x-show="showResults && results.length === 0 && query.length >= 2 && !loading"
        x-cloak
        class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-xl border border-gray-100 p-4 z-50"
    >
        <p class="text-sm text-gray-500 text-center"><?php esc_html_e( 'No products found.', 'flavor' ); ?></p>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('flavorSearch', () => ({
        query: '',
        results: [],
        showResults: false,
        loading: false,

        search() {
            if (this.query.length < 2) {
                this.results = [];
                this.showResults = false;
                return;
            }

            this.loading = true;
            const formData = new FormData();
            formData.append('action', 'flavor_live_search');
            formData.append('nonce', flavorData.nonce);
            formData.append('query', this.query);

            fetch(flavorData.ajaxUrl, {
                method: 'POST',
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.results = data.data.slice(0, 5);
                }
                this.showResults = true;
                this.loading = false;
            })
            .catch(() => {
                this.loading = false;
            });
        },

        goToResults() {
            if (this.query.length > 0) {
                window.location.href = flavorData.homeUrl + '?s=' + encodeURIComponent(this.query) + '&post_type=product';
            }
        }
    }));
});
</script>
