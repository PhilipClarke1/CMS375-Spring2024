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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../databasestuff/connect.php';
                    $sql = "SELECT ActivityName, Description FROM rollins_activities_and_descriptions";
                    $stmt = $connection->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . htmlspecialchars($row['ActivityName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Description']) . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No clubs found</td></tr>";
                    }
                    $stmt->close();
                    $connection->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
