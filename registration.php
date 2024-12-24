<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rejestracja - Kantor Online</title>
    <link rel="stylesheet" href="styles/styles.css" />
    <link rel="stylesheet" href="styles/auth.css" />
  </head>
  <body>
		<?php include('samples/header.php'); ?>

    <main class="main">
			<div class="main__auth-form-page">
				<h1 class="main__heading main__heading--auth">Rejestracja</h1>
				<?php
					if (isset($_POST["submit"])) {
						$login = trim($_POST["login"]);
						$email = trim($_POST["email"]);
						$password = $_POST["password"];
						$passwordRepeat = $_POST["repeat_password"];

						$passwordHash = password_hash($password, PASSWORD_DEFAULT);

						$errors = array();

						if (empty($login) || empty($email) || empty($password) || empty($passwordRepeat)) {
							$errors[] = "Wszystkie pola są wymagane";
						}
						if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
							$errors[] = "Adres e-mail jest nieprawidłowy";
						}
						if (strlen($password) < 8) {
							$errors[] = "Hasło musi mieć co najmniej 8 znaków";
						}
						if ($password !== $passwordRepeat) {
							$errors[] = "Hasła nie pasują";
						}
						if (!preg_match("/[A-Z]/", $password)) {
							$errors[] = "Hasło musi zawierać co najmniej jedną wielką literę";
						}
						if (!preg_match("/[0-9]/", $password)) {
							$errors[] = "Hasło musi zawierać przynajmniej jedną cyfrę";
						}
						if (!preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $password)) {
							$errors[] = "Hasło musi zawierać przynajmniej jeden znak specjalny";
						}
						if (!preg_match("/^[a-zA-Z0-9]+$/", $login)) {
							$errors[] = "Login może zawierać tylko litery i cyfry.";
						}

						require_once "databases/auth_db.php";

						$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
						mysqli_stmt_bind_param($stmt, "s", $email);
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);

						if (mysqli_num_rows($result) > 0) {
							$errors[] = "E-mail już istnieje!";
						}

						if (count($errors) > 0) {
							echo '<div class="alert">';
							foreach ($errors as $error) {
								echo "<p class='alert-text danger'>$error</p>";
							}
							echo '</div>';
						} else {
							$stmt = mysqli_prepare($conn, "INSERT INTO users (login, email, password, balance) VALUES (?, ?, ?, ?)");
							if ($stmt) {
									$initialBalance = 0;
									mysqli_stmt_bind_param($stmt, "sssd", $login, $email, $passwordHash, $initialBalance);
									if (mysqli_stmt_execute($stmt)) {
											echo "<div class='alert'>
															<p class='alert-text success'>Rejestracja zakończona sukcesem!</p>
														</div>";
									} else {
											echo "<div class='alert'>
															<p class='alert-text danger'>Wystąpił błąd podczas rejestracji</p>
														</div>";
									}
									mysqli_stmt_close($stmt);
							} else {
									echo "<div class='alert'>
													<p class='alert-text danger'>Błąd przygotowania zapytania</p>
												</div>";
							}
						}

						mysqli_close($conn);
					}
				?>
				<form action="registration.php" method="post">
					<div class="main__auth-form-group">
						<label for="login" class="main__auth-label">Login:</label>
						<input class="main__auth-input" type="text" id="login" name="login" placeholder="Login" required>
						<small class="main__registration-criteria">Login może zawierać wyłącznie litery alfabetu angielskiego i cyfry.</small>
					</div>
					<div class="main__auth-form-group">
						<label for="email" class="main__auth-label">E-mail:</label>
						<input class="main__auth-input" type="email" id="email" name="email" placeholder="E-mail" required>
					</div>
					<div class="main__auth-form-group">
						<label for="password" class="main__auth-label">Hasło:</label>
						<input class="main__auth-input" type="password" id="password" name="password" placeholder="Hasło" required>
						<small class="main__registration-criteria">Hasło musi mieć co najmniej 8 znaków, zawierać litery i cyfry oraz zaczynać się od litery</small>
					</div>
					<div class="main__auth-form-group">
						<label for="repeat_password" class="main__auth-label">Potwierdzenie hasła:</label>
						<input class="main__auth-input" type="password" id="repeat_password" name="repeat_password" placeholder="Potwierdzenie hasła" required>
					</div>
					<button class="main__auth-btn" type="submit" name="submit">Zarejestrować się</button>
				</form>
				<p class="main__auth-suggest">Masz już konto? <a href="login.php" class="main__auth-suggest-link">Zaloguj się!</a></p>
			</div>
		</main>

    <?php include('samples/footer.php'); ?>
		<script src="scripts/script.js"></script>
  </body>
</html>
