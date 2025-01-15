<?php
  include('kryptowaluty.php'); 

  header('Content-Type: application/json');
  $query_usd_to_pln = "SELECT rate FROM kursy_fiat_historyczne WHERE code = 'USD' ORDER BY data DESC, czas DESC LIMIT 1";
  $result_usd_to_pln = mysqli_query($conn, $query_usd_to_pln);
  $usd_to_pln = mysqli_fetch_assoc($result_usd_to_pln)['rate'];

  $query_history_usd = "SELECT CONCAT(data, ' ', czas) AS datetime, rate FROM kursy_fiat_historyczne 
                        WHERE code = 'USD' AND data >= DATE_SUB(NOW(), INTERVAL 1 week)";
  $result_history_usd = mysqli_query($conn, $query_history_usd);
  $history_usd = mysqli_fetch_all($result_history_usd, MYSQLI_ASSOC);

  $query_history_btc = "SELECT CONCAT(data, ' ', czas) AS datetime, rate FROM btc_usd_historyczne 
                        WHERE data >= DATE_SUB(NOW() , INTERVAL 3 DAY)";
  $result_history_btc = mysqli_query($conn, $query_history_btc);
  $history_btc = mysqli_fetch_all($result_history_btc, MYSQLI_ASSOC);

  $query_prediction_btc = "SELECT CONCAT(data, ' ', czas) AS datetime, rate FROM btc_usd_predykcja 
                          WHERE data >= DATE_SUB(NOW(), INTERVAL 3 DAY)";
  $result_prediction_btc = mysqli_query($conn, $query_prediction_btc);
  $prediction_btc = mysqli_fetch_all($result_prediction_btc, MYSQLI_ASSOC);

  $query_actual_btc = "SELECT rate FROM kursy_krypto WHERE code = 'BTC' ORDER BY data DESC, czas DESC LIMIT 1";
  $result_actual_btc = mysqli_query($conn, $query_actual_btc);
  $actual_btc = mysqli_fetch_assoc($result_actual_btc)['rate'];

  echo json_encode([
      'usd' => [
        'usd_to_pln' => $usd_to_pln,
        'usd_history' => $history_usd,
      ],
      'btc' => [
          'actual' => $actual_btc,
          'history' => $history_btc,
          'prediction' => $prediction_btc
      ]
  ]);

  mysqli_free_result($result_usd_to_pln);
  mysqli_free_result($result_history_usd);
  mysqli_free_result($result_history_btc);
  mysqli_free_result($result_prediction_btc);
  mysqli_free_result($result_actual_btc);

  mysqli_close($conn);
?>
