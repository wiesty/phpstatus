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
<!-- Edit Modal -->
<div class="modal" id="editModal<?php echo $key; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Status: <?php echo $status['name']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="change.php" method="post">
                    <input type="hidden" name="statusId" value="<?php echo $key; ?>">
                    <div class="form-group">
                        <label for="newStatus">New Status:</label>
                        <select class="form-control" id="newStatus" name="newStatus">
                            <?php
                            foreach ($statusTypes as $statusType) {
                                echo '<option value="' . $statusType['name'] . '">' . $statusType['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newReason">New Reason:</label>
                        <input type="text" class="form-control" id="newReason" name="newReason" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="editStatus">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
