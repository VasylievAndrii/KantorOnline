<?php
  $servername = "localhost"; 
  $username = "root"; 
  $password = "";
  $dbname = "kryptowaluty"; 
  
  try{
    $conn = new mysqli($servername, $username, $password, $dbname);
  } catch (mysqli_sql_exception $e) {
    echo "Could not connect: " . $e->getMessage();
    exit();
  }
?>