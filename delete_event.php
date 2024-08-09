<?php

require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing event ID']);
    exit();
}
$eventId = (int) $_GET['id'];

try {
    $sql = "DELETE FROM events WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    
    echo json_encode(['message' => 'Event deleted successfully']);
    
} catch (PDOException $e) {
    error_log("Database Error while deleting event: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while deleting the event ']);
}