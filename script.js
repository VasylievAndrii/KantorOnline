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
var latestPrice = prices[0];
var previousPrice = prices[1];

function calculatePercentageChange(newPrice, oldPrice) {
	return ((newPrice - oldPrice) / oldPrice) * 100;
}

function updateCryptocurrencyChanges(latestPrice, previousPrice) {
	Object.keys(latestPrice).forEach(function (crypto) {
		var percentageChange = calculatePercentageChange(latestPrice[crypto], previousPrice[crypto]);

		var cryptoElement = document.querySelector(
			`.main__cryptocurrency-percentage-change--${crypto}`
		);
		var triangleElement = document.querySelector(`.triangle--${crypto}`);

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

			var absoluteChange = Math.abs(percentageChange).toFixed(2);
			cryptoElement.innerText = absoluteChange + "%";
		}
	});
}

updateCryptocurrencyChanges(latestPrice, previousPrice);
