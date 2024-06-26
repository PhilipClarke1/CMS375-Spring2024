<?php
include '../databasestuff/connect.php'; // adjust path as needed

$searchQuery = $_GET['searchQuery'] ?? '';
$searchQuery = "%$searchQuery%";

$sql = "SELECT ActivityName, Description FROM rollins_activities_and_descriptions WHERE ActivityName LIKE ? OR Description LIKE ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ss", $searchQuery, $searchQuery);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Keep track of whether the searched activity has been found
    $found = false;
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ActivityName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
        // Here you can add the Edit and Delete buttons as needed
        echo "</tr>";
        
        // Check if the current row matches the searched activity
        if (strtolower($row['ActivityName']) === strtolower($_GET['searchQuery'])) {
            // Output JavaScript to scroll to this row
            echo "<script>document.addEventListener('DOMContentLoaded', function() {
                var element = document.querySelector('td:contains(\"" . htmlspecialchars($row['ActivityName']) . "\")').closest('tr');
                if (element && !found) {
                    element.scrollIntoView({ behavior: 'smooth' });
                    found = true;
                }
            });</script>";
        }
    }
} else {
    echo "<tr><td colspan='2'>No clubs found</td></tr>";
}
$stmt->close();
$connection->close();
?>
