document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('header__burger-button')?.addEventListener('click', function() {
		document.querySelector('header')?.classList.toggle('open');
	});
});
