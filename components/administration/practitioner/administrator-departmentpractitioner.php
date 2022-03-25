<?php include("header.php") ?>
<?php
try {
    // This script retrieves all the records from the department table.
    //require("../../mysqli_connect.php"); // Connect to the database.
    // Make the query:
    // Nothing passed from user safe query									#1
    $query = "SELECT id ,name , description 
                    FROM practitionerdepartment
                    ORDER BY id ASC";

    $result = mysqli_query($dbcon, $query); // Run the query.
    if ($result) { // If it ran OK, display the records.
        // Table header. 									#2
        echo '<table class="table" style="font-size:14px">';
        echo '<thead>
        <tr>
                    <th>Department Name</th>
                    <th>Description</th>
                    <th>Edit</th>
                    <th>Delete</th>
        </tr>
        </thead><tbody>';
        // Fetch and print all the records:							#3
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo '<tr>
            <td>' . $row['name'] . '</td>
            <td >' . $row['description'] . '</td>
            <td ><a class="btn btn-primary btn-sm" href="edit-dept.php?id='.$row['id'].'">Edit</a></td></td>
            <td ><a class="btn btn-danger btn-sm" href="delete-dept.php?id='.$row['id'].'">Delete</a></td>
            </tr>';
        }
        echo '</tbody></table>'; // Close the table so that it is ready for displaying.
        mysqli_free_result($result); // Free up the resources.
    } else { // If it did not run OK.
        // Error message:
        echo '<p class="error">The current users could not be retrieved. We apologize';
        echo ' for any inconvenience.</p>';
        // Debug message:
        // echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
        exit;
    } // End of if ($result) 
    mysqli_close($dbcon); // Close the database connection.
} catch (Exception $e) // We finally handle any problems here                
{
    print "An Exception occurred. Message: " . $e->getMessage();
    print "The system is busy please try later";
} catch (Error $e) {
    print "An Error occurred. Message: " . $e->getMessage();
    print "The system is busy please try again later.";
}
?>

<?php include("footer.php") ?>