const cryptocurrencyDetails = {
	BTC: {
		name: "Bitcoin",
		description: "Pierwsza i najbardziej znana kryptowaluta, oparta na technologii blockchain.",
		logo: "bitcoin-logo.png",
	},
	ETH: {
		name: "Ethereum",
		description:
			"Kryptowaluta i platforma dla inteligentnych kontraktów oraz aplikacji zdecentralizowanych.",
		logo: "ethereum-logo.png",
	},
	LTC: {
		name: "Litecoin",
		description: "Lekka kryptowaluta stworzona jako szybsza alternatywa dla Bitcoina.",
		logo: "litecoin-logo.png",
	},
	XRP: {
		name: "Ripple (XRP)",
		description: "Kryptowaluta zaprojektowana do szybkich i tanich transakcji międzybankowych.",
		logo: "xrp-logo.png",
	},
	BCH: {
		name: "Bitcoin Cash",
		description:
			"Kryptowaluta będąca rozwidleniem Bitcoina, zaprojektowana dla szybszych i tańszych transakcji.",
		logo: "bitcoin-cash-logo.png",
	},
};

function getQueryParam(param) {
	const urlParams = new URLSearchParams(window.location.search);
	return urlParams.get(param);
}

fetch("./databases/fetch_data.php")
	.then(response => response.json())
	.then(data => {
		const cryptocurrencyCode = getQueryParam("code");
		const allCryptocurrencies = data.krypto;
		const usdToPlnRate = parseFloat(data.usd_to_pln);
		const cryptocurrencyData = allCryptocurrencies.find(row => row.code === cryptocurrencyCode);

		const cryptocurrencyDetail = cryptocurrencyDetails[cryptocurrencyCode];

		if (cryptocurrencyData && cryptocurrencyDetail) {
			document.title = `Kurs ${cryptocurrencyDetail.name}`;

			const rate = parseFloat(cryptocurrencyData.rate * usdToPlnRate);
			const sellRate = (rate * 1.02 + 0.0001).toFixed(2);

			document.getElementById(
				"cryptocurrency-name"
			).textContent = `Kurs ${cryptocurrencyCode} - ${cryptocurrencyDetail.name}`;
			document.getElementById(
				"cryptocurrency-logo"
			).src = `./images/${cryptocurrencyDetails[cryptocurrencyCode].logo}`;
			document.getElementById("cryptocurrency-code").textContent = cryptocurrencyCode;
			document.getElementById("cryptocurrency-rate").textContent = rate.toFixed(2);
			document.getElementById("cryptocurrency-sell-rate").textContent = sellRate;
			document.getElementById("cryptocurrency-description").textContent =
				cryptocurrencyDetail.description;
		} else {
			document.querySelector(".container").innerHTML =
				"<p>Nie znaleziono informacji o tej kryptowalucie.</p>";
		}
	})
	.catch(error => {
		console.error("Błąd podczas pobierania danych:", error);
		document.querySelector(".container").innerHTML =
			"<p>Wystąpił błąd podczas ładowania danych.</p>";
	});

document.getElementById("buyForm").addEventListener("submit", function (event) {
	event.preventDefault();

	const amount = parseFloat(document.getElementById("amount").value);
	const currency = document.getElementById("cryptocurrency-code").textContent;
	const rate = parseFloat(document.getElementById("cryptocurrency-sell-rate").textContent);

	if (!amount || amount <= 0) {
		document.getElementById("buyResult").textContent = "Proszę wpisać poprawną kwotę";
		return;
	}

	fetch("./databases/purchase_crypto.php", {
		method: "POST",
		headers: { "Content-Type": "application/x-www-form-urlencoded" },
		body: new URLSearchParams({
			currency: currency,
			amount: amount,
			rate: rate,
		}),
	})
		.then(response => response.json())
		.then(data => {
			const buyResult = document.getElementById("buyResult");
			const sellResult = document.getElementById("sellResult");
			if (data.status === "success") {
				buyResult.textContent = "Zakup udany! Nowe saldo: " + data.new_balance.toFixed(2) + " PLN.";
				buyResult.classList.add("success");
				buyResult.classList.remove("danger");
				buyResult.classList.remove("hidden");
				sellResult.classList.add("hidden");
			} else {
				buyResult.textContent = data.message;
				buyResult.classList.add("danger");
				buyResult.classList.remove("success");
				buyResult.classList.remove("hidden");
				sellResult.classList.add("hidden");
			}
		})
		.catch(() => {
			document.getElementById("buyResult").textContent = "Błąd podczas wykonywania żądania";
		});
});

