// header - hambuger menu
const navEl = document.querySelector(".nav");
const navItemEls = document.querySelectorAll(".nav__item");
const hamburgerEl = document.querySelector(".hamburger");

hamburgerEl.addEventListener("click", () => {
	navEl.classList.toggle("nav--open");
	hamburgerEl.classList.toggle("hamburger--open");
});

navItemEls.forEach(navItemEl => {
	navItemEl.addEventListener("click", () => {
		navEl.classList.remove("nav--open");
		hamburgerEl.classList.remove("hamburger--open");
	});
});
