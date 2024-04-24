<?php
include '../databasestuff/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $connection->real_escape_string($_GET['id']);
    $sql = "DELETE FROM rollins_activities_and_descriptions WHERE id = $id";
    if ($connection->query($sql)) {
        // Optionally add some confirmation message or redirection
        header('Location: index.php'); // Redirect back to the main page
    } else {
        echo "Error deleting record: " . $connection->error;
    }
}
$connection->close();
?>
