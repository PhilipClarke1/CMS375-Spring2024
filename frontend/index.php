<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rollins Club Connector</title>
    <base href="http://localhost:52330/CMS375-Spring2024/frontend/">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>.navbar { margin-bottom: 20px; }</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">Rollins Club Connector</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="index.php">Home</a>
                <a class="nav-item nav-link" href="clubs.php">Clubs & Activities</a>
                <a class="nav-item nav-link" href="about.html">About</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Club Management</h2>

        <?php
        include '../databasestuff/connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
            $name = $connection->real_escape_string($_POST['activityName']);
            $desc = $connection->real_escape_string($_POST['description']);
            $sql = "INSERT INTO rollins_activities_and_descriptions (ActivityName, Description) VALUES ('$name', '$desc')";
            $connection->query($sql);
        }

        $sql = "SELECT ActivityName, Description FROM rollins_activities_and_descriptions";
        $result = $connection->query($sql);
        ?>

        <form id="clubForm" method="POST" action="index.php">
            <div class="form-group">
                <label for="activityName">Club Name:</label>
                <input type="text" class="form-control" id="activityName" name="activityName" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <input type="hidden" name="action" value="insert">
            <button type="submit" class="btn btn-primary">Add Club</button>
        </form>

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
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ActivityName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No clubs found</td></tr>";
                    }
                    $connection->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="app.js"></script>
</body>
</html>
