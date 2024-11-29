<?php
  include('database.php');

	$request = mysqli_query($conn, 'SELECT * FROM kursy_fiat ORDER BY data DESC, czas DESC LIMIT 33');
	$kursy_fiat = mysqli_fetch_all($request, MYSQLI_ASSOC);

  $request = mysqli_query($conn, 'SELECT * FROM kursy_krypto ORDER BY data DESC, czas DESC LIMIT 10');
  $kursy_krypto = mysqli_fetch_all($request, MYSQLI_ASSOC);

  echo "<script>
          var kursy = {fiat: " . json_encode($kursy_fiat) . ",
                      krypto: " . json_encode($kursy_krypto) . "};
        </script>";

  mysqli_free_result($request);
  mysqli_close($conn);
?>