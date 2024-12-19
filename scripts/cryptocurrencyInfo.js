const urlParams = new URLSearchParams(window.location.search);
const cryptoCode = urlParams.get("code") || "BTC";

fetch(`./databases/fetch_data.php?code=${cryptoCode}`)
	.then(response => response.json())
	.then(data => {
		const ctx = document.getElementById("cryptoChart").getContext("2d");

		const historyData = data.history.map(item => ({
			x: new Date(item.datetime),
			y: parseFloat(item.rate),
		}));

		const predictionData = data.prediction.map(item => ({
			x: new Date(item.datetime),
			y: parseFloat(item.rate),
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
								return `${tooltipItem.raw.y.toLocaleString()} USD`;
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
						title: { display: true, text: "Kurs USD" },
						grid: { borderDash: [3, 3] },
					},
				},
			},
		});
	})
	.catch(error => console.error("Błąd podczas pobierania danych:", error));
