<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Nie zalogowany']);
    exit();
}

require_once "auth_db.php";

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? null;
    $amount = floatval($data['amount'] ?? 0);
    $userId = $_SESSION['user_id'];

    if (!$action || $amount <= 0) {
        throw new Exception("Nieprawidłowe dane transakcji");
    }

    // Получение текущего баланса
    $stmt = $conn->prepare("SELECT balance FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        throw new Exception("Nie znaleziono użytkownika");
    }

    $currentBalance = floatval($row['balance']);

    // Обновление баланса
    if ($action === 'deposit') {
        $newBalance = $currentBalance + $amount;
    } elseif ($action === 'withdraw') {
        if ($currentBalance < $amount) {
            throw new Exception("Brak wystarczających środków na koncie");
        }
        $newBalance = $currentBalance - $amount;
    } else {
        throw new Exception("Nieprawidłowe działanie");
    }

    // Запись нового баланса в базу данных
    $stmt = $conn->prepare("UPDATE users SET balance = ? WHERE id = ?");
    $stmt->bind_param("di", $newBalance, $userId);
    $stmt->execute();

    echo json_encode(['success' => true, 'newBalance' => $newBalance]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
