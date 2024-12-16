<?php session_start(); ?>
		<header class="header">
			<div class="header__content">
				<a href="index.php" class="logo">Kantor Online</a>
				<nav class="nav">
					<ul class="nav__list">
						<li class="nav__item"><a href="cryptocurrencies.php" class="nav__link">Kryptowaluty</a></li>
						<li class="nav__item"><a href="currencies.php" class="nav__link">Waluty</a></li>
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