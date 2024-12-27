<?php
  include('kryptowaluty.php');

  header('Content-Type: application/json');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $code = isset($_GET['code']) ? strtoupper($_GET['code']) : null;

  if ($code) {
    $query_fiat_history = "SELECT CONCAT(data, ' ', czas) AS datetime, rate FROM kursy_fiat_historyczne WHERE code = '{$code}' AND data >= DATE_SUB('2024-12-19', INTERVAL 1 week)"; //'2024-12-19' => 22CURDATE() 

    $result_fiat_history = mysqli_query($conn, $query_fiat_history);
    $fiat_history = mysqli_fetch_all($result_fiat_history, MYSQLI_ASSOC);

    echo json_encode(['history' => $fiat_history]);

    mysqli_free_result($result_fiat_history);
    mysqli_close($conn);
  }
?>
