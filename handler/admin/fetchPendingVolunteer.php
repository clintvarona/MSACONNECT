<?php
require_once '../../classes/adminClass.php';

$adminObj = new Admin();
$result = $adminObj->fetchPendingVolunteer();

if ($result) {
    $data = [];
    foreach ($result as $row) {
        $data[] = [
            'full_name' => $row['full_name'],
            'program_name' => $row['program_name'],
            'yr_section' => $row['yr_section'],
            'contact' => $row['contact'],
            'email' => $row['email'],
            'cor' => $row['cor'],
            'status' => $row['status'],
            'volunteer_id' => $row['volunteer_id']
        ];
    }
    echo json_encode(['data' => $data]);
} else {
    echo json_encode(['data' => []]);
}
?>