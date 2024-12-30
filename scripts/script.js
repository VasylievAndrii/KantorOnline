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
	event.stopPropagation();
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

// Doładuj / Wypłać
function openModal() {
	document.getElementById("modal").style.display = "flex";
}

function closeModal() {
	document.getElementById("modal").style.display = "none";
}

function setAction(action) {
	document.getElementById("action").value = action;
}

function switchModalTab(tab) {
	const tabs = document.querySelectorAll(".modal-tab");
	tabs.forEach(t => t.classList.remove("active"));

	const tabContents = document.querySelectorAll(".modal-tab-content");
	tabContents.forEach(tc => tc.classList.remove("active"));

	document.querySelector(`.modal-tab[data-tab="${tab}"]`).classList.add("active");
	document.getElementById(tab).classList.add("active");
}

function handleModalTransaction(event, action) {
	event.preventDefault();
	const amount =
		action === "deposit"
			? parseFloat(document.getElementById("depositAmount").value)
			: parseFloat(document.getElementById("withdrawAmount").value);

	if (!amount || amount <= 0) {
		alert("Wprowadź prawidłową kwotę");
		return;
	}

	fetch("./databases/update_balance.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({ action, amount }),
	})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				location.reload();
			} else {
				alert(data.message || "Wystąpił błąd");
			}
		})
		.catch(error => {
			console.error("Błąd:", error);
			alert("Wystąpił błąd podczas przetwarzania transakcji");
		});

	closeModal();
}

const dropdownItems = document.querySelectorAll("#userDropdown .dropdown-item");

dropdownItems.forEach(item => {
	item.addEventListener("click", function () {
		const dropdown = document.getElementById("userDropdown");
		dropdown.style.display = "none";
	});
});
