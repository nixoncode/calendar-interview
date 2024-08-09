<?php
/**
 * Created by PhpStorm.
 * User: nixon
 * Date: 09/08/2024
 * Time: 16:50
 */

function validateAndConvertToMySQLDate($dateString) {
    $timestamp = strtotime($dateString);
    
    if ($timestamp !== false) {
        return date('Y-m-d H:i:s', $timestamp);
    } else {
        return false;
    }
}


/**
 * @return array|void
 */
function parseEventInput() {
    $eventData = json_decode(file_get_contents('php://input'), true);
    
    if (empty($eventData['title']) || empty($eventData['start']) || empty($eventData['end'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit();
    }
    
    $start = validateAndConvertToMySQLDate($eventData['start']);
    $end = validateAndConvertToMySQLDate($eventData['end']);
    if (!$start || !$end) {
        http_response_code(422);
        echo json_encode(['error' => 'Invalid start or end date']);
        exit();
    }
    
    
    $title = htmlspecialchars($eventData['title']);
    
    $url = isset($eventData['url']) ? htmlspecialchars($eventData['url']) : null;
    $allDay = isset($eventData['allDay']) && $eventData['allDay'] ? 1 : 0; // convert boolean to tinyint
    $calendar = htmlspecialchars($eventData['calendar']);
    $guests = isset($eventData['guests']) ? htmlspecialchars(implode(',', $eventData['guests'])) : null;
    $description = isset($eventData['description']) ? htmlspecialchars($eventData['description']) : null;
    $location = isset($eventData['location']) ? htmlspecialchars($eventData['location']) : null;
    
    
    return [
        'title'       => $title,
        'start'       => $start,
        'end'         => $end,
        'url'         => $url,
        'allDay'      => $allDay,
        'calendar'    => $calendar,
        'guests'      => $guests,
        'description' => $description,
        'location'    => $location,
    ];
}