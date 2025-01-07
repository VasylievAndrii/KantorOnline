<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacje o kryptowalucie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles/styles.css" />
    <link rel="stylesheet" href="styles/cryptocurrencyInfo.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
  <?php include('samples/header.php'); ?>

  <main class="main">
    <section class="main--cryptocurrency-info">
      <div class="container">
        <h1 id="cryptocurrency-name"></h1>
        <img id="cryptocurrency-logo" alt="Cryptocurrency logo">
      </div>
      <p><b>Kod kryptowaluty</b> <span id="cryptocurrency-code"></span></p>
      <p><b>Kurs kupna:</b> <span id="cryptocurrency-rate"></span> PLN</p>
      <p><b>Kurs sprzedaży:</b> <span id="cryptocurrency-sell-rate"></span> PLN</p>
      <p><b>Opis: </b> <span id="cryptocurrency-description"></span></p>
      <div class="crypto-forms">
        <form id="buyForm" class="form">
          <label for="amount">
            <i class="fas fa-shopping-cart"></i> Kwota do zakupu:
          </label>
          <input type="number" id="amount" name="amount" min="0.01" step="0.01" required>
          <button type="submit" class="btn btn-buy">Kup teraz</button>
        </form>

        <form id="sellForm" class="form">
          <label for="sellAmount">
            <i class="fas fa-coins"></i> Kwota do sprzedania:
          </label>
          <input type="number" id="sellAmount" name="sellAmount" min="0.01" step="0.01" required>
          <button type="submit" class="btn btn-sell">Sprzedać</button>
        </form>
      </div>
      <p id="buyResult" class="buy-result notification hidden"></p>
      <p id="sellResult" class="sell-result notification hidden"></p>
      <canvas id="cryptoChart"></canvas>
      <a class="back" href="cryptocurrencies.php">Wróć do strony kryptowalut</a>
    </section>
  </main>

  <?php include('samples/footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
  <script src="scripts/script.js"></script>
  <script src="scripts/cryptocurrencyInfo.js"></script>
</body>
</html>
