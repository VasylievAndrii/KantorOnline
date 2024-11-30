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
      <div class="main__cryptocurrency-content-page"></div>	 
    </main>

		<footer class="footer">
			<div class="footer__content">
				<p class="footer__created_by">Kamil Gręda, Tomasz Tapa, Andrii Vasyliev &copy; 2024</p>
			</div>
		</footer>

		<script src="script.js"></script>
	</body>
</html>
