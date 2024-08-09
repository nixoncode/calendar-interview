<?php

require_once 'db_connect.php';
require_once 'functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

$event = parseEventInput();


$sql = <<<SQL
INSERT INTO events (title, start, end, url, allDay, calendar, guests, description, location)
VALUES (:title, :start, :end, :url, :allDay, :calendar, :guests, :description, :location)
SQL;

try {

    $stmt = $pdo->prepare($sql);
    $stmt->execute($event);
    $id = $pdo->lastInsertId();
    
    http_response_code(201);
    echo json_encode(['message' => 'Event added successfully', 'id' => $id]);
} catch (PDOException $e) {
    error_log("Database Error when adding event: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while adding the event']);
}