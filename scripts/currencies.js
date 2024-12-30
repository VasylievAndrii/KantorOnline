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
	BGN: "Lew bułgarski",
	PHP: "Peso filipińskie",
	RON: "Lej rumuński",
	ISK: "Korona islandzka",
	UAH: "Hrywna ukraińska",
	XDR: "Specjalne Prawa Ciągnienia",
};

fetch("./databases/fetch_data.php")
	.then(response => response.json())
	.then(data => {
		const kursyFiat = data.fiat;
		const latestRatesWithTrends = getLatestRatesWithTrends(kursyFiat);
		const kursyFiatTable = createHtmlTable(latestRatesWithTrends);
		document.getElementById("kursyFiatTable").innerHTML = kursyFiatTable;
	})
	.catch(error => console.error("Błąd podczas pobierania danych:", error));

function getLatestRatesWithTrends(data) {
	const groupedData = data.reduce((acc, row) => {
		const { code } = row;
		if (!acc[code]) {
			acc[code] = [];
		}
		acc[code].push(row);
		return acc;
	}, {});

	for (const code in groupedData) {
		groupedData[code].sort((a, b) => {
			const timestampA = new Date(`${a.data}T${a.czas}`).getTime();
			const timestampB = new Date(`${b.data}T${b.czas}`).getTime();
			return timestampB - timestampA;
		});
	}

	const result = {};
	for (const code in groupedData) {
		const [newest, oldest] = groupedData[code];
		const newRate = newest ? parseFloat(newest.rate) : null;
		const oldRate = oldest ? parseFloat(oldest.rate) : null;

		let trend = "brak danych";
		if (newRate !== null && oldRate !== null) {
			trend = newRate > oldRate ? "wzrost" : newRate < oldRate ? "spadek" : "bez zmian";
		}

		result[code] = {
			code,
			newRate,
			oldRate,
			trend,
			newestTimestamp: newest ? `${newest.data} ${newest.czas}` : null,
			oldestTimestamp: oldest ? `${oldest.data} ${oldest.czas}` : null,
		};
	}

	return Object.values(result);
}

function createHtmlTable(data) {
	if (!data || data.length === 0) {
		return "<p>Brak dostępnych danych</p>";
	}

	let table = "<table border='1'><thead><tr>";
	const headers = ["Waluta", "Pełna Nazwa", "Kupno", "Sprzedaż"];
	headers.forEach(header => {
		table += `<th>${header}</th>`;
	});
	table += "</tr></thead>";

	table += "<tbody>";
	data.forEach(row => {
		const { code, newRate, trend } = row;
		const fullName = currencyNames[code] || "Nieznana waluta";

		let arrow = "";
		if (trend === "wzrost") {
			arrow = '<i class="fa-solid fa-arrow-up" style="color: #6FA000;"></i>';
		} else if (trend === "spadek") {
			arrow = '<i class="fa-solid fa-arrow-down" style="color: #FF3B30;"></i>';
		} else {
			arrow = '<i class="fa-solid fa-equals"></i>';
		}

		const detailsLink = `currencyInfo.php?code=${code}`;

		table += "<tr>";
		table += `<td data-label="Waluta">
					<a href="${detailsLink}">
						<img src="https://flagcdn.com/24x18/${code.slice(0, 2).toLowerCase()}.png" alt="${code}" />
						<b>${code}</b>
					PLN <img src="https://flagcdn.com/24x18/pl.png" alt="PLN" /></a>
					</td>`;
		table += `<td data-label="Pełna Nazwa"><a href="${detailsLink}">${fullName}</a></td>`;
		table += `<td data-label="Kupno" class="${trend}"><b>${newRate.toFixed(4)}</b> ${arrow}</td>`;
		table += `<td data-label="Sprzedaż"><b>${(newRate * 1.02 + 0.0001).toFixed(4)}</b></td>`;
		table += "</tr>";
	});
	table += "</tbody></table>";

	return table;
}
