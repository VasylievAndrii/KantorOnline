const currencyNames = {
	USD: "Dolar amerykański",
	EUR: "Euro",
	GBP: "Funt szterling brytyjski",
	JPY: "Jen japoński",
	PLN: "Polski złoty",
	CHF: "Frank szwajcarski",
	AUD: "Dolar australijski",
	CAD: "Dolar kanadyjski",
	SEK: "Korona szwedzka",
	NOK: "Korona norweska",
	DKK: "Korona duńska",
	CZK: "Korona czeska",
	HUF: "Forint węgierski",
	RUB: "Rubel rosyjski",
	CNY: "Juan chiński",
	INR: "Rupia indyjska",
	MXN: "Peso meksykańskie",
	BRL: "Real brazylijski",
	ZAR: "Rand południowoafrykański",
	SGD: "Dolar singapurski",
	HKD: "Dolar hongkoński",
	NZD: "Dolar nowozelandzki",
	TRY: "Lira turecka",
	KRW: "Won południowokoreański",
	MYR: "Ringgit malezyjski",
	IDR: "Rupia indonezyjska",
	THB: "Bat tajski",
	SAR: "Rial saudyjski",
	AED: "Dirham arabski (ZEA)",
	ILS: "Nowy szekel izraelski",
	ARS: "Peso argentyńskie",
	CLP: "Peso chilijskie",
	PEN: "Sol peruwiański",
	COP: "Peso kolumbijskie",
	VND: "Dong wietnamski",
	PKR: "Rupia pakistańska",
};

fetch("./databases/fetch_data.php")
	.then(response => response.json())
	.then(data => {
		const kursyFiat = data.fiat;
		const latestRatesWithTrends = getLatestRatesWithTrends(kursyFiat);
		const kursyFiatTable = createHtmlTable(latestRatesWithTrends);
		document.getElementById("kursyFiatTable").innerHTML = kursyFiatTable;
	})
	.catch(error => console.error("Error fetching data:", error));

function getLatestRatesWithTrends(data) {
	const latest = {};

	data.forEach(row => {
		const { code, rate } = row;
		const currentRate = parseFloat(rate);

		if (!latest[code]) {
			latest[code] = row;
			latest[code].trend = "нет данных";
		} else {
			const previousRate = parseFloat(latest[code].rate);
			const trend =
				currentRate > previousRate ? "рост" : currentRate < previousRate ? "спад" : "без изменений";

			latest[code] = row;
			latest[code].trend = trend;
		}
	});

	return Object.values(latest);
}

function createHtmlTable(data) {
	if (!data || data.length === 0) {
		return "<p>Данные отсутствуют</p>";
	}

	let table = "<table border='1'><thead><tr>";
	const headers = ["Waluta", "Pełna Nazwa", "Kupno", "Sprzedaż"];
	headers.forEach(header => {
		table += `<th>${header}</th>`;
	});
	table += "</tr></thead>";

	table += "<tbody>";
	data.forEach(row => {
		const rate = parseFloat(row.rate);
		const trendClass = row.trend;
		const fullName = currencyNames[row.code] || "Unknown Currency";

		let arrow = "";
		if (trendClass === "рост") {
			arrow = '<i class="fa-solid fa-arrow-up" style="color: green;"></i>';
		} else if (trendClass === "спад") {
			arrow = '<i class="fa-solid fa-arrow-down" style="color: red;"></i>';
		} else {
			arrow = '<i class="fa-solid fa-equals"></i>';
		}

		table += "<tr>";
		table += `<td><img src="https://flagcdn.com/24x18/${row.code
			.slice(0, 2)
			.toLowerCase()}.png" alt="${row.code}" /> <b>${
			row.code
		}</b> PLN <img src="https://flagcdn.com/24x18/pl.png" alt="PLN" /></td>`;
		table += `<td>${fullName}</td>`;
		table += `<td class="${trendClass}"><b>${rate.toFixed(4)}</b> ${arrow}</td>`;
		table += `<td><b>${(rate * 1.1).toFixed(4)}</b></td>`;
		table += "</tr>";
	});
	table += "</tbody></table>";

	return table;
}
