<?php
  include('kryptowaluty.php');

	$request_fiat = mysqli_query($conn, 'SELECT * FROM kursy_fiat ORDER BY data DESC, czas DESC LIMIT 66');
	$kursy_fiat = mysqli_fetch_all($request_fiat, MYSQLI_ASSOC);

  $request_krypto = mysqli_query($conn, 'SELECT * FROM kursy_krypto ORDER BY data DESC, czas DESC LIMIT 10');
  $kursy_krypto = mysqli_fetch_all($request_krypto, MYSQLI_ASSOC);

  header('Content-Type: application/json');

  $kursy = [
    'fiat' => $kursy_fiat,
    'krypto' => $kursy_krypto
  ];

  echo json_encode($kursy);

  mysqli_free_result($request_fiat);
  mysqli_free_result($request_krypto);
  mysqli_close($conn);
?>