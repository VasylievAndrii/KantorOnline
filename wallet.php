    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Wallet</title>
        <link rel="stylesheet" href="styles/styles.css" />
        <link rel="stylesheet" href="styles/wallet.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <?php 
            include('samples/header.php');
            require_once "databases/get_wallet_data.php"; 
        ?>

        <main class="main">
            <section class="main--wallet">
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
                                    <td data-label="Waluta"><a href="currencyInfo.php?code=<?= urlencode($currency['currency']) ?>"><?= htmlspecialchars($currency['currency']) ?></a></td>
                                    <td data-label="Sprzedaż"><?= number_format($rate, 4) ?></td>
                                    <td data-label="Ilość"><?= htmlspecialchars($currency['amount']) ?></td>
                                    <td data-label="Całkowity"><?= number_format($total, 4) ?> PLN</td>
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
                                <th>Sprzedaż</th>
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
                                    <td data-label="Waluta"><a href="cryptocurrencyInfo.php?code=<?= urlencode($crypto['currency']) ?>"><?= htmlspecialchars($crypto['currency']) ?></a></td>
                                    <td data-label="Sprzedaż"><?= number_format($rate, 2) ?></td>
                                    <td data-label="Ilość"><?= htmlspecialchars($crypto['amount']) ?></td>
                                    <td data-label="Całkowity"><?= number_format($total, 2) ?> PLN</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>

        <?php include('samples/footer.php'); ?>

        <script src="scripts/script.js"></script>
        <script src="scripts/wallet.js"></script>
    </body>
</html>
