<!-- Modal -->
<div class="modal" id="statusModal<?php echo $key; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $status['name']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Status: <?php echo $status['status']; ?></p>
                <p>Reason: <?php echo $status['reason']; ?></p>
                <h6>History:</h6>
                <ul>
                    <?php
                    foreach ($status['history'] as $history) {
                        echo '<li>' . date('Y-m-d H:i:s', $history['timestamp']) . ' - ' . $history['description'] . ' (Reason: ' . $history['reason'] . ')</li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
