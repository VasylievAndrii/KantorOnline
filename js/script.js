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

// main - cryptocurrency-content-page
const containerCryptocurrency = document.querySelector(".main__cryptocurrency-content-page");
const cryptocurrencies = [
	{ name: "Bitcoin", code: "BTC", logo: "bitcoin-logo.png" },
	{ name: "Ethereum", code: "ETH", logo: "ethereum-logo.png" },
	{ name: "Litecoin", code: "LTC", logo: "litecoin-logo.png" },
	{ name: "XRP", code: "XRP", logo: "xrp-logo.png" },
	{ name: "Bitcoin cash", code: "BCH", logo: "bitcoin-cash-logo.png" },
];

function generateCryptocurrencyHTML(crypto) {
	return `
		<div class="main__cryptocurrency">
			<div class="main__cryptocurrency-header">
				<img src="images/${crypto.logo}" alt="${crypto.name} logo" class="main__cryptocurrency-logo">
				<p class="main__cryptocurrency-name">${crypto.name}</p>
				<p class="main__cryptocurrency-subname">${crypto.code}</p>
			</div>
			<div class="main__cryptocurrency-footer">
				<p class="main__cryptocurrency-price main__cryptocurrency-price--${crypto.code}"></p>
				<span class="triangle triangle--${crypto.code}"></span>
				<p class="main__cryptocurrency-percentage-change main__cryptocurrency-percentage-change--${crypto.code}"></p>
			</div>
		</div>
	`;
}

cryptocurrencies.forEach(crypto => {
	containerCryptocurrency.innerHTML += generateCryptocurrencyHTML(crypto);
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

function processCryptocurrencyData(kursy) {
	const kursyFiat = kursy.fiat;
	const kursyKrypto = kursy.krypto;

	const usdToPlnRate = kursyFiat.find(currency => currency.code === "USD").rate;

	kursyKrypto.forEach(function (crypto) {
		const rateInPln = parseFloat(crypto.rate) * usdToPlnRate;
		const priceElement = document.querySelector(`.main__cryptocurrency-price--${crypto.code}`);

		if (priceElement) {
			priceElement.innerText = `${rateInPln.toFixed(2)} PLN`;
		}
	});

	updateCryptocurrencyChanges(kursyKrypto);
}

fetch("./databases/fetch_data.php")
	.then(response => response.json())
	.then(data => {
		processCryptocurrencyData(data);
	});
