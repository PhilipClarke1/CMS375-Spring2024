<?php
ini_set('display_errors', 1); // Enable error reporting for debugging.
error_reporting(E_ALL);

// Include database connection setup.
include '../databasestuff/connect.php'; // Adjust the path as needed.

// Function to safely encode HTML entities.
function safeEcho($text) {
    echo htmlspecialchars($text, ENT_QUOTES);
}

// Prepare and execute search.
$searchQuery = $_GET['searchQuery'] ?? ''; // Collect the search term if any.
$searchTerm = "%$searchQuery%"; // Prepare the term for LIKE query.
if (!empty($searchQuery)) { // Only query if there is a search term.
    $sql = "SELECT ActivityName, Description FROM rollins_activities_and_descriptions WHERE ActivityName LIKE ? OR Description LIKE ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
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
                <a class="nav-item nav-link" href="clubs.php">Clubs</a> 
                <a class="nav-item nav-link" href="about.html">About</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Club Management</h2>

        <div class="search-section">
            <h3>Search Clubs:</h3>
            <form id="searchForm" class="mb-3" method="GET" action="index.php">
                <div class="form-group">
                    <label for="searchQuery">Search Clubs:</label>
                    <input type="text" class="form-control" id="searchQuery" name="searchQuery" placeholder="Search by name or description" value="<?php echo htmlspecialchars($searchQuery); ?>">
                </div>
                <button type="submit" id="searchBtn" class="btn btn-primary">Search</button>
            </form>
        </div>

        <?php if (!empty($searchQuery)): ?>
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered mt-5">
                        <thead class="thead-dark">
                            <tr>
                                <th>Club Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ActivityName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                                echo "<td><a href='modify_club.php?activityName=" . urlencode($row['ActivityName']) . "' class='btn btn-warning'>Modify</a>";
                                echo "<a href='delete_club.php?activityName=" . urlencode($row['ActivityName']) . "' class='btn btn-danger'>Delete</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No clubs found.</p>
            <?php endif; ?>
        <?php endif; ?>

        <div class="club-section">
            <h3>Add a Club:</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="newActivityName">Club Name:</label>
                    <input type="text" class="form-control" id="newActivityName" name="newActivityName" required>
                </div>
                <div class="form-group">
                    <label for="newDescription">Description:</label>
                    <textarea class="form-control" id="newDescription" name="newDescription" required></textarea>
                </div>
                <?php
                // Process form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Retrieve form data.
                    $newActivityName = $_POST['newActivityName'] ?? '';
                    $newDescription = $_POST['newDescription'] ?? '';

                    // Insert the new club into the database.
                    $sql = "INSERT INTO rollins_activities_and_descriptions (ActivityName, Description) VALUES (?, ?)";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("ss", $newActivityName, $newDescription);
                    $stmt->execute();
                    $stmt->close();

                    // Display success message.
                    echo "<div class='alert alert-success'>Club added successfully!</div>";
                }
                ?>
                <button type="submit" class="btn btn-success">Add Club</button>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $("#searchBtn").click(function() {
            $("#searchForm").submit();
        });

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
