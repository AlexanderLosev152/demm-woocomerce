import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

/**
 * Инициализация слайдеров Swiper.
 *
 * Элементы навигации и пагинация ищутся внутри каждого слайдера,
 * дополнительных классов не требуется — достаточно, чтобы у контейнера
 * был класс `swiper`, а у элементов — стандартные классы Swiper.
 *
 * Разметка:
 * <div class="hero swiper">
 *   <div class="hero__swiper swiper-wrapper">
 *     <div class="hero__slide swiper-slide">...</div>
 *   </div>
 *   <div class="hero__pagination swiper-pagination"></div>
 *   <button class="swiper-button-prev"></button>
 *   <button class="swiper-button-next"></button>
 * </div>
 *
 * @param {string} selector Селектор контейнеров слайдера.
 * @param {object} options  Параметры, переопределяющие значения по умолчанию.
 * @returns {Swiper[]} Список созданных экземпляров Swiper.
 */
export default function initSliders(selector = '.swiper', options = {}) {
	return [
		...document.querySelectorAll(`${selector}:not(.swiper-initialized)`)
	].map((el) => {
		const pagination = el.querySelector('.swiper-pagination');
		const nextEl = el.querySelector('.swiper-button-next');
		const prevEl = el.querySelector('.swiper-button-prev');

		const config = {
			modules: [Navigation, Pagination, Autoplay],

			slidesPerView: 1,
			spaceBetween: 0,

			autoplay: {
				delay: 4000,
				disableOnInteraction: false
			},

			...options
		};

		// Важно: не передавать ключ со значением `undefined` — Swiper глубоко
		// мёржит параметры, и `undefined` затирает дефолты модуля, из-за чего
		// в его обработчике `init` падает обращение к `params.<module>.enabled`.
		if (pagination) {
			config.pagination = {
				el: pagination,
				clickable: true
			};
		}

		if (nextEl && prevEl) {
			config.navigation = {
				nextEl,
				prevEl
			};
		}

		return new Swiper(el, config);
	});
}
