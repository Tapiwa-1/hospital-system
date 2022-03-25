<?php
// This section processes submissions from the login form
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Check that the form has been submitted
    $errors = array(); //Initialize an error array

    //department
    $doctor = filter_var($_POST['doctor'], FILTER_SANITIZE_STRING); //Removing unnessecary char
    if ($doctor == 0) {
        $errors[] = 'You did not enter doctor';
    }
    if (empty($errors)) { //everything is ok
        try {
            require("../mysqli_connect.php");
            $query = "SELECT id FROM practitionerdetails WHERE id = ?";
            $q = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($q, $query);
            // use prepared statement to ensure that only text is inserted
            // bind fields to SQL Statement
            mysqli_stmt_bind_param($q, 'i', $doctor);
            //Execute the query
            // execute query	 
            mysqli_stmt_execute($q);
            $result = mysqli_stmt_get_result($q);
            if ($result) { // If it ran OK, display the records.
                // Table header.
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $_SESSION['doctor'] = $row['id'];
                }
                mysqli_free_result($result); // Free up the resources.
                header("Location:patient-bookpractioner.php");
            }
        } catch (Exception $e) {
            print $e->getMessage();
        } catch (Error $e) {
            print $e->getMessage();
        }
    } else { //Report the errors
        $errorstring = '';
        foreach ($errors as $msg) { //print the errors
            $errorstring .= "$msg<br>\n";
        }
        echo '<div class="alert alert-danger">';
        echo $errorstring;
        echo '</div>';
    } //End of if (empty($errors))

}
