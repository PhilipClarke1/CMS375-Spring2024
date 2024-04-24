<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Club</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Delete Club</h2>
        <?php
        // Include database connection setup.
        include '../databasestuff/connect.php'; // Adjust the path as needed.

        // Check if activity name is provided in the URL.
        if(isset($_GET['activityName'])) {
            $activityName = $_GET['activityName'];

            // Delete the club from the database.
            $sql = "DELETE FROM rollins_activities_and_descriptions WHERE ActivityName = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $activityName);
            if ($stmt->execute()) {
                // Set success message if deletion is successful.
                $successMessage = "Club '" . htmlspecialchars($activityName) . "' has been successfully deleted.";
            } else {
                // Set error message if deletion fails.
                $errorMessage = "Error deleting club.";
            }
            $stmt->close();
        } else {
            // Set error message if activity name is not provided.
            $errorMessage = "Error: Activity name not provided.";
        }

        if(isset($successMessage)) {
            echo "<div id='deleteSuccessMessage' class='alert alert-success'>$successMessage</div>";
        } elseif(isset($errorMessage)) {
            echo "<div id='deleteSuccessMessage' class='alert alert-danger'>$errorMessage</div>";
        }
        ?>
        <!-- Add a button to navigate back to the main page -->
        <a href="index.php" class="btn btn-primary">Back to Home</a>
    </div>

    <script>
    $(document).ready(function() {
        // Automatically close the success message after 3 seconds.
        setTimeout(function() {
            $("#deleteSuccessMessage").fadeOut('slow');
        }, 3000); // 3000 milliseconds = 3 seconds
    });
    </script>
</body>
</html>
