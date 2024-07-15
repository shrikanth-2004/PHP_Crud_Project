<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Details</title>
</head>
<body>

<!-- Search form to search for entries -->
<form action="view_details.php" method="get">
    Search: <input type="text" name="query" placeholder="Enter search term">
    <input type="submit" value="Search">
</form>

<h2>View Details</h2>

<!-- Display Records -->
<table border="1">
    <tr>
        <th>Name</th>
        <th>USN</th>
        <th>Phone Number</th>
        <th>Delete Record</th>
        <th>Update Record</th>
    </tr>

    <?php
    $conn = new mysqli('localhost', 'root', '', 'wshop');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $search_query = "";
    if (isset($_GET['query'])) {
        $search_query = $conn->real_escape_string($_GET['query']);
    }

    $sql = "SELECT * FROM students WHERE name LIKE '%$search_query%' OR usn LIKE '%$search_query%' OR phone LIKE '%$search_query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["usn"] . "</td>
                    <td>" . $row["phone"] . "</td>
                    <td>
                        <form action='delete.php' method='post' style='display:inline-block;'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <input type='submit' value='Delete'>
                        </form>
                    </td>
                    <td>
                        <form action='update.php' method='post' style='display:inline-block;'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <input type='submit' value='Update'>
                        </form>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
    $conn->close();
    ?>
</table>
</body>
</html>
