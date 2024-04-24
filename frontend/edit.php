<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Club</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Edit Club Information</h2>

        <?php
        include '../databasestuff/connect.php'; // Make sure this path is correct

        $row = ['ActivityName' => '', 'Description' => '']; // Default values to avoid undefined index error
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
            $id = $connection->real_escape_string($_GET['id']);
            $sql = "SELECT ActivityName, Description FROM rollins_activities_and_descriptions WHERE id = $id";
            $result = $connection->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                echo "<div class='alert alert-danger'>No club found with the specified ID.</div>";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            $name = $connection->real_escape_string($_POST['activityName']);
            $desc = $connection->real_escape_string($_POST['description']);
            $id = $_POST['id'];
            $sql = "UPDATE rollins_activities_and_descriptions SET ActivityName='$name', Description='$desc' WHERE id=$id";
            if ($connection->query($sql)) {
                echo "<div class='alert alert-success'>Club updated successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error updating club: " . $connection->error . "</div>";
            }
        }
        ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="activityName">Club Name:</label>
                <input type="text" class="form-control" id="activityName" name="activityName" value="<?php echo htmlspecialchars($row['ActivityName']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($row['Description']); ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" name="update" class="btn btn-primary">Update Club</button>
        </form>
    </div>
    <script>
function searchClub() {
    var input = document.getElementById('searchQuery').value;
    if (input.length < 1) {
        document.getElementById('results').innerHTML = ''; // Clear results if input is cleared
        return;
    }
    $.ajax({
        url: 'search.php', // This is a PHP file that will handle the search logic
        type: 'GET',
        data: {query: input},
        success: function(data) {
            document.getElementById('results').innerHTML = data;
        }
    });
}
</script>

</body>
</html>
