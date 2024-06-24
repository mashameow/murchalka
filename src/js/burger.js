const menuBtn = document.querySelector('.header__burger');
const menu = document.querySelector('.header__nav-mobile');
const modileLinks = document.querySelectorAll('.header__nav-mobile-menu-link');

menuBtn.addEventListener('click', () => {
	menuBtn.classList.toggle('active');
	if (!menuBtn.classList.contains('active')) {
		menu.classList.remove('show');
	} else {
		menu.classList.add('show');
	}
});

modileLinks.forEach(link => {
	link.addEventListener('click', () => {
		menuBtn.classList.remove('active');
		menu.classList.remove('show');
	});
});
