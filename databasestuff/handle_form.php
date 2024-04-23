<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clubs";
$port = 3308;  // Update this if your MySQL is on a different port

$connection = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check what action to perform
$action = $_POST['action'] ?? 'select';  // Default to 'select' if action is not set

switch ($action) {
    case 'insert':
        $activityName = $_POST['activityName'];
        $description = $_POST['description'];
        $sqlInsert = "INSERT INTO rollins_activities_and_descriptions (ActivityName, Description) VALUES (?, ?)";
        $stmt = mysqli_prepare($connection, $sqlInsert);
        mysqli_stmt_bind_param($stmt, "ss", $activityName, $description);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        break;
    // Add cases for 'update' and 'delete'
}

mysqli_close($connection);
header("Location: /path_to_your_index.html");  // Redirect back to your front-end page
?>
