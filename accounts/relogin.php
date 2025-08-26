<?php session_start(); session_destroy(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Please Relogin</title>
    <link rel="stylesheet" href="../css/relogin.css">
</head>
<body>
    <div class="container">
        <h2>Session Expired</h2>
        <p>Your session has expired. Please log in again to continue.</p>
        <a href="login" class="btn">Login</a>
    </div>
</body>
</html>
