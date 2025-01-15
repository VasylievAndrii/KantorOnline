<?php
  session_start();

  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
  }

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname_wallet = "auth";
  $dbname_rates = "kryptowaluty";

  try {
    $conn_wallet = new mysqli($servername, $username, $password, $dbname_wallet);
    $conn_rates = new mysqli($servername, $username, $password, $dbname_rates);

    if ($conn_wallet->connect_error || $conn_rates->connect_error) {
      throw new Exception("Database connection failed");
    }

    $user_id = $_SESSION['user_id']; 

    $currenciesList = ["USD", "EUR", "GBP", "JPY", "PLN", "CHF", "AUD", "CAD", "SEK", "NOK", "DKK", "CZK", "HUF", "RUB", "CNY", "INR", "MXN", "BRL", "ZAR", "SGD", "HKD", "NZD", "TRY", "KRW", "MYR", "IDR", "THB", "SAR", "AED", "ILS", "ARS", "CLP", "PEN", "COP", "VND", "PKR", "BGN", "PHP", "RON", "ISK", "UAH", "XDR"];
    $cryptocurrenciesList = ["BTC", "ETH", "LTC", "XRP", "BCH"];

    $query_usd_to_pln = "SELECT rate FROM kursy_fiat_historyczne WHERE code = 'USD' ORDER BY data DESC, czas DESC LIMIT 1";
    $result_usd = $conn_rates->query($query_usd_to_pln);

    if ($result_usd->num_rows > 0) {
      $row = $result_usd->fetch_assoc();
      $usdToPlnRate = $row['rate'];
    }

    $query = "SELECT currency, amount FROM users_wallet WHERE user_id = $user_id";
    $result = $conn_wallet->query($query);

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

    $currencyRates = [];
    $query_fiat = "SELECT code, rate FROM kursy_fiat_historyczne ORDER BY data DESC, czas DESC LIMIT 33";
    $result_fiat = $conn_rates->query($query_fiat);

    if ($result_fiat->num_rows > 0) {
      while ($row = $result_fiat->fetch_assoc()) {
        $currencyRates[$row['code']] = $row['rate'];
      }
    }

    $cryptoRates = [];
    $query_crypto = "SELECT code, rate FROM kursy_krypto ORDER BY data DESC, czas DESC LIMIT 5";
    $result_crypto = $conn_rates->query($query_crypto);

    if ($result_crypto->num_rows > 0) {
      while ($row = $result_crypto->fetch_assoc()) {
        $cryptoRates[$row['code']] = $row['rate'] * $usdToPlnRate; 
      }
    }

  $totalBalance = 0;

  foreach ($currencies as $currency) {
    $rate = $currencyRates[$currency['currency']] ?? 0;
    $totalBalance += $rate * $currency['amount'];
  }

  foreach ($cryptocurrencies as $crypto) {
    $rate = $cryptoRates[$crypto['currency']] ?? 0;
    $totalBalance += $rate * $crypto['amount'];
  }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
