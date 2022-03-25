<?php

try {
    require("../mysqli_connect.php");
    // Make the query:
    // Nothing passed from user safe query									#1
    $query = "SELECT id, CONCAT(firstname, ', ', lastname) AS name ";
    $query .= "FROM admindetails WHERE email = ?";
    $q = mysqli_stmt_init($dbcon);
    mysqli_stmt_prepare($q, $query);
    // bind $id to SQL Statement
    mysqli_stmt_bind_param($q, "s", $_SESSION['email']);
    // execute query`patientdetails`
    mysqli_stmt_execute($q);
    $result = mysqli_stmt_get_result($q);
    if ($result) { // If it ran OK, display the records.
        // Fetch and print all the records
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $adminname = $row['name'];
            $_SESSION['id'] = $row['id'];
            echo $row['name'];
        }
        mysqli_free_result($result); // Free up the resources
    } else { // If it did not run OK.
        // Error message:
        echo '<p class="error">The current users could not be retrieved. We apologize';
        echo ' for any inconvenience.</p>';
        // Debug message:
        // echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
        exit;
    } // End of if ($result) 
    //mysqli_close($dbcon); // Close the database connection.
} catch (Exception $e) {
    print $e->getMessage();
} catch (Error $e) {
    print $e->getMessage();
}
