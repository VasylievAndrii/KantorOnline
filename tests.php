<?php
  include('database.php');

  $result = mysqli_query($conn, 'SELECT * FROM kursy');
  $krypto = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_free_result($result);
  mysqli_close($conn);
  $lastRow = end($krypto);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitcoin Price Change</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="price-changes" id="price-changes">
        <!-- Здесь будет отображаться информация -->
    </div>

    <script>
        // Получаем данные из PHP (переносим их в JavaScript)
        const data = <?php echo json_encode($krypto); ?>;
        
        // Функция для отображения изменений
        function renderPriceChanges(data) {
            const container = document.getElementById('price-changes');
            container.innerHTML = ''; // Очищаем контейнер перед рендерингом

            // Перебираем данные, начиная со второго элемента
            for (let i = 1; i < data.length; i++) {
                const previous = parseFloat(data[i - 1].price);  // Преобразуем строку в число
                const current = parseFloat(data[i].price);
                const date = data[i].date;

                // Расчет изменения
                const difference = current - previous;
                const percentChange = ((difference / previous) * 100).toFixed(2);

                // Определение стрелки и цвета
                const arrow = difference > 0 ? '▲' : '▼';
                const colorClass = difference > 0 ? 'green' : 'red';

                // Создание элемента для отображения
                const priceChangeElement = document.createElement('div');
                priceChangeElement.classList.add('price-change', colorClass);

                priceChangeElement.innerHTML = `
                    <span class="arrow">${arrow}</span>
                    <span class="percent">${Math.abs(percentChange)}%</span>
                    <span class="date">(${date})</span>
                `;

                // Добавление элемента в контейнер
                container.appendChild(priceChangeElement);
            }
        }

        // Вызов функции для отображения данных
        renderPriceChanges(data);
    </script>
</body>
</html>
