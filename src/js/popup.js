$(document).ready(function () {
	// Применяем маску к полю ввода телефона
	$('.reg__phone').inputmask({
		mask: '+7 (999) 999-99-99', // Маска для российского номера телефона
		placeholder: ' ', // Символ заполнителя
		showMaskOnHover: false, // Показывать маску при наведении
		showMaskOnFocus: true, // Показывать маску при фокусе
	});
});
// АВТОРИЗАЦИЯ
const authBtn = document.querySelector('.userAuth');
const authPopup = document.querySelector('.auth');
const closeAuth = document.querySelector('.closeAuth');

if (authBtn) {
	authBtn.onclick = function () {
		authPopup.classList.remove('none');
	};
}

if (closeAuth) {
	closeAuth.onclick = function () {
		alert('Вы не авторизированы, вам недоступен личный кабинет.');
		history.go(-1);
	};
}

// РЕГИСТРАЦИЯ
const regBtn = document.querySelector('.reg-btn');
const regPopup = document.querySelector('.reg');
const closeReg = document.querySelector('.closeReg');

if (regBtn) {
	regBtn.onclick = function (event) {
		event.preventDefault();
		regPopup.classList.remove('none');
		if (authPopup) {
			authPopup.className = 'auth popup none';
		}
	};
}

if (closeReg) {
	closeReg.onclick = function () {
		alert('Вы не авторизированы, вам недоступен личный кабинет.');
		history.go(-1);
	};
}
