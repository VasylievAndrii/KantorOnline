<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kantor Online</title>
    <link rel="stylesheet" href="styles/styles.css" />
    <link rel="stylesheet" href="styles/auth.css" />
  </head>
  <body>
    <header class="header">
      <div class="header__content">
        <a href="index.php" class="logo">Kantor Online</a>
        <nav class="nav">
          <ul class="nav__list">
            <li class="nav__item"><a href="#" class="nav__link">Notowanie</a></li>
            <li class="nav__item"><a href="#" class="nav__link">O nas</a></li>
            <li class="nav__item"><a href="#" class="nav__link">Kontakt</a></li>
            <li class="nav__item"><a href="registration.php" class="nav__link nav__link--login">Rejestracja</a></li>
            <li class="nav__item"><a href="login.php" class="nav__link nav__link--login">Logowanie</a></li>
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
      <div class="main__auth-form-page">
        <h1 class="main__heading main__heading--auth">Logowanie</h1>
        <?php
          session_start();
          require_once "databases/auth_db.php";

          if (isset($_POST["submit"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $errors = array();
            if (empty($email) || empty($password)) {
              $errors[] = "Obydwa pola są wymagane";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $errors[] = "Adres e-mail jest nieprawidłowy";
            }
            if (count($errors) > 0) {
              echo '<div class="alert">';
							foreach ($errors as $error) {
								echo "<p class='alert-text danger'>$error</p>";
							}
							echo '</div>';
            } else {
              $sql = "SELECT * FROM users WHERE email = ?";
              if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_assoc($result);

                if ($user && password_verify($password, $user['password'])) {
                  $_SESSION['user_id'] = $user['id'];
                  $_SESSION['email'] = $user['email'];
                  echo "<div class='alert alert-success'>Login successful</div>";
                  header("Location: index.php");
                  exit();
                } else {
                  echo "<div class='alert'><p class='alert-text danger'>Nieprawidłowy adres e-mail lub hasło</p></div>";
                }
                mysqli_stmt_close($stmt);
              } else {
                echo "<div class='alert'><p class='alert-text danger'>Błąd podczas przetwarzania żądania</p></div>";
              }
            }
          }
        ?>
        <form action="login.php" method="post">
          <div class="main__auth-form-group">
            <label for="email" class="main__auth-label">E-mail:</label>
            <input class="main__auth-input" type="email" id="email" name="email" placeholder="E-mail" required>
          </div>
          <div class="main__auth-form-group">
            <label for="password" class="main__auth-label">Hasło:</label>
            <input class="main__auth-input" type="password" id="password" name="password" placeholder="Hasło" required>
          </div>
          <button class="main__auth-btn" type="submit" name="submit">Zaloguj się</button>
        </form>
        <p class="main__auth-suggest">Nie masz konta? <a href="registration.php" class="main__auth-suggest-link">Zarejestruj się!</a></p>
      </div>
    </main>

    <footer class="footer">
      <div class="footer__content">
        <p class="footer__created_by">Kamil Gręda, Tomasz Tapa, Andrii Vasyliev &copy; 2024</p>
      </div>
    </footer>
  </body>
</html>
