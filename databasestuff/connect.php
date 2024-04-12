<!-- Philip, Brandon, and Trevor all worked on this file -->
<?php
$servername = "localhost";
$servername = "localhost";  
$username = "root";
$password = "";
$dbname = "clubs";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connection established<br>";

// SQL query to select all rows from the table
$sql = "SELECT * FROM rollins_activities_and_descriptions";

// Execute the query
$result = mysqli_query($connection, $sql);

// Check if there are rows returned
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    echo "<table border='1'>
    <tr>
    <th>ActivityName</th>
    <th>Description</th>
    </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["ActivityName"] . "</td>";
        echo "<td>" . $row["Description"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
mysqli_close($connection);
?>
