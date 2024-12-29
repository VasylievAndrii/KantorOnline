<?php
  require_once "databases/get_wallet_data.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Wallet</title>
    <link rel="stylesheet" href="styles/styles.css" />
    <link rel="stylesheet" href="styles/wallet.css" />
  </head>
  <body>
    <?php include('samples/header.php'); ?>

    <main class="main main--wallet">
      <h1>Twój portfel, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>

      <div class="tabs">
          <div class="tab active" data-tab="currencies" onclick="switchTab('currencies')">Currencies</div>
          <div class="tab" data-tab="cryptocurrencies" onclick="switchTab('cryptocurrencies')">Cryptocurrencies</div>
      </div>

      <div id="currencies" class="tab-content active">
          <h2>Twoje waluty</h2>
          <table>
              <thead>
                  <tr>
                      <th>Waluta</th>
                      <th>Kwota</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($currencies as $currency): ?>
                      <tr>
                          <td><?= htmlspecialchars($currency['currency']) ?></td>
                          <td><?= htmlspecialchars($currency['amount']) ?></td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
      </div>

      <div id="cryptocurrencies" class="tab-content">
          <h2>Twoje kryptowaluty</h2>
          <table>
              <thead>
                  <tr>
                      <th>Kryptowaluta</th>
                      <th>Kwota</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($cryptocurrencies as $crypto): ?>
                      <tr>
                          <td><?= htmlspecialchars($crypto['currency']) ?></td>
                          <td><?= htmlspecialchars($crypto['amount']) ?></td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
      </div>
    </main>

    <?php include('samples/footer.php'); ?>

    <script src="scripts/script.js"></script>
    <script src="scripts/wallet.js"></script>
  </body>
</html>
