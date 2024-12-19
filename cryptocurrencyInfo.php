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

  <main class="main">
    <h1>Wykres Kryptowaluty</h1>
    <p id="cryptoName" class="crypto-name"></p>
    <canvas id="cryptoChart"></canvas>
  </main>
  <?php include('samples/footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
  <script src="scripts/script.js"></script>
  <script src="scripts/cryptocurrencyInfo.js"></script>
</body>
</html>
