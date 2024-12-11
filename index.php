<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Kantor Online</title>
		<link rel="stylesheet" href="styles/styles.css" />
	</head>
	<body>
		<?php session_start(); ?>
		<header class="header">
			<div class="header__content">
				<a href="index.php" class="logo">Kantor Online</a>
				<nav class="nav">
					<ul class="nav__list">
						<li class="nav__item"><a href="#" class="nav__link">Notowanie</a></li>
						<li class="nav__item"><a href="#" class="nav__link">O nas</a></li>
						<li class="nav__item"><a href="#" class="nav__link">Kontakt</a></li>
						<?php if(isset($_SESSION['user_id'])): ?>
							<li class="nav__item">
								<!-- <a href="logout.php" class="nav__link nav__link--login">?php echo htmlspecialchars($_SESSION['username']); ?></a> -->
								<a href="logout.php" class="nav__link nav__link--login logout-btn">Wyloguj się</a>
							</li>
						<?php else: ?>
							<li class="nav__item">
								<a href="registration.php" class="nav__link nav__link--login">Rejestracja</a>
							</li>
							<li class="nav__item">
								<a href="login.php" class="nav__link nav__link--login">Logowanie</a>
							</li>
						<?php endif; ?>
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

		<script src="js/script.js"></script>
	</body>
</html>
