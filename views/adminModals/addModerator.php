<?php
require_once '../../classes/adminClass.php';
require_once '../../classes/accountClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$accountObj = new Account();
$positions = $accountObj->fetchOfficerPositions();

$first_name = $last_name = $middle_name = $username = $password = $email = $position = '';
$first_nameErr = $last_nameErr = $usernameErr = $passwordErr = $emailErr = $positionErr = '';
?>

<div class="modal fade" id="addModeratorModal" tabindex="-1" aria-labelledby="addModeratorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModeratorModalLabel">Add Moderator</h5>
            </div>
            <div class="modal-body">
            <form id="addModeratorForm" method="POST">
    <div class="mb-3">
        <label for="addFirstName" class="form-label">First Name</label>
        <input type="text" name="firstName" id="addFirstName" class="form-control" value="<?= $first_name ?>">
        <span class="error"><p><?= $first_nameErr ?></p></span>
    </div>

    <div class="mb-3">
        <label for="addMiddleName" class="form-label">Middle Name</label>
        <input type="text" name="middleName" id="addMiddleName" class="form-control" value="<?= $middle_name ?>">
    </div>

    <div class="mb-3">
        <label for="addLastName" class="form-label">Last Name</label>
        <input type="text" name="lastName" id="addLastName" class="form-control" value="<?= $last_name ?>">
        <span class="error"><p><?= $last_nameErr ?></p></span>
    </div>

    <div class="mb-3">
        <label for="addUsername" class="form-label">Username</label>
        <input type="text" name="username" id="addUsername" class="form-control" value="<?= $username ?>">
        <span class="error"><p><?= $usernameErr ?></p></span>
    </div>

    <div class="mb-3">
        <label for="addEmail" class="form-label">Email</label>
        <input type="email" name="email" id="addEmail" class="form-control" placeholder="johndoe@wmsu.edu.ph" value="<?= $email ?>">
        <span class="error"><p><?= $emailErr ?></p></span>
    </div>

    <div class="mb-3">
        <label for="addPositionId" class="form-label">Position</label>
        <select name="positionId" id="addPositionId" class="form-select">
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
        <label for="addPassword" class="form-label">Password</label>
        <input type="password" name="password" id="addPassword" class="form-control">
        <span class="error"><p><?= $passwordErr ?></p></span>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger" id="addModerator">Add Moderator</button>
    </div>
</form>
            </div>
        </div>
    </div>
</div>
</body>
</html>