import '../scss/main.scss';
import initSliders from './module/slider.js';
import initPhoneMask from './module/formatPhone.js';

console.log('Js is working!');

function init() {
	initSliders(); // Инициализация слайдеров
	initPhoneMask(); // Инициализация маски телефона
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', init);
} else {
	init();
}
