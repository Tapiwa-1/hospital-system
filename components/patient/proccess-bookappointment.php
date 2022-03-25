<?php
// This section processes submissions from the login form
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //This script is a query that INSERTs a record in the patient records
    //Check that the form has been submitted
    $errors = array(); //Initialize an error array

    //department
    $department = filter_var($_POST['department'], FILTER_SANITIZE_STRING); //Removing unnessecary char
    if ($department == 0) {
        $error[] = 'You did not enter department';
    }
    if (empty($error)) { //everything is ok
        try {
            require("../mysqli_connect.php");
            $query = "SELECT id FROM practitionerdepartment WHERE id = ?";
            $q = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($q, $query);
            // use prepared statement to ensure that only text is inserted
            // bind fields to SQL Statement
            mysqli_stmt_bind_param($q, 'i', $department);
            //Execute the query
            // execute query	 
            mysqli_stmt_execute($q);
            session_start();
            $result = mysqli_stmt_get_result($q);
            if ($result) { // If it ran OK, display the records.
                // Table header.
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $_SESSION['department'] = $row['id'];
                }
                mysqli_free_result($result); // Free up the resources.
            }
        } catch (Exception $e) {
            print $e->getMessage();
        } catch (Error $e) {
            print $e->getMessage();
        }
        header("Location:patient-selectdoctor.php");
    } else { //Report the errors
        $errorstring = "";
        foreach ($error as $msg) { //print the errors
            $errorstring .= "$msg<br>\n";
        }
        echo '<div class="alert alert-danger">';
        echo $errorstring;
        echo '</div>';
    } //End of if (empty($errors))
}
