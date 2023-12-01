<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Page</title>
     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f9fafc;">
	
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Server Status</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li> -->
        </ul>
    </div>
</nav>
	
<div class="container mt-5">
    <h2>Status Page</h2>

    <div class="card mb-4">
    <div class="card-header">
        Server Status
    </div>
    <div class="card-body">
        <?php

        $statusData = json_decode(file_get_contents('status.json'), true);
		$configData = json_decode(file_get_contents('config.json'), true);

        $functionalCount = 0;
        $maintenanceCount = 0;
        $issueCount = 0;

        foreach ($statusData['statusObjects'] as $status) {
            switch ($status['status']) {
                case 'Functional':
                    $functionalCount++;
                    break;
                case 'Maintenance':
                    $maintenanceCount++;
                    break;
                case 'Issue':
                    $issueCount++;
                    break;
            }
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

        <p>Functional: <?php echo $functionalCount; ?></p>
        <p>Maintenance: <?php echo $maintenanceCount; ?></p>
        <p>Issue: <?php echo $issueCount; ?></p>
    </div>
</div>
	
    <?php
    foreach ($statusData['statusObjects'] as $key => $status) {
        if ($status['status'] === 'Maintenance' || $status['status'] === 'Issue') {
            $statusColor = getStatusColor($status['status'], $configData['statusTypes']);
            echo '<div class="card mb-3" style="background-color: ' . $statusColor . ';">';
            echo '<div class="card-header">' . $status['name'] . '</div>';
            echo '<div class="card-body">';
            echo '<p class="card-text">Status: ' . $status['status'] . '</p>';
            echo '<p class="card-text">Reason: ' . $status['reason'] . '</p>';
            echo '<button class="btn btn-secondary" data-toggle="modal" data-target="#statusModal' . $key . '">Details</button>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
	
    <div class="mt-4">
    <table class="table bdr">
        <thead style="background-color: #f7f7f7">
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $statusData = json_decode(file_get_contents('status.json'), true);
            $configData = json_decode(file_get_contents('config.json'), true);

            foreach ($statusData['statusObjects'] as $key => $status) {
                $statusColor = getStatusColor($status['status'], $configData['statusTypes']);
                echo '<tr style="background-color: ' . $statusColor . ';">';
                echo '<td> ' . $status['name'] . '</td>';
                echo '<td>' . $status['status'] . '</td>';
                echo '<td><a style="color: #1D1D1D" href="#" data-toggle="modal" data-target="#statusModal' . $key . '">Details</a></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
	</div>
</div>

<footer class="footer mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <p>&copy; 2023 Serverstatus</p>
            </div>
            <div class="col-md-4">
                <p class="mb-0"><a href="#">Imprint</a></p>
            </div>
        </div>
    </div>
</footer>
	
	
<?php
foreach ($statusData['statusObjects'] as $key => $status) {
    include 'modal.php';
}
?>
	
<style>
	.bdr {
  border-radius: 6px;
  overflow: hidden;
}

</style>

<script src="/assets/js/jquery-3.7.1.slim.min.js"></script>
<script src="/assets/popper.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>

</body>
</html>
