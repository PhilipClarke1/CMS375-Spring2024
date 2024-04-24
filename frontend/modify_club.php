<?php
// Include database connection setup.
include '../databasestuff/connect.php'; // Adjust the path as needed.

// Check if activity name is provided in the URL.
if(isset($_GET['activityName'])) {
    $activityName = $_GET['activityName'];

    // Retrieve club information from the database.
    $sql = "SELECT Description FROM rollins_activities_and_descriptions WHERE ActivityName = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $activityName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch club information.
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $description = $row['Description'];
    } else {
        // Redirect if club not found.
        header("Location: index.php");
        exit;
    }
} else {
    // Redirect if activity name is not provided.
    header("Location: index.php");
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data.
    $newActivityName = $_POST['newActivityName'] ?? '';
    $newDescription = $_POST['newDescription'] ?? '';

    // Update the club details in the database.
    $sql = "UPDATE rollins_activities_and_descriptions SET ActivityName = ?, Description = ? WHERE ActivityName = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sss", $newActivityName, $newDescription, $activityName);
    $stmt->execute();
    $stmt->close();

    // Redirect to index.php after modification.
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Club - <?php echo htmlspecialchars($activityName); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Modify Club - <?php echo htmlspecialchars($activityName); ?></h2>
        <form method="POST">
            <div class="form-group">
                <label for="newActivityName">New Activity Name:</label>
                <input type="text" class="form-control" id="newActivityName" name="newActivityName" value="<?php echo htmlspecialchars($activityName); ?>" required>
            </div>
            <div class="form-group">
                <label for="newDescription">New Description:</label>
                <textarea class="form-control" id="newDescription" name="newDescription" required><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Modify Club</button>
        </form>
    </div>
</body>
</html>
