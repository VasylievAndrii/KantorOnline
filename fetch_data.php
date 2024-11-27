<?php
  include('database.php');

	$request = mysqli_query($conn, 'SELECT * FROM kursy');
	$krypto = mysqli_fetch_all($request, MYSQLI_ASSOC);
	$lastRow = end($krypto); 
  
  $request = mysqli_query($conn, 'SELECT * FROM kursy ORDER BY data DESC LIMIT 2');
  $lastTwoRows = mysqli_fetch_all($request, MYSQLI_ASSOC);

  echo "<script> var prices = " . json_encode($lastTwoRows) . "; </script>";

  mysqli_free_result($request);
  mysqli_close($conn);
?>