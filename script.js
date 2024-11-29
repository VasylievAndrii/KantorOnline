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

// main page - cryptocurrency
var kursyFiat = kursy.fiat;
var kursyKrypto = kursy.krypto;

document.addEventListener("DOMContentLoaded", function () {
	const usdToPlnRate = kursy.fiat.find(currency => currency.code === "USD").rate;

	kursy.krypto.forEach(function (crypto) {
		const rateInPln = parseFloat(crypto.rate) * usdToPlnRate;

		const priceElement = document.querySelector(`.main__cryptocurrency-price--${crypto.code}`);

		if (priceElement) {
			priceElement.innerText = `${rateInPln.toFixed(2)} PLN`;
		}
	});
});

function updateCryptocurrencyChanges(kursyKrypto) {
	const grouped = kursyKrypto.reduce((acc, item) => {
		if (!acc[item.code]) {
			acc[item.code] = [];
		}
		acc[item.code].push(item);
		return acc;
	}, {});

	Object.keys(grouped).forEach(code => {
		const entries = grouped[code];

		entries.sort((a, b) => {
			const dateA = new Date(`${a.data}T${a.czas}`);
			const dateB = new Date(`${b.data}T${b.czas}`);
			return dateB - dateA;
		});

		if (entries.length >= 2) {
			const latest = entries[0];
			const previous = entries[1];

			const percentageChange =
				((parseFloat(latest.rate) - parseFloat(previous.rate)) / parseFloat(previous.rate)) * 100;

			const cryptoElement = document.querySelector(
				`.main__cryptocurrency-percentage-change--${code}`
			);
			const triangleElement = document.querySelector(`.triangle--${code}`);

			if (cryptoElement) {
				if (percentageChange < 0) {
					cryptoElement.classList.remove("green");
					cryptoElement.classList.add("red");
					triangleElement.classList.remove("triangle--upper");
					triangleElement.classList.add("triangle--lower");
				} else {
					cryptoElement.classList.remove("red");
					cryptoElement.classList.add("green");
					triangleElement.classList.remove("triangle--lower");
					triangleElement.classList.add("triangle--upper");
				}

				const absoluteChange = Math.abs(percentageChange).toFixed(2);
				cryptoElement.innerText = absoluteChange + "%";
			}
		}
	});
}

updateCryptocurrencyChanges(kursyKrypto);