document.getElementById("sellForm").addEventListener("submit", function (event) {
	event.preventDefault();

	const amount = parseFloat(document.getElementById("sellAmount").value);
	const currency = document.getElementById("cryptocurrency-code").textContent;
	const rate = parseFloat(document.getElementById("cryptocurrency-rate").textContent);

	if (!amount || amount <= 0) {
		document.getElementById("sellResult").textContent = "Proszę wpisać poprawną kwotę";
		return;
	}

	fetch("./databases/sell_crypto.php", {
		method: "POST",
		headers: { "Content-Type": "application/x-www-form-urlencoded" },
		body: new URLSearchParams({
			currency: currency,
			amount: amount,
			rate: rate,
		}),
	})
		.then(response => response.json())
		.then(data => {
			const sellResult = document.getElementById("sellResult");
			const buyResult = document.getElementById("buyResult");
			if (data.status === "success") {
				sellResult.textContent =
					"Sprzedaż udana! Nowe saldo: " + data.new_balance.toFixed(2) + " PLN.";
				sellResult.classList.add("success");
				sellResult.classList.remove("danger");
				sellResult.classList.remove("hidden");
				buyResult.classList.add("hidden");
			} else {
				sellResult.textContent = data.message;
				sellResult.classList.add("danger");
				sellResult.classList.remove("success");
				sellResult.classList.remove("hidden");
				buyResult.classList.add("hidden");
			}
		})
		.catch(() => {
			document.getElementById("sellResult").textContent = "Błąd podczas wykonywania żądania";
		});
});

const urlParams = new URLSearchParams(window.location.search);
const cryptoCode = urlParams.get("code");

fetch(`./databases/fetch_data.php?code=${cryptoCode}`)
	.then(response => response.json())
	.then(data => {
		const ctx = document.getElementById("cryptoChart").getContext("2d");
		const usdToPlnRate = parseFloat(data.usd_to_pln);

		const historyData = data.history.map(item => ({
			x: new Date(item.datetime),
			y: parseFloat(item.rate) * usdToPlnRate,
		}));

		const predictionData = data.prediction.map(item => ({
			x: new Date(item.datetime),
			y: parseFloat(item.rate) * usdToPlnRate,
		}));

		new Chart(ctx, {
			type: "line",
			data: {
				datasets: [
					{
						label: "Historia (ostatni tydzień)",
						data: historyData,
						borderColor: "#34A853",
						backgroundColor: "rgba(52, 168, 83, 0.2)",
						fill: true,
						tension: 0.4,
						pointRadius: 1,
						borderWidth: 2,
					},
					{
						label: "Predykcja",
						data: predictionData,
						borderColor: "rgba(0, 0, 255, 1)",
						backgroundColor: "rgba(66, 133, 244, 0.2)",
						fill: true,
						tension: 0.4,
						pointRadius: 1,
						borderWidth: 2,
					},
				],
			},
			options: {
				responsive: true,
				plugins: {
					legend: { display: true, position: "top" },
					tooltip: {
						mode: "index",
						intersect: false,
						callbacks: {
							label: function (tooltipItem) {
								return `${tooltipItem.raw.y.toLocaleString()} PLN`;
							},
						},
					},
				},
				scales: {
					x: {
						type: "time",
						time: {
							unit: "day",
							tooltipFormat: "yyyy-MM-dd HH:mm",
							displayFormats: { hour: "HH:mm" },
						},
						title: { display: true, text: "Data i godzina" },
						grid: { color: "rgba(0, 0, 0, 0.1)" },
					},
					y: {
						title: { display: true, text: "Kurs PLN" },
						grid: { color: "rgba(0, 0, 0, 0.1)" },
					},
				},
			},
		});
	})
	.catch(error => console.error("Błąd podczas pobierania danych:", error));
