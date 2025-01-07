<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Kantor Online</title>
		<link rel="stylesheet" href="styles/styles.css" />
		<link rel="stylesheet" href="styles/index.css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
	</head>
	<body>
		<?php include('samples/header.php'); ?>
		
		<main class="main">
			<section class="main__showcase">
				<div class="main__showcase-page">
					<h1 class="main__heading">Kryptowaluty</h1>
					<div id="btc-data">
						<div class="container">
							<h2 id="btc-name"></h2>
							<img id="btc-logo" alt="Bitcoin Logo" />
						</div>
						<p><b>Kod waluty:</b> <span id="btc-code"></span></p>
						<p><b>Kurs kupna:</b> <span id="btc-rate"></span> PLN</p>
						<p><b>Kurs sprzedaży:</b> <span id="btc-rate-s"></span> PLN</p>
						<p><b>Opis:</b> <span id="btc-description"></span></p>
						<canvas id="btc-chart"></canvas>

						<div class="buttons-container">
							<a href="cryptocurrencyInfo.php?code=BTC" class="btn btn-primary">Dowiedz się więcej o BTC</a>
							<a href="cryptocurrencies.php" class="btn btn-secondary">Lista wszystkich kryptowalut</a>
						</div>
					</div>
				</div>

				<div class="main__showcase-page">
					<h1 class="main__heading">Waluty</h1>
					<div id="usd-data">
						<div class="container">
							<h2 id="usd-name"></h2>
							<img id="usd-flag" src="https://flagcdn.com/80x60/us.png" alt="Flaga Waluty USA">
						</div>
						<p><b>Kod waluty:</b> <span id="usd-code"></span></p>
						<p><b>Kurs kupna:</b> <span id="usd-rate"></span> PLN</p>
						<p><b>Kurs sprzedaży:</b> <span id="usd-rate-s"></span> PLN</p>
						<p><b>Opis:</b> <span id="usd-description"></span></p>
						<canvas id="usd-chart"></canvas>
						<div class="buttons-container">
							<a href="currencyInfo.php?code=USD" class="btn btn-primary">Dowiedz się więcej o USD</a>
							<a href="currencies.php" class="btn btn-secondary">Lista wszystkich walut</a>
						</div>
					</div>
				</div>
			</section>
		</main>

		<?php include('samples/footer.php'); ?>

		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
		<script src="scripts/script.js"></script>
		<script src="scripts/index.js"></script>
	</body>
</html>
