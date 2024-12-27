const currencyDetails = {
	USD: { name: "Dolar amerykański", description: "Oficjalna waluta Stanów Zjednoczonych." },
	EUR: { name: "Euro", description: "Wspólna waluta krajów strefy euro." },
	GBP: { name: "Funt szterling brytyjski", description: "Waluta używana w Wielkiej Brytanii." },
	JPY: {
		name: "Jen japoński",
		description: "Oficjalna waluta Japonii, jedna z najważniejszych walut świata.",
	},
	PLN: { name: "Polski złoty", description: "Waluta obowiązująca w Polsce." },
	CHF: { name: "Frank szwajcarski", description: "Oficjalna waluta Szwajcarii i Liechtensteinu." },
	AUD: { name: "Dolar australijski", description: "Oficjalna waluta Australii." },
	CAD: { name: "Dolar kanadyjski", description: "Waluta używana w Kanadzie." },
	SEK: { name: "Korona szwedzka", description: "Oficjalna waluta Szwecji." },
	NOK: { name: "Korona norweska", description: "Oficjalna waluta Norwegii." },
	DKK: { name: "Korona duńska", description: "Waluta obowiązująca w Danii." },
	CZK: { name: "Korona czeska", description: "Oficjalna waluta Czech." },
	HUF: { name: "Forint węgierski", description: "Waluta używana na Węgrzech." },
	RUB: { name: "Rubel rosyjski", description: "Oficjalna waluta Federacji Rosyjskiej." },
	CNY: { name: "Juan chiński", description: "Oficjalna waluta Chińskiej Republiki Ludowej." },
	INR: { name: "Rupia indyjska", description: "Waluta używana w Indiach." },
	MXN: { name: "Peso meksykańskie", description: "Oficjalna waluta Meksyku." },
	BRL: { name: "Real brazylijski", description: "Waluta obowiązująca w Brazylii." },
	ZAR: { name: "Rand południowoafrykański", description: "Waluta Republiki Południowej Afryki." },
	SGD: { name: "Dolar singapurski", description: "Oficjalna waluta Singapuru." },
	HKD: { name: "Dolar hongkoński", description: "Oficjalna waluta Hongkongu." },
	NZD: { name: "Dolar nowozelandzki", description: "Waluta używana w Nowej Zelandii." },
	TRY: { name: "Lira turecka", description: "Oficjalna waluta Turcji." },
	KRW: { name: "Won południowokoreański", description: "Waluta używana w Korei Południowej." },
	MYR: { name: "Ringgit malezyjski", description: "Oficjalna waluta Malezji." },
	IDR: { name: "Rupia indonezyjska", description: "Waluta używana w Indonezji." },
	THB: { name: "Bat tajski", description: "Oficjalna waluta Tajlandii." },
	SAR: { name: "Rial saudyjski", description: "Waluta Arabii Saudyjskiej." },
	AED: {
		name: "Dirham arabski (ZEA)",
		description: "Oficjalna waluta Zjednoczonych Emiratów Arabskich.",
	},
	ILS: { name: "Nowy szekel izraelski", description: "Waluta używana w Izraelu." },
	ARS: { name: "Peso argentyńskie", description: "Oficjalna waluta Argentyny." },
	CLP: { name: "Peso chilijskie", description: "Waluta używana w Chile." },
	PEN: { name: "Sol peruwiański", description: "Oficjalna waluta Peru." },
	COP: { name: "Peso kolumbijskie", description: "Waluta używana w Kolumbii." },
	VND: { name: "Dong wietnamski", description: "Oficjalna waluta Wietnamu." },
	PKR: { name: "Rupia pakistańska", description: "Waluta używana w Pakistanie." },
	BGN: { name: "Lew bułgarski", description: "Oficjalna waluta Bułgarii." },
	PHP: { name: "Peso filipińskie", description: "Waluta używana na Filipinach." },
	RON: { name: "Lej rumuński", description: "Oficjalna waluta Rumunii." },
	ISK: { name: "Korona islandzka", description: "Waluta obowiązująca na Islandii." },
	UAH: { name: "Hrywna ukraińska", description: "Oficjalna waluta Ukrainy." },
	XDR: {
		name: "Specjalne Prawa Ciągnienia",
		description: "Jednostka rozrachunkowa Międzynarodowego Funduszu Walutowego.",
	},
};

function getQueryParam(param) {
	const urlParams = new URLSearchParams(window.location.search);
	return urlParams.get(param);
}

fetch("./databases/fetch_data.php")
	.then(response => response.json())
	.then(data => {
		const currencyCode = getQueryParam("code");
		const allCurrencies = data.fiat;

		const currencyData = allCurrencies.find(row => row.code === currencyCode);
		const currencyDetail = currencyDetails[currencyCode];

		if (currencyData && currencyDetail) {
			document.title = `Kurs ${currencyDetail.name}`;

			const rate = parseFloat(currencyData.rate);
			const sellRate = (rate * 1.02 + 0.0001).toFixed(4);

			document.getElementById(
				"currency-name"
			).textContent = `Kurs ${currencyCode} - ${currencyDetail.name}`;
			document.getElementById("currency-flag").src = `https://flagcdn.com/80x60/${currencyCode
				.slice(0, 2)
				.toLowerCase()}.png`;
			document.getElementById("currency-code").textContent = currencyCode;
			document.getElementById("currency-rate").textContent = rate.toFixed(4);
			document.getElementById("currency-sell-rate").textContent = sellRate;
			document.getElementById("currency-description").textContent = currencyDetail.description;
		} else {
			document.querySelector(".container").innerHTML =
				"<p>Nie znaleziono informacji o tej walucie.</p>";
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
	const currency = document.getElementById("currency-code").textContent;
	const rate = parseFloat(document.getElementById("currency-sell-rate").textContent);

	if (!amount || amount <= 0) {
		document.getElementById("buyResult").textContent = "Proszę wpisać poprawną kwotę";
		return;
	}

	fetch("./databases/purchase.php", {
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
			if (data.status === "success") {
				buyResult.textContent = "Zakup udany! Nowe saldo:" + data.new_balance.toFixed(2) + " PLN.";
				buyResult.classList.add("success");
			} else {
				buyResult.textContent = data.message;
				buyResult.classList.add("error");
			}
		})
		.catch(() => {
			document.getElementById("buyResult").textContent = "Błąd podczas wykonywania żądania";
		});
});

const urlParams = new URLSearchParams(window.location.search);
const currencyCode = urlParams.get("code") || "USD";

fetch(`./databases/fiat_history.php?code=${currencyCode}`)
	.then(response => response.json())
	.then(data => {
		const ctx = document.getElementById("currencyChart").getContext("2d");

		const historyData = data.history.map(item => ({
			x: new Date(item.datetime),
			y: parseFloat(item.rate),
		}));

		const gradientHistory = ctx.createLinearGradient(0, 0, 0, 400);
		gradientHistory.addColorStop(0, "#34A853");
		gradientHistory.addColorStop(1, "rgba(0, 255, 0, 0)");

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
						tension: 0,
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
