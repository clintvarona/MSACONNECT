<?php
require_once '../tools/function.php';
require_once '../classes/accountClass.php';

session_start();

$accountObj = new Account();
$positions = $accountObj->fetchOfficerPositions();

$first_name = $last_name = $middle_name = $username = $password = $email = $position = '';
$first_nameErr = $last_nameErr = $usernameErr = $passwordErr = $emailErr = $positionErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = clean_input($_POST['firstname']);
    $last_name = clean_input($_POST['lastname']);
    $middle_name = clean_input($_POST['middlename']);
    $username = clean_input($_POST['username']);
    $email = clean_input($_POST['email']);
    $position = clean_input($_POST['position']);
    $password = clean_input($_POST['password']);

    if (empty($first_name)) $first_nameErr = "First name is required!";
    if (empty($last_name)) $last_nameErr = "Last name is required!";
    if (empty($username)) {
        $usernameErr = "Username is required!";
    } elseif ($accountObj->usernameExist($username)) {
        $usernameErr = "Username already taken!";
    }
    if (empty($email)) {
        $emailErr = "Email is required!";
    } elseif ($accountObj->emailExist($email)) {
        $emailErr = "Email already taken!";
    } elseif (!$accountObj->validateEmail($email)) {
        $emailErr = "Please use WMSU email!";
    }
    if (empty($password)) {
        $passwordErr = "Password is required!";
    } elseif (!$accountObj->validatePassword($password)) {
        $passwordErr = "Password must be at least 8 characters!";
    }
    if (empty($position)) {
        $positionErr = "Please select a position!";
    }

    if (empty($first_nameErr) && empty($last_nameErr) && empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($positionErr)) {
        $accountObj->first_name = $first_name;
        $accountObj->last_name = $last_name;
        $accountObj->middle_name = $middle_name;
        $accountObj->username = $username;
        $accountObj->email = $email;
        $accountObj->position = $position;
        $accountObj->password = $password;
        $accountObj->signup();

        header("location: ../views/admin/admin_dashboard");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <?php include '../includes/head.php'; ?> 
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    <div class="text-start mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary go-back-btn">
            Go Back
        </a>
    </div>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="signup-box">
            <h2 class="text-center mb-4">Sign Up</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?= $first_name ?>">
                    <span class="error"><p><?= $first_nameErr ?></p></span>
                </div>

                <div class="mb-3">
                    <label for="middlename" class="form-label">Middle Name</label>
                    <input type="text" name="middlename" id="middlename" class="form-control" value="<?= $middle_name ?>">
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $last_name ?>">
                    <span class="error"><p><?= $last_nameErr ?></p></span>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= $username ?>">
                    <span class="error"><p><?= $usernameErr ?></p></span>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="johndoe@wmsu.edu.ph" value="<?= $email ?>">
                    <span class="error"><p><?= $emailErr ?></p></span>
                </div>

                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <select name="position" id="position" class="form-select">
                        <option value="">Select Position</option>
                        <?php foreach ($positions as $pos): ?>
                            <option value="<?= $pos['position_id'] ?>" <?= ($position == $pos['position_id']) ? 'selected' : '' ?>>
                                <?= clean_input($pos['position_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="error"><p><?= $positionErr ?></p></span>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <span class="error"><p><?= $passwordErr ?></p></span>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-danger">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
