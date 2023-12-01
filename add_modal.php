<?php
include_once 'pin.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pin'])) {
    $submittedPin = $_POST['pin'];

    if ($submittedPin === $pin) {
        $_SESSION['authenticated'] = true;
    } else {
        die('Incorrect PIN');
    }
}

if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    echo '<form method="post" action="">
              <label for="pin">Enter PIN:</label>
              <input type="password" id="pin" name="pin" required>
              <button type="submit">Submit</button>
          </form>';
    exit();
}
?>
<div class="modal" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="change.php" method="post">
                    <div class="form-group">
                        <label for="newObjectName">Object Name:</label>
                        <input type="text" class="form-control" id="newObjectName" name="newObjectName" required>
                    </div>
                    <div class="form-group">
                        <label for="newCategory">Category:</label>
                        <select class="form-control" id="newCategory" name="newCategory">
                            <?php
                            foreach ($categories as $category) {
                                echo '<option value="' . $category . '">' . $category . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newStatus">Status:</label>
                        <select class="form-control" id="newStatus" name="newStatus">
                            <?php
                            foreach ($statusTypes as $statusType) {
                                echo '<option value="' . $statusType['name'] . '">' . $statusType['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newReason">Reason:</label>
                        <input type="text" class="form-control" id="newReason" name="newReason" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="addStatus">Add Status</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
