fetch("./databases/fetch_data.php")
	.then(response => response.json())
	.then(data => {
		const kursyFiat = data.fiat; // Данные из kursy_fiat

		// Выписываем таблицу для kursy_fiat
		const kursyFiatTable = createHtmlTable(kursyFiat);
		document.getElementById("kursyFiatTable").innerHTML = kursyFiatTable;
	})
	.catch(error => console.error("Error fetching data:", error));

/**
 * Создаёт HTML-код таблицы из массива объектов.
 * @param {Array} data - Массив объектов для отображения в таблице.
 * @returns {string} - Сгенерированный HTML-код таблицы.
 */
function createHtmlTable(data) {
	if (!data || data.length === 0) {
		return "<p>Данные отсутствуют</p>";
	}

	// Заголовки таблицы
	let table = "<table border='1'><thead><tr>";
	const headers = Object.keys(data[0]);
	headers.forEach(header => {
		table += `<th>${header}</th>`;
	});
	table += "</tr></thead>";

	// Данные таблицы
	table += "<tbody>";
	data.forEach(row => {
		table += "<tr>";
		headers.forEach(header => {
			table += `<td>${row[header]}</td>`;
		});
		table += "</tr>";
	});
	table += "</tbody></table>";

	return table;
}
