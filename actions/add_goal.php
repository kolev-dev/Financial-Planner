<?php
session_start();
require '../includes/db.php'; // Връщаме се едно ниво назад за връзка с базата

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $target_amount = $_POST['target_amount'];
    $deadline = $_POST['deadline'];
    
    // Проверка за чекбокса
    $is_invested = isset($_POST['is_invested']) ? 1 : 0;
    $expected_return = isset($_POST['expected_return']) ? $_POST['expected_return'] : 0;

    try {
        $stmt = $pdo->prepare("INSERT INTO financial_goals (user_id, title, target_amount, current_amount, deadline, is_invested, expected_return) VALUES (?, ?, ?, 0, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $target_amount, $deadline, $is_invested, $expected_return]);
        
        // Пренасочване обратно към страницата с цели
        header("Location: ../goals.php?success=1");
        exit();
    } catch (PDOException $e) {
        die("Грешка при запис: " . $e->getMessage());
    }
} else {
    header("Location: ../goals.php");
    exit();
}