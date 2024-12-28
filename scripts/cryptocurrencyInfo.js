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

const urlParams = new URLSearchParams(window.location.search);
const cryptoCode = urlParams.get("code") || "BTC";

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

		const gradientHistory = ctx.createLinearGradient(0, 0, 0, 400);
		gradientHistory.addColorStop(0, "#34A853");
		gradientHistory.addColorStop(1, "rgba(0, 255, 0, 0)");

		const gradientPrediction = ctx.createLinearGradient(0, 0, 0, 400);
		gradientPrediction.addColorStop(0, "rgba(0, 0, 255, 0.4)");
		gradientPrediction.addColorStop(1, "rgba(0, 0, 255, 0)");

		new Chart(ctx, {
			type: "line",
			data: {
				datasets: [
					{
						label: "Historia (ostatni tydzień)",
						data: historyData,
						borderColor: "#34A853",
						backgroundColor: gradientHistory,
						fill: true,
						tension: 0.4,
						pointRadius: 0,
					},
					{
						label: "Predykcja",
						data: predictionData,
						borderColor: "rgba(0, 0, 255, 1)",
						backgroundColor: gradientPrediction,
						fill: true,
						tension: 0.4,
						pointRadius: 0,
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
						grid: { display: false },
					},
					y: {
						title: { display: true, text: "Kurs PLN" },
						grid: { borderDash: [3, 3] },
					},
				},
			},
		});
	})
	.catch(error => console.error("Błąd podczas pobierania danych:", error));
