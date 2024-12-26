<?php 
session_start(); 
$isAuthenticated = isset($_SESSION['user_id']);

if ($isAuthenticated) {
	require_once "./databases/auth_db.php";

	$userId = $_SESSION['user_id'];
	$stmt = mysqli_prepare($conn, "SELECT balance FROM users WHERE id = ?");
	mysqli_stmt_bind_param($stmt, "i", $userId);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($result)) {
		$balance = $row['balance'];
		$_SESSION['balance'] = $balance;
	} else {
		$balance = 0;
	}

	mysqli_stmt_close($stmt);
	mysqli_close($conn);
} else {
  $balance = 0;
}
?>


<header class="header">
	<div class="header__content">
		<a href="index.php" class="logo">Kantor Online</a>
		<nav class="nav">
			<ul class="nav__list">
				<li class="nav__item"><a href="cryptocurrencies.php" class="nav__link">Kryptowaluty</a></li>
				<li class="nav__item"><a href="currencies.php" class="nav__link">Waluty</a></li>
				<?php if(isset($_SESSION['user_id'])): ?>
					<li class="nav__item">
						<div class="user-menu">
							<a href="#" class="nav__link nav__link--login logout-btn" onclick="toggleMenu(event)">
								<?php echo htmlspecialchars($_SESSION['username']) . " (" . number_format($balance, 2) . "PLN)"; ?>
							</a>
							<div class="dropdown-menu" id="userDropdown">
									<a href="#" class="dropdown-item">Portfel</a>
									<a href="#" class="dropdown-item">Doładuj</a>
									<a href="logout.php" class="dropdown-item">Wyloguj się</a>
							</div>
					</div>
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