<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$programId = $_GET['program_id'] ?? null;

if ($programId) {
    $program = $adminObj->getProgramById($programId);
    echo json_encode($program);
} else {
    echo json_encode([]);
}
?>
