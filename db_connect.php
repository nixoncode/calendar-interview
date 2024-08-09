<?php

$db_host = 'localhost';
$db_name = 'vesen_calendar';
$db_user = 'nixon';
$db_pass = 'password';



try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    migrateTable($pdo);
    seedTable($pdo);
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function migrateTable($pdo) {
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        calendar VARCHAR(30) NOT NULL,
        start DATETIME NOT NULL,
        end DATETIME NOT NULL,
        url VARCHAR(255),
        location varchar(255),
        guests TEXT,
        description TEXT,
        allDay BOOLEAN DEFAULT FALSE
    );
SQL;
    
    $pdo->exec($sql);
}


function seedTable($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM events");
    $count = $stmt->fetchColumn();
    
    
    if ($count > 0) {
        return;
    }
    $insertStmt = $pdo->prepare(
        "INSERT INTO events (id, title, start, end, calendar, allDay) VALUES (:id, :title, :start, :end, :calendar, :allDay)"
    );
    
    foreach (generateEvents() as $event) {
        $event['allDay'] = $event['allDay'] ? 1 : 0; // pdo can't parse booleans automatically
        $insertStmt->execute($event);
    }
}


function generateEvents() {
    $date = new DateTime();
    
    // calc the next day
    $nextDay = new DateTime();
    $nextDay->modify('+1 day');
    
    // calc the first day of the next month
    $nextMonth = new DateTime();
    if ($nextMonth->format('m') == 12) { // ff it's December
        $nextMonth->modify('first day of next year');
    } else {
        $nextMonth->modify('first day of next month');
    }
    
    // calc the first day of the previous month
    $prevMonth = new DateTime();
    if ($prevMonth->format('m') == 1) { // if it's January
        $prevMonth->modify('first day of last year');
    } else {
        $prevMonth->modify('first day of last month');
    }
    
    return [
        [
            'id'       => 1,
            'title'    => "Design Review",
            'start'    => $date->format('Y-m-d H:i:s'),
            'end'      => $nextDay->format('Y-m-d H:i:s'),
            'allDay'   => false,
            'calendar' => "Business",
        ],
        [
            'id'       => 2,
            'title'    => "Meeting With Client",
            'start'    => $date->modify('-11 days')->format('Y-m-d H:i:s'),
            'end'      => $date->modify('+1 day')->format('Y-m-d H:i:s'),
            'allDay'   => true,
            'calendar' => "Business",
        ],
        [
            'id'       => 3,
            'title'    => "Family Trip",
            'allDay'   => true,
            'start'    => $date->modify('-2 days')->format('Y-m-d H:i:s'),
            'end'      => $date->modify('+2 days')->format('Y-m-d H:i:s'),
            'calendar' => "Holiday",
        ],
        [
            'id'       => 4,
            'title'    => "Doctor's Appointment",
            'start'    => $date->modify('-11 days')->format('Y-m-d H:i:s'),
            'end'      => $date->modify('+1 day')->format('Y-m-d H:i:s'),
            'calendar' => "Personal",
            'allDay'   => false,
        ],
        [
            'id'       => 5,
            'title'    => "Dart Game?",
            'start'    => $date->modify('-2 days')->format('Y-m-d H:i:s'),
            'end'      => $date->modify('+1 day')->format('Y-m-d H:i:s'),
            'allDay'   => true,
            'calendar' => "ETC",
        ],
        [
            'id'       => 6,
            'title'    => "Meditation",
            'start'    => $date->format('Y-m-d H:i:s'),
            'end'      => $date->format('Y-m-d H:i:s'),
            'allDay'   => true,
            'calendar' => "Personal",
        ],
        [
            'id'       => 7,
            'title'    => "Dinner",
            'start'    => $date->format('Y-m-d H:i:s'),
            'end'      => $date->format('Y-m-d H:i:s'),
            'calendar' => "Family",
            'allDay'   => false,
        ],
        [
            'id'       => 8,
            'title'    => "Product Review",
            'start'    => $date->format('Y-m-d H:i:s'),
            'end'      => $date->format('Y-m-d H:i:s'),
            'allDay'   => true,
            'calendar' => "Business",
        ],
        [
            'id'       => 9,
            'title'    => "Monthly Meeting",
            'start'    => $nextMonth->format('Y-m-d H:i:s'),
            'end'      => $nextMonth->format('Y-m-d H:i:s'),
            'allDay'   => true,
            'calendar' => "Business",
        ],
        [
            'id'       => 10,
            'title'    => "Monthly Checkup",
            'start'    => $prevMonth->format('Y-m-d H:i:s'),
            'end'      => $prevMonth->format('Y-m-d H:i:s'),
            'allDay'   => true,
            'calendar' => "Personal",
        ],
    ];
}