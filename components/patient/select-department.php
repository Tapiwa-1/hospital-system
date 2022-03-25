<?php
try {
    //require("../mysqli_connect.php"); //connect to the db
    //make querry
    $query = "SELECT id ,name FROM practitionerdepartment";
    $result = mysqli_query($dbcon, $query); // Run the query.
    if ($result) { // If it ran OK, display the records.
        // Table header.
        echo '<select>';
        echo '<option value="0">Department</option>';
        // Fetch and print all the records:	
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
        echo '</select>';
    } else {
        echo '<select>';
        echo '<option value="0">No department</option>';
        echo '</select>';
    }
    mysqli_close($dbcon);
} catch (Exception $e) {
    print $e->getMessage();
} catch (Error $e) {
    print $e->getMessage();
}
