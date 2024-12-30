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
            <p class="total-balance"><strong>Saldo całkowite:</strong> <?= number_format($totalBalance, 2) ?> PLN</p>

            <div class="tabs">
                <div class="tab active" data-tab="currencies" onclick="switchTab('currencies')">Waluty</div>
                <div class="tab" data-tab="cryptocurrencies" onclick="switchTab('cryptocurrencies')">Kryptowaluty</div>
            </div>

            <div id="currencies" class="tab-content active">
                <h2>Twoje waluty</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Waluta</th>
                            <th>Sprzedaż</th>
                            <th>Ilość</th>
                            <th>Całkowity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($currencies as $currency): ?>
                            <?php 
                                $rate = $currencyRates[$currency['currency']] ?? 0;
                                $total = $rate * $currency['amount'];
                            ?>
                            <tr>
                                <td><a href="currencyInfo.php?code=<?= urlencode($currency['currency']) ?>"><?= htmlspecialchars($currency['currency']) ?></a></td>
                                <td><?= number_format($rate, 4) ?></td>
                                <td><?= htmlspecialchars($currency['amount']) ?></td>
                                <td><?= number_format($total, 4) ?></td>
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
                            <th>Kupno</th>
                            <th>Ilość</th>
                            <th>Całkowity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cryptocurrencies as $crypto): ?>
                            <?php 
                                $rate = $cryptoRates[$crypto['currency']] ?? 0;
                                $total = $rate * $crypto['amount'];
                            ?>
                            <tr>
                                <td><a href="cryptocurrencyInfo.php?code=<?= urlencode($crypto['currency']) ?>"><?= htmlspecialchars($crypto['currency']) ?></a></td>
                                <td><?= number_format($rate, 2) ?></td>
                                <td><?= htmlspecialchars($crypto['amount']) ?></td>
                                <td><?= number_format($total, 2) ?></td>
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
