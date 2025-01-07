const cryptocurrencyDetails = {
	BTC: {
		name: "Bitcoin",
		description: "Pierwsza i najbardziej znana kryptowaluta, oparta na technologii blockchain.",
		logo: "bitcoin-logo.png",
	},
};

const currencyDetails = {
	USD: {
		name: "Dolar amerykański",
		description: "Oficjalna waluta Stanów Zjednoczonych.",
	},
};

fetch("./databases/fetch_BTC_USD_data.php")
	.then(response => response.json())
	.then(data => {
		const usdToPlnRate = parseFloat(data.usd.usd_to_pln);
		const usdHistoryData = data.usd.usd_history.map(item => ({
			x: new Date(item.datetime),
			y: parseFloat(item.rate),
		}));

		const btcActualRate = parseFloat(data.btc.actual);
		const btcHistoryData = data.btc.history.map(item => ({
			x: new Date(item.datetime),
			y: parseFloat(item.rate) * usdToPlnRate,
		}));
		const btcPredictionData = data.btc.prediction.map(item => ({
			x: new Date(item.datetime),
			y: parseFloat(item.rate) * usdToPlnRate,
		}));

		const btcDetails = cryptocurrencyDetails["BTC"];
		const usdDetails = currencyDetails["USD"];

		document.getElementById("btc-name").textContent = btcDetails.name;
		document.getElementById("btc-logo").src = `./images/${btcDetails.logo}`;
		document.getElementById("btc-code").textContent = Object.keys(cryptocurrencyDetails)[0];
		document.getElementById("btc-description").textContent = btcDetails.description;
		document.getElementById("btc-rate").textContent = (btcActualRate * usdToPlnRate).toFixed(2);
		document.getElementById("btc-rate-s").textContent = (
			(btcActualRate * 1.02 + 0.0001) *
			usdToPlnRate
		).toFixed(2);

		document.getElementById("usd-name").textContent = usdDetails.name;
		document.getElementById("usd-code").textContent = Object.keys(currencyDetails)[0];
		document.getElementById("usd-description").textContent = usdDetails.description;
		document.getElementById("usd-rate").textContent = usdToPlnRate.toFixed(2);
		document.getElementById("usd-rate-s").textContent = (usdToPlnRate * 1.02 + 0.0001).toFixed(2);

		const btcCtx = document.getElementById("btc-chart").getContext("2d");
		new Chart(btcCtx, {
			type: "line",
			data: {
				datasets: [
					{
						label: "Historia BTC (PLN)",
						data: btcHistoryData,
						borderColor: "#34A853",
						backgroundColor: "rgba(52, 168, 83, 0.2)",
						fill: true,
						tension: 0.4,
						pointRadius: 1,
						borderWidth: 2,
					},
					{
						label: "Predykcja BTC (PLN)",
						data: btcPredictionData,
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

		const usdCtx = document.getElementById("usd-chart").getContext("2d");
		new Chart(usdCtx, {
			type: "line",
			data: {
				datasets: [
					{
						label: "Historia USD (PLN)",
						data: usdHistoryData,
						borderColor: "#FF9900",
						backgroundColor: "rgba(255, 153, 0, 0.2)",
						fill: true,
						tension: 0.4,
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
						time: { unit: "day", tooltipFormat: "yyyy-MM-dd HH:mm" },
					},
					y: { title: { display: true, text: "Kurs PLN" } },
				},
			},
		});
	})
	.catch(error => {
		console.error("Błąd podczas pobierania danych:", error);
		document.querySelector(".main__showcase").innerHTML =
			"<p>Wystąpił błąd podczas ładowania danych.</p>";
	});
