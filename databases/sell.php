<?php
session_start();
require_once "auth_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION["user_id"])) {
        echo json_encode(["status" => "error", "message" => "Użytkownik nie jest zalogowany"]);
        exit;
    }

    $userId = $_SESSION["user_id"];
    $currency = trim($_POST["currency"]);
    $amount = floatval($_POST["amount"]);
    $rate = floatval($_POST["rate"]);

    if ($amount <= 0 || empty($currency) || $rate <= 0) {
        echo json_encode(["status" => "error", "message" => "Nieprawidłowe dane do sprzedaży"]);
        exit;
    }

    $totalGain = $amount * $rate; 

    mysqli_begin_transaction($conn);
    try {
        $checkWalletQuery = "SELECT id, amount FROM users_wallet WHERE user_id = ? AND currency = ?";
        $stmt = mysqli_prepare($conn, $checkWalletQuery);
        if (!$stmt) {
            throw new Exception("Błąd podczas przygotowywania zapytania: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "is", $userId, $currency);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $wallet = mysqli_fetch_assoc($result);

        if (!$wallet || $wallet['amount'] < $amount) {
            throw new Exception("Niewystarczająca ilość waluty do sprzedaży");
        }

        $newAmount = $wallet['amount'] - $amount;

        if ($newAmount > 0) {
            $updateWalletQuery = "UPDATE users_wallet SET amount = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $updateWalletQuery);
            if (!$stmt) {
                throw new Exception("Błąd podczas przygotowywania zapytania: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "di", $newAmount, $wallet['id']);
            mysqli_stmt_execute($stmt);
        } else {
            $deleteWalletQuery = "DELETE FROM users_wallet WHERE id = ?";
            $stmt = mysqli_prepare($conn, $deleteWalletQuery);
            if (!$stmt) {
                throw new Exception("Błąd podczas przygotowywania zapytania: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "i", $wallet['id']);
            mysqli_stmt_execute($stmt);
        }

        $updateBalanceQuery = "UPDATE users SET balance = balance + ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updateBalanceQuery);
        if (!$stmt) {
            throw new Exception("Błąd podczas przygotowywania zapytania: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "di", $totalGain, $userId);
        mysqli_stmt_execute($stmt);

        $insertSellQuery = "INSERT INTO sold_currencies (user_id, currency, amount, rate, transaction_id) VALUES (?, ?, ?, ?, ?)";
        $transactionId = uniqid("txn_");
        $stmt = mysqli_prepare($conn, $insertSellQuery);
        if (!$stmt) {
            throw new Exception("Błąd podczas przygotowywania zapytania: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "isdss", $userId, $currency, $amount, $rate, $transactionId);
        mysqli_stmt_execute($stmt);

        $getBalanceQuery = "SELECT balance FROM users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $getBalanceQuery);
        if (!$stmt) {
            throw new Exception("Błąd podczas przygotowywania zapytania: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if (!$user) {
            throw new Exception("Nie można pobrać salda użytkownika");
        }

        mysqli_commit($conn);

        echo json_encode([
            "status" => "success",
            "message" => "Waluta została pomyślnie sprzedana",
            "new_balance" => $user["balance"]
        ]);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
