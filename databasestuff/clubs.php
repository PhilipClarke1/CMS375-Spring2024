<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'connect.php';  // Include the connection setup

$sql = "SELECT ActivityName, Description FROM rollins_activities_and_descriptions";
$result = mysqli_query($connection, $sql);

$clubs = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $clubs[] = $row;
    }
} else {
    echo "0 results found.";
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clubs & Activities</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Clubs and Activities</h2>
        <?php if (!empty($clubs)): ?>
            <div class="row">
                <?php foreach ($clubs as $club): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($club['ActivityName']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($club['Description']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No clubs or activities to display.</p>
        <?php endif; ?>
    </div>
</body>
</html>
