<?php
require_once '../../tools/function.php';
require_once '../../classes/accountClass.php';
require_once '../../classes/adminClass.php';

session_start();

$username = $password = '';
$accountObj = new Account();
$adminObj = new Admin();
$schoolYear = $adminObj->fetchSy();
$positions = $accountObj->fetchOfficerPositions();
$programs = $adminObj->fetchProgram();
$first_name = $last_name = $middle_name = $position = $school_year = $program = $image = '';
$first_nameErr = $last_nameErr = $usernameErr = $positionErr = $school_yearErr = $programErr = $imageErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = clean_input($_POST['firstname']);
    $last_name = clean_input($_POST['lastname']);
    $middle_name = clean_input($_POST['middlename']);
    $position = clean_input($_POST['position']);
    $program = clean_input($_POST['program']);
    $school_year = clean_input($_POST['school_year']);

    if (empty($first_name)) {
        $first_nameErr = "First name is required!";
    }
    if (empty($last_name)) {
        $last_nameErr = "Last name is required!";
    }
    if (empty($position)) {
        $positionErr = "Please enter officer's position!";
    }
    if (empty($program)) {
        $programErr = "Please enter course!";
    }
    if (empty($school_year)) {
        $school_yearErr = "Please select school year!";
    }

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../assets/officers/";

        if (!is_dir($target_dir) && !mkdir($target_dir, 0777, true)) {
            $imageErr = "Failed to create upload directory.";
        } else {
            $image_name = time() . "_" . basename($_FILES['image']['name']);
            $target_file = $target_dir . $image_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $maxFileSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($imageFileType, $allowed_types)) {
                $imageErr = "Only JPG, JPEG, PNG & GIF files are allowed.";
            } elseif ($_FILES['image']['size'] > $maxFileSize) {
                $imageErr = "File size should not exceed 2MB.";
            } else {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image = $image_name; 
                } else {
                    $imageErr = "There was an error uploading your file.";
                }
            }
        }
    }elseif (isset($_POST['existing_image'])) {
        $image = $_POST['existing_image']; 
    }

    if (empty($first_nameErr) && empty($last_nameErr) && empty($positionErr) && empty($school_yearErr) && empty($imageErr)) {
        $adminObj->first_name = $first_name;
        $adminObj->last_name = $last_name;
        $adminObj->middle_name = $middle_name;
        $adminObj->position = $position;
        $adminObj->image = $image;
        $adminObj->school_year = $school_year;

        $adminObj->addOfficer();
        header("Location: admin_dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src="../../js/admin.js"></script>
    <link rel="stylesheet" href="../../css/add_officer.css">
</head>
<body>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" placeholder="First Name" value="<?= $first_name ?>">
        <span><p><?= $first_nameErr ?></p></span>
        <br>

        <label for="middlename">Middle Name:</label>
        <input type="text" id="middlename" name="middlename" placeholder="Middle Name" value="<?= $middle_name ?>">
        <br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" placeholder="Last Name" value="<?= $last_name ?>">
        <span><p><?= $last_nameErr ?></p></span>
        <br>

        <label for="program">Course:</label>
        <select id="program" name="program">
            <option value="">Select Program</option>
            <?php foreach ($programs as $prog): ?>
                <option value="<?= $prog['program_id'] ?>" <?= ($program == $prog['program_id']) ? 'selected' : '' ?>>
                    <?= clean_input($prog['program_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span><p><?= $programErr ?></p></span>
        <br>

        <label for="position">Position:</label>
        <select id="position" name="position">
            <option value="">Select Position</option>
            <?php foreach ($positions as $pos): ?>
                <option value="<?= $pos['position_id'] ?>" <?= ($position == $pos['position_id']) ? 'selected' : '' ?>>
                    <?= clean_input($pos['position_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span><p><?= $positionErr ?></p></span>
        <br>

        <label for="school_year">School Year:</label>
        <select id="school_year" name="school_year">
            <option value="">Select School Year</option>
            <?php foreach ($schoolYear as $sy): ?>
                <option value="<?= $sy['school_year_id'] ?>" <?= ($school_year == $sy['school_year_id']) ? 'selected' : '' ?>>
                    <?= clean_input($sy['school_year']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span><p><?= $school_yearErr ?></p></span>
        <br>

        <label for="image">Upload Picture:</label>
        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)"">
        <input type="hidden" name="existing_image" value="<?= $image ?>">
        <span><p><?= $imageErr ?></p></span>
        <br>

        <div class="image-preview" id="image-preview" style="display: none;">
            <img id="preview-img" src="#" alt="Image Preview">
            <button type="button" class="remove-image" onclick="removeImage()">x</button>
        </div>

        <button type="submit">Sign Up</button>
    </form>

</body>
</html>
