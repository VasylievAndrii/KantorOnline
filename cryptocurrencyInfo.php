<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacje o kryptowalucie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles/styles.css" />
    <link rel="stylesheet" href="styles/cryptocurrencyInfo.css" />
</head>
<body>
  <?php include('samples/header.php'); ?>

  <main class="main  main--cryptocurrency-info">
    <h1 id="cryptocurrency-name"></h1>
    <img id="cryptocurrency-logo" alt="Логотип криптовалюты">
    <p><b>Kod kryptowaluty</b> <span id="cryptocurrency-code"></span></p>
    <p><b>Kurs kupna:</b> <span id="cryptocurrency-rate"></span> USD</p>
    <p><b>Kurs sprzedaży:</b> <span id="cryptocurrency-sell-rate"></span> USD</p>
    <p><b>Opis: </b> <span id="cryptocurrency-description"></span></p>
    <a href="cryptocurrencies.php">Wróć do strony kryptowalut</a>
    <form id="buyForm">
      <label for="amount">Kwota do zakupu:</label>
      <input type="number" id="amount" name="amount" min="0.01" step="0.01" required>
      <button type="submit">Kup teraz</button>
    </form>
    <p id="buyResult" class="buy-result"></p>
    <form id="sellForm">
      <label for="sellAmount">Kwota do sprzedania:</label>
      <input type="number" id="sellAmount" name="sellAmount" min="0.01" step="0.01" required>
      <button type="submit">Sprzedać</button>
    </form>
    <p id="sellResult" class="sell-result"></p>
    <canvas id="cryptoChart"></canvas>
  </main>
  
  <?php include('samples/footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
  <script src="scripts/script.js"></script>
  <script src="scripts/cryptocurrencyInfo.js"></script>
</body>
</html>
