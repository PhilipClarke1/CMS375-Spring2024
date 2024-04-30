<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clubs - Rollins Club Connector</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .navbar { margin-bottom: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">Rollins Club Connector</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="index.php">Home</a>
                <a class="nav-item nav-link active" href="clubs.php">Clubs</a>
                <a class="nav-item nav-link" href="about.html">About</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>List of Clubs</h2>
        <div class="table-responsive">
            <table class="table table-bordered mt-5">
                <thead class="thead-dark">
                    <tr>
                        <th>Club Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include '../databasestuff/connect.php';

                    // Check if the request method is GET and an ID is provided
                    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
                        $id = $connection->real_escape_string($_GET['id']);
                        $sql = "DELETE FROM rollins_activities_and_descriptions WHERE id = $id";

                        // Execute the delete query
                        if ($connection->query($sql)) {
                            // Optionally add some confirmation message or redirection
                            echo "<script>alert('Record deleted successfully!');</script>";
                        } else {
                            echo "Error deleting record: " . $connection->error;
                        }
                    }

                    // Fetch and display the list of clubs
                    $result = $connection->query("SELECT * FROM rollins_activities_and_descriptions");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ActivityName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                            echo "<td><a href='?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No clubs found.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
