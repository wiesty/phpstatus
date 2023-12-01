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
<!-- Delete Modal -->
<div class="modal" id="deleteModal<?php echo $key; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Status: <?php echo $status['name']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this status object?</p>
                <form action="change.php" method="post">
                    <input type="hidden" name="statusId" value="<?php echo $key; ?>">
                    <button type="submit" class="btn btn-danger" name="deleteStatus">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
