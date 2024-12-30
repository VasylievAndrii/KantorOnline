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
								<i class="fas fa-user"></i>
								<?php echo htmlspecialchars($_SESSION['username']) . " (" . number_format($balance, 2) . "PLN)"; ?>
							</a>
							<div class="dropdown-menu" id="userDropdown">
									<a href="wallet.php" class="dropdown-item">Portfel</a>
									<a href="javascript:void(0);" class="dropdown-item" onclick="openModal()">Doładuj / Wypłać</a>
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

		<div id="modal" class="modal">
			<div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <div class="modal-tabs">
					<div class="modal-tab active" data-tab="modal-deposit" onclick="switchModalTab('modal-deposit')">Doładuj</div>
					<div class="modal-tab" data-tab="modal-withdraw" onclick="switchModalTab('modal-withdraw')">Wypłać</div>
        </div>
        <div id="modal-deposit" class="modal-tab-content active">
					<form id="depositForm" onsubmit="handleModalTransaction(event, 'deposit')">
						<label for="depositAmount">Kwota doładowania:</label>
						<input type="number" id="depositAmount" name="amount" step="0.01" required>
						<button type="submit" class="primary-button">Potwierdź</button>
					</form>
        </div>
        <div id="modal-withdraw" class="modal-tab-content">
					<form id="withdrawForm" onsubmit="handleModalTransaction(event, 'withdraw')">
						<label for="withdrawAmount">Kwota wypłaty:</label>
						<input type="number" id="withdrawAmount" name="amount" step="0.01" required>
						<button type="submit" class="primary-button">Potwierdź</button>
					</form>
        </div>
			</div>
		</div>
	</div>
</header>