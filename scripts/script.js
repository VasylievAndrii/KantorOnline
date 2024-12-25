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

// header - user menu
function toggleMenu(event) {
	event.preventDefault();
	const dropdown = document.getElementById("userDropdown");
	dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}

window.addEventListener("click", function (e) {
	const isAuthenticated = document.body.dataset.authenticated === "true";
	if (!isAuthenticated) {
		return;
	}

	const dropdown = document.getElementById("userDropdown");
	if (!e.target.closest(".user-menu")) {
		dropdown.style.display = "none";
	}
});
