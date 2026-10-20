export default function initPhoneMask() {
	const phoneInput = document.getElementById('phone-input');
	if (!phoneInput) return;
	phoneInput.addEventListener('input', function (e) {
		let digits = this.value.replace(/\D/g, '');
		if (digits.length === 0) {
			this.value = '';
			return;
		}
		if (digits.startsWith('7') || digits.startsWith('8')) {
			digits = digits.substring(1);
		}
		digits = digits.substring(0, 10);
		let result = '+7';
		if (digits.length > 0) result += ' (' + digits.substring(0, 3);
		if (digits.length >= 3) result += ') ' + digits.substring(3, 6);
		if (digits.length >= 6) result += ' ' + digits.substring(6, 10);

		this.value = result;
	});
	phoneInput.addEventListener('keydown', function (e) {
		if (e.key === 'Backspace' && this.selectionStart <= 3) {
			e.preventDefault();
		}
	});
	phoneInput.addEventListener('keypress', function (e) {
		if (!/[0-9]/.test(e.key) && e.key !== 'Enter' && e.key !== 'Tab') {
			e.preventDefault();
		}
	});
}
