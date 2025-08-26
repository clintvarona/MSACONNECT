<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$collegeId = $_GET['college_id'] ?? null;

if ($collegeId) {
    $college = $adminObj->getCollegeById($collegeId);
    echo json_encode($college);
} else {
    echo json_encode([]);
}
?>
