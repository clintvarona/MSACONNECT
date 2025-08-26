<?php
 session_start();
 require_once '../../classes/adminClass.php';
 
 $adminObj = new Admin();
 $response = '';
 
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if (!isset($_SESSION['user_id'])) {
         echo 'error: unauthorized';
         exit;
     }
 
     $adminUserId = $_SESSION['user_id'];
     $volunteerId = $_POST['volunteer_id'] ?? null;
     $action = $_POST['action'] ?? null;
 
     if (!$volunteerId || !$action) {
         echo 'error: missing_data';
         exit;
     }
 
     if ($action === 'approve') {
         $isApproved = $adminObj->approveVolunteer($volunteerId, $adminUserId);
         $response = $isApproved ? 'success' : 'error: db_approve_fail';
     } elseif ($action === 'reject') {
         $isRejected = $adminObj->rejectVolunteer($volunteerId, $adminUserId);
         $response = $isRejected ? 'success' : 'error: db_reject_fail';
     } else {
         $response = 'error: invalid_action';
     }
 
     echo $response;
     exit;
 }
 ?>