<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rollins Club Connector</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .navbar { margin-bottom: 20px; }
        .search-section, .club-section {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
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
                <a class="nav-item nav-link active" href="index.php">Home</a>
                <a class="nav-item nav-link" href="about.html">About</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Club Management</h2>

        <?php
        include '../databasestuff/connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
            $stmt = $connection->prepare("INSERT INTO rollins_activities_and_descriptions (ActivityName, Description) VALUES (?, ?)");
            $stmt->bind_param("ss", $_POST['activityName'], $_POST['description']); // Corrected parameter name
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Club added successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error adding club: " . htmlspecialchars($stmt->error) . "</div>";
            }
            $stmt->close();
        }

        // Handling search query
        $searchQuery = $_GET['searchQuery'] ?? '';
        $searchQuery = "%$searchQuery%"; // Prepare the string to be used in the LIKE clause

        $sql = "SELECT ActivityName, Description FROM rollins_activities_and_descriptions WHERE ActivityName LIKE ? OR Description LIKE ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $searchQuery, $searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <div class="search-section">
            <h3>Search Clubs:</h3>
            <form id="searchForm" class="mb-3">
                <div class="form-group">
                    <label for="searchQuery">Search Clubs:</label>
                    <input type="text" class="form-control" id="searchQuery" name="searchQuery" placeholder="Search by name or description">
                </div>
                <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="club-section">
            <h3>Add Club:</h3>
            <form id="clubForm" method="POST" action="index.php"> <!-- Updated action attribute -->
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
        </div>

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

    <script>
    // JavaScript to submit the search form when Search button is clicked
    $(document).ready(function() {
        $("#searchBtn").click(function() {
            $("#searchForm").submit();
        });

        // Submit search form when Enter key is pressed in the search input field
        $("#searchQuery").keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault();
                $("#searchForm").submit();
            }
        });
    });
    </script>
</body>
</html>
