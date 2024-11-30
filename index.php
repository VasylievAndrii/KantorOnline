<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Kantor Online</title>
		<link rel="stylesheet" href="styles.css" />
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link
			href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
			rel="stylesheet"
		/>
	</head>
	<body>
		<header class="header">
			<div class="header__content">
				<a href="#" class="logo">Kantor Online</a>

				<nav class="nav">
					<ul class="nav__list">
						<li class="nav__item">
							<a href="#" class="nav__link">Notowanie</a>
						</li>
						<li class="nav__item">
							<a href="#" class="nav__link">O nas</a>
						</li>
						<li class="nav__item">
							<a href="#" class="nav__link">Kontakt</a>
						</li>
						<li class="nav__item">
							<a href="#" class="nav__link nav__link--login">Zaloguj</a>
						</li>
					</ul>
				</nav>

				<div class="hamburger">
					<div class="bar"></div>
					<div class="bar"></div>
					<div class="bar"></div>
				</div>
			</div>
		</header>

		<main class="main">
      <h1 class="main__heading">Kryptowaluty</h1>

      <div class="main__cryptocurrency-content-page">
				<div class="main__cryptocurrency">
					<div class="main__cryptocurrency-header">
						<img src="images/bitcoin-logo.png" alt="Bitcoin logo" class="main__cryptocurrency-logo">
						<p class="main__cryptocurrency-name">Bitcoin</p>
						<p class="main__cryptocurrency-subname">BTC</p>
					</div>
					<div class="main__cryptocurrency-footer">
						<p class='main__cryptocurrency-price main__cryptocurrency-price--BTC'></p>
						<span class="triangle triangle--BTC"></span>
						<p class="main__cryptocurrency-percentage-change main__cryptocurrency-percentage-change--BTC"></p>
					</div>
				</div>      

				<div class="main__cryptocurrency">
					<div class="main__cryptocurrency-header">
						<img src="images/ethereum-logo.png" alt="Ethereum logo" class="main__cryptocurrency-logo">
						<p class="main__cryptocurrency-name">Ethereum</p>
						<p class="main__cryptocurrency-subname">ETH</p>
					</div>
					<div class="main__cryptocurrency-footer">
						<p class='main__cryptocurrency-price main__cryptocurrency-price--ETH'></p>
						<span class="triangle triangle--ETH"></span>
						<p class="main__cryptocurrency-percentage-change main__cryptocurrency-percentage-change--ETH"></p>
					</div>
				</div>

				<div class="main__cryptocurrency">
					<div class="main__cryptocurrency-header">
						<img src="images/litecoin-logo.png" alt="Litecoin logo" class="main__cryptocurrency-logo">
						<p class="main__cryptocurrency-name">Litecoin</p>
						<p class="main__cryptocurrency-subname">LTC</p>
					</div>
					<div class="main__cryptocurrency-footer">
						<p class='main__cryptocurrency-price main__cryptocurrency-price--LTC'></p>
						<span class="triangle triangle--LTC"></span>
						<p class="main__cryptocurrency-percentage-change main__cryptocurrency-percentage-change--LTC"></p>
					</div>
				</div>

				<div class="main__cryptocurrency">
					<div class="main__cryptocurrency-header">
						<img src="images/xrp-logo.png" alt="XRP logo" class="main__cryptocurrency-logo">
						<p class="main__cryptocurrency-name">XRP</p>
						<p class="main__cryptocurrency-subname">XRP</p>
					</div>
					<div class="main__cryptocurrency-footer">
						<p class='main__cryptocurrency-price main__cryptocurrency-price--XRP'></p>
						<span class="triangle triangle--XRP"></span>
						<p class="main__cryptocurrency-percentage-change main__cryptocurrency-percentage-change--XRP"></p>
					</div>
				</div>

				<div class="main__cryptocurrency">
					<div class="main__cryptocurrency-header">
						<img src="images/bitcoin-cash-logo.png" alt="Bitcoin cash logo" class="main__cryptocurrency-logo">
						<p class="main__cryptocurrency-name">Bitcoin cash</p>
						<p class="main__cryptocurrency-subname">BCH</p>
					</div>
					<div class="main__cryptocurrency-footer">
						<p class='main__cryptocurrency-price main__cryptocurrency-price--BCH'></p>
						<span class="triangle triangle--BCH"></span>
						<p class="main__cryptocurrency-percentage-change main__cryptocurrency-percentage-change--BCH"></p>
					</div>
				</div> 
			</div>	 
    </main>

		<footer class="footer">
			<div class="footer__content">
				<p class="footer__created_by">Kamil Gręda, Tomasz Tapa, Andrii Vasyliev &copy; 2024</p>
			</div>
		</footer>

		<script src="script.js"></script>
	</body>
</html>
