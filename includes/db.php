<?php
$host = 'localhost';
$dbname = 'financial_planner';
$username = 'root'; 
$password = '1234';     

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Грешка при свързване: " . $e->getMessage());
}
?>