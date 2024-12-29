<?php
  session_start();

  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
  }

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "auth";

  try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id']; 

    $currenciesList = ["USD", "EUR", "GBP", "JPY", "PLN", "CHF", "AUD", "CAD", "SEK", "NOK", "DKK", "CZK", "HUF", "RUB", "CNY", "INR", "MXN", "BRL", "ZAR", "SGD", "HKD", "NZD", "TRY", "KRW", "MYR", "IDR", "THB", "SAR", "AED", "ILS", "ARS", "CLP", "PEN", "COP", "VND", "PKR", "BGN", "PHP", "RON", "ISK", "UAH", "XDR"];
    $cryptocurrenciesList = ["BTC", "ETH", "LTC", "XRP", "BCH"];

    $query = "SELECT currency, amount FROM users_wallet WHERE user_id = $user_id";
    $result = $conn->query($query);

    $currencies = [];
    $cryptocurrencies = [];
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        if (in_array($row['currency'], $currenciesList)) {
          $currencies[] = $row;
        } elseif (in_array($row['currency'], $cryptocurrenciesList)) {
          $cryptocurrencies[] = $row;
        }
      }
    }
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
  }
?>