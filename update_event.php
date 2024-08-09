<?php

require_once 'db_connect.php';
require_once 'functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
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


$event = parseEventInput();

$sql = <<<SQL
UPDATE events
SET title = :title, start = :start, end = :end, url = :url, allDay = :allDay, calendar = :calendar, guests = :guests,
    description = :description, location = :location
WHERE id = :id
SQL;

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($event + ['id' => $eventId]);
    
    echo json_encode(['message' => 'Event updated successfully']);
} catch (PDOException $e) {
    error_log("Database Error when updating event: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while updating the event']);
}
