<?php
session_start();
require_once "auth_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
  }

  $userId = $_SESSION["user_id"]; 
  $currency = trim($_POST["currency"]); 
  $amount = floatval($_POST["amount"]); 
  $rate = floatval($_POST["rate"]); 

  if ($amount <= 0 || empty($currency) || $rate <= 0) {
    echo json_encode(["status" => "error", "message" => "Nieprawidłowe informacje o zakupie"]);
    exit;
  }

  $totalCost = $amount * $rate; 

  $query = "SELECT balance FROM users WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $userId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);

  if (!$user || $user["balance"] < $totalCost) {
      echo json_encode(["status" => "error", "message" => "Niewystarczające środki na saldzie"]);
      exit;
  }

  $newBalance = $user["balance"] - $totalCost;

  mysqli_begin_transaction($conn);
  try {
    $updateBalanceQuery = "UPDATE users SET balance = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateBalanceQuery);
    mysqli_stmt_bind_param($stmt, "di", $newBalance, $userId);
    mysqli_stmt_execute($stmt);

    $insertPurchaseQuery = "INSERT INTO purchased_currencies (user_id, currency, amount, transaction_id) VALUES (?, ?, ?, ?)";
    $transactionId = uniqid("txn_");
    $stmt = mysqli_prepare($conn, $insertPurchaseQuery);
    mysqli_stmt_bind_param($stmt, "isds", $userId, $currency, $amount, $transactionId);
    mysqli_stmt_execute($stmt);

    $checkWalletQuery = "SELECT id, amount FROM users_wallet WHERE user_id = ? AND currency = ?";
    $stmt = mysqli_prepare($conn, $checkWalletQuery);
    mysqli_stmt_bind_param($stmt, "is", $userId, $currency);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      $newAmount = $row['amount'] + $amount;
      $updateWalletQuery = "UPDATE users_wallet SET amount = ? WHERE id = ?";
      $stmt = mysqli_prepare($conn, $updateWalletQuery);
      mysqli_stmt_bind_param($stmt, "di", $newAmount, $row['id']);
      mysqli_stmt_execute($stmt);
    } else {
      $insertWalletQuery = "INSERT INTO users_wallet (user_id, currency, amount) VALUES (?, ?, ?)";
      $stmt = mysqli_prepare($conn, $insertWalletQuery);
      mysqli_stmt_bind_param($stmt, "isd", $userId, $currency, $amount);
      mysqli_stmt_execute($stmt);
    }

    mysqli_commit($conn);

    echo json_encode(["status" => "success", "message" => "Waluta została pomyślnie zakupiona", "new_balance" => $newBalance]);
    } catch (Exception $e) {
      mysqli_rollback($conn);
      echo json_encode(["status" => "error", "message" => "Błąd podczas przetwarzania zakupu"]);
    }
}
?>
