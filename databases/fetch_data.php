<?php
include('kryptowaluty.php'); 

header('Content-Type: application/json');

$code = isset($_GET['code']) ? strtoupper($_GET['code']) : null;

$query_usd_to_pln = "SELECT rate FROM kursy_fiat_historyczne WHERE code = 'USD' ORDER BY data DESC, czas DESC LIMIT 1";
$result_usd_to_pln = mysqli_query($conn, $query_usd_to_pln);
$usd_to_pln = mysqli_fetch_assoc($result_usd_to_pln)['rate'];

if ($code) {
    $query_history = "SELECT CONCAT(data, ' ', czas) AS datetime, rate FROM {$code}_usd_historyczne WHERE data >= DATE_SUB(NOW() , INTERVAL 2 DAY);"; 
    $result_history = mysqli_query($conn, $query_history);
    $history = mysqli_fetch_all($result_history, MYSQLI_ASSOC);

    $query_prediction = "SELECT CONCAT(data, ' ', czas) AS datetime, rate FROM {$code}_usd_predykcja WHERE data >= DATE_SUB(NOW() , INTERVAL 2 DAY)";
    $result_prediction = mysqli_query($conn, $query_prediction);
    $prediction = mysqli_fetch_all($result_prediction, MYSQLI_ASSOC);

    echo json_encode([
        'usd_to_pln' => $usd_to_pln,
        'history' => $history,
        'prediction' => $prediction
    ]);

    mysqli_free_result($result_history);
    mysqli_free_result($result_prediction);
} else {
    $request_fiat = mysqli_query($conn, 'SELECT * FROM kursy_fiat_historyczne ORDER BY data DESC, czas DESC LIMIT 66');
    $kursy_fiat = mysqli_fetch_all($request_fiat, MYSQLI_ASSOC);

    $request_krypto = mysqli_query($conn, 'SELECT * FROM kursy_krypto ORDER BY data DESC, czas DESC LIMIT 10');
    $kursy_krypto = mysqli_fetch_all($request_krypto, MYSQLI_ASSOC);

    echo json_encode([
        'usd_to_pln' => $usd_to_pln,
        'fiat' => $kursy_fiat,
        'krypto' => $kursy_krypto
    ]);

    mysqli_free_result($request_fiat);
    mysqli_free_result($request_krypto);
}
mysqli_close($conn);
?>
