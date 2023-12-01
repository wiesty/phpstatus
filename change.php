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

$configData = json_decode(file_get_contents('config.json'), true);

$categories = $configData['categories'];
$maxHistories = $configData['maxHistories'];
$statusTypes = $configData['statusTypes'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statusData = json_decode(file_get_contents('status.json'), true);

    if (isset($_POST['editStatus'])) {
        $statusId = $_POST['statusId'];
        $newStatus = $_POST['newStatus'];
        $newReason = $_POST['newReason'];

        $statusData['statusObjects'][$statusId]['status'] = $newStatus;
        $statusData['statusObjects'][$statusId]['reason'] = $newReason;

        $historyEntry = [
            'timestamp' => time(),
            'description' => 'Status updated to ' . $newStatus,
            'reason' => $newReason
        ];

        array_unshift($statusData['statusObjects'][$statusId]['history'], $historyEntry);
        $statusData['statusObjects'][$statusId]['history'] = array_slice($statusData['statusObjects'][$statusId]['history'], 0, $maxHistories);
    } elseif (isset($_POST['deleteStatus'])) {
        $statusId = $_POST['statusId'];
        unset($statusData['statusObjects'][$statusId]);
    } elseif (isset($_POST['addStatus'])) {
        $newStatus = $_POST['newStatus'];
        $newReason = $_POST['newReason'];
        $newCategory = $_POST['newCategory'];
        $newObjectName = $_POST['newObjectName'];

        $newStatusObject = [
            'name' => $newObjectName,
            'category' => $newCategory,
            'status' => $newStatus,
            'reason' => $newReason,
            'history' => []
        ];

        $historyEntry = [
            'timestamp' => time(),
            'description' => 'Status added: ' . $newStatus,
            'reason' => $newReason
        ];

        array_unshift($newStatusObject['history'], $historyEntry);
        $newStatusObject['history'] = array_slice($newStatusObject['history'], 0, $maxHistories);

        $statusData['statusObjects'][] = $newStatusObject;
    }

    file_put_contents('status.json', json_encode($statusData, JSON_PRETTY_PRINT));

    header('Location: change.php');
    exit();
}


$statusData = json_decode(file_get_contents('status.json'), true);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Page - Change</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Status</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($statusData['statusObjects'] as $key => $status) {
                $statusColor = getStatusColor($status['status'], $configData['statusTypes']);
                echo '<tr style="background-color: ' . $statusColor . ';">';
                echo '<td>' . $status['name'] . '</td>';
                echo '<td>' . $status['category'] . '</td>';
                echo '<td>' . $status['status'] . '</td>';
                echo '<td>';
                echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal' . $key . '">Edit</button>';
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal' . $key . '">Delete</button>';
                echo '</td>';
                echo '</tr>';
            }

            function getStatusColor($status, $statusTypes) {
                foreach ($statusTypes as $type) {
                    if ($type['name'] === $status) {
                        return $type['color'];
                    }
                }
                return '';
            }
            ?>
        </tbody>
    </table>

    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Add Status</button>
</div>

<?php
foreach ($statusData['statusObjects'] as $key => $status) {
    include 'edit_modal.php';
    include 'delete_modal.php';
}
include 'add_modal.php';
?>

<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
