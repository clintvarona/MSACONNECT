<?php
require_once '../../classes/accountClass.php';
require_once '../../tools/function.php';

$accountObj = new Account();
$positions = $accountObj->fetchOfficerPositions();

$moderatorId = $_GET['ModeratorId'] ?? null;
$moderator = null;
if ($moderatorId) {
    $moderator = $adminObj->getModeratorById($officerId);
}
?>

<div class="modal fade" id="editModeratorModal" tabindex="-1" aria-labelledby="editModeratorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModeratorModalLabel">Edit Moderator</h5>
            </div>
            <div class="modal-body">
                <form id="moderatorForm">
                    <input type="hidden" id="moderatorId" name="moderatorId">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName">
                    </div>
                    <div class="mb-3">
                        <label for="middleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middleName" name="middleName">
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="positionId" class="form-label">Position</label>
                        <select class="form-select" id="positionId" name="positionId">
                        <option value="">Select Position</option>
                            <?php foreach ($positions as $position): ?>
                                <option value="<?= $position['position_id'] ?>" <?= ($moderator && $moderator['position_id'] == $position['position_id']) ? 'selected' : '' ?>>
                                    <?= clean_input($position['position_name']) ?>
                                </option>
                            <?php endforeach; ?>                        
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmSaveModerator">Update Moderator</button>
            </div>
        </div>
    </div>
</div>