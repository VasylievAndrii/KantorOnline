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

// Получение параметра 'code' из URL
function getQueryParam(param) {
	const urlParams = new URLSearchParams(window.location.search);
	return urlParams.get(param);
}

// Запрос данных с сервера
fetch("./databases/fetch_data.php")
	.then(response => response.json())
	.then(data => {
		const currencyCode = getQueryParam("code");
		const allCurrencies = data.fiat;

		const currencyData = allCurrencies.find(row => row.code === currencyCode);
		const currencyDetail = currencyDetails[currencyCode];

		if (currencyData && currencyDetail) {
			const rate = parseFloat(currencyData.rate);
			const sellRate = (rate * 1.1).toFixed(4);

			document.getElementById("currency-name").textContent = currencyDetail.name;
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
