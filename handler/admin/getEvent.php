<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$eventId = $_GET['event_id'] ?? null;

if ($eventId) {
    $event = $adminObj->getEventById($eventId);
    echo json_encode($event);
} else {
    echo json_encode([]);
}
?>
