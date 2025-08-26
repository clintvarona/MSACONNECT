<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$fileId = $_GET['file_id'] ?? null;

if ($fileId) {
    $file = $adminObj->getFileById($fileId);
    echo json_encode($file);
} else {
    echo json_encode([]);
}
?>