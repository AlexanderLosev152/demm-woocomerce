import '../scss/main.scss';
import initSliders from './module/slider.js';

console.log('Js is working!');

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', () => initSliders());
} else {
	initSliders();
}
