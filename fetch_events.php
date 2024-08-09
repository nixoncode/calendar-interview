<?php

require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

try {
    $sql = "SELECT * FROM events";
    $stmt = $pdo->query($sql);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
    $events = array_map('transformEventResource', $events);
    
    
    echo json_encode($events);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => "Database Error: " . $e->getMessage()]);
}

function transformEventResource($event) {
    $extendedProps = [
        'calendar'    => $event['calendar'],
        'description' => $event['description'],
        'guests'      => isset($event['guests']) ? explode(',', $event['guests']) : [],
        'location'    => $event['location'],
    ];
    
    // remove the original description, guests, and location keys
    unset($event['description'], $event['guests'], $event['location']);
    // update the extendedProps
    $event['extendedProps'] = $extendedProps;
    $event['allDay'] = ($event['allDay'] == 1); // pdo still can't parse tinyint to boolean
    $event['url'] = $event['url'] == null ? '' : $event['url'];
    
    return $event;
}
