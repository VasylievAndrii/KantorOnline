<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacje o walucie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles/styles.css" />
    <link rel="stylesheet" href="styles/currencyInfo.css" />
</head>
<body>
  <?php include('samples/header.php'); ?>

  <main class="main main--currency-info">
      <h1 id="currency-name"></h1>
      <img id="currency-flag" alt="Flaga waluty">
      <p><b>Kod waluty:</b> <span id="currency-code"></span></p>
      <p><b>Kurs kupna:</b> <span id="currency-rate"></span> PLN</p>
      <p><b>Kurs sprzedaży:</b> <span id="currency-sell-rate"></span> PLN</p>
      <p><b>Opis:</b> <span id="currency-description"></span></p>
      <a href="currencies.php">Wróć do strony walut</a>
      <form id="buyForm">
        <label for="amount">Kwota do zakupu:</label>
        <input type="number" id="amount" name="amount" min="0.01" step="0.01" required>
        <button type="submit">Kup teraz</button>
      </form>
      <p id="buyResult" class="buy-result"></p>
      <form id="sellForm">
        <label for="sellAmount">Kwota do sprzeday:</label>
        <input type="number" id="sellAmount" name="sellAmount" min="0.01" step="0.01" required>
        <button type="submit">Sprzedać</button>
      </form>
      <p id="sellResult" class="sell-result"></p>
      <canvas id="currencyChart"></canvas>
  </main>
  <?php include('samples/footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
  <script src="scripts/script.js"></script>
  <script src="scripts/currencyInfo.js"></script>
</body>
</html>
