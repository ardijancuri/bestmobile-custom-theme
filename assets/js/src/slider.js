/**
 * Hero Slider — Swiper initialization with thumbnail sync
 *
 * @package Flavor
 */

(function () {
	'use strict';

	function initHeroSlider() {
		const sliderEl = document.getElementById('heroSlider');
		const thumbsEl = document.getElementById('heroThumbs');

		if (!sliderEl || typeof Swiper === 'undefined') return;

		let thumbsSwiper = null;

		// Initialize thumbnails first
		if (thumbsEl) {
			thumbsSwiper = new Swiper(thumbsEl, {
				spaceBetween: 8,
				slidesPerView: 'auto',
				freeMode: true,
				watchSlidesProgress: true,
			});
		}

		// Initialize main slider
		const heroSwiper = new Swiper(sliderEl, {
			spaceBetween: 0,
			loop: true,
			autoplay: {
				delay: 5000,
				disableOnInteraction: false,
			},
			pagination: {
				el: sliderEl.querySelector('.swiper-pagination'),
				clickable: true,
			},
			navigation: {
				nextEl: sliderEl.querySelector('.swiper-button-next'),
				prevEl: sliderEl.querySelector('.swiper-button-prev'),
			},
			thumbs: thumbsSwiper ? { swiper: thumbsSwiper } : undefined,
			on: {
				slideChange: function () {
					if (!thumbsSwiper) return;
					// Highlight active thumbnail
					const slides = thumbsSwiper.slides;
					slides.forEach((slide, i) => {
						const img = slide.querySelector('img');
						if (!img) return;
						if (i === this.realIndex) {
							img.classList.remove('opacity-50');
							img.classList.add('opacity-100');
						} else {
							img.classList.remove('opacity-100');
							img.classList.add('opacity-50');
						}
					});
				},
			},
		});

		// Set initial active thumb
		if (thumbsSwiper && thumbsSwiper.slides[0]) {
			const img = thumbsSwiper.slides[0].querySelector('img');
			if (img) {
				img.classList.remove('opacity-50');
				img.classList.add('opacity-100');
			}
		}
	}

	// Init on DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initHeroSlider);
	} else {
		initHeroSlider();
	}
})();
