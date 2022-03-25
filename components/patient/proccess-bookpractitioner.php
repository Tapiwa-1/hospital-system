<?php

//This script is a query that INSERTs a record in the patient records
//Check that the form has been submitted
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //This script is a query that INSERTs a record in the patient records
    //Check that the form has been submitted
    $errors = array(); //Initialize an error array
    //session_start();
    try {
        //require("../mysqli_connect.php");
        // Make the query:
        // Nothing passed from user safe query									#1
        $query = "SELECT id ";
        $query .= "FROM patientdetails WHERE email= ?";
        $q = mysqli_stmt_init($dbcon);
        mysqli_stmt_prepare($q, $query);

        // bind $id to SQL Statement
        mysqli_stmt_bind_param($q, "s", $_SESSION['email']);

        // execute query`patientdetails`
        mysqli_stmt_execute($q);
        $result = mysqli_stmt_get_result($q);
        if ($result) { // If it ran OK, display the records.
            // Fetch and print all the records:
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $patientname = $row['id'];
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
        $patient = $patientname;
        $practitioner = $_SESSION['doctor'];
        $illness = filter_var($_POST['illness'], FILTER_SANITIZE_STRING);
        $startdate = filter_var($_POST['startdate'], FILTER_SANITIZE_STRING);
        $occur = filter_var($_POST['occur'], FILTER_SANITIZE_NUMBER_INT);
        $allegies = filter_var($_POST['allegies'], FILTER_SANITIZE_STRING);
        $appointmentdate = filter_var($_POST['appointmentdate'], FILTER_SANITIZE_STRING);
        $moreinfo = filter_var($_POST['moreinfo'], FILTER_SANITIZE_STRING);


        $decisionstring = '<p>Register again here <a href="administrator-addpractitioner.php">Here</a></p>';

        if (empty($errors)) { //everything is ok
            try {
                //require('../../mysqli_connect.php'); //Connect to the db
                // If no problems encountered, register user in the database
                //Determine whether the email address has already been registered                         
                //make a query
                $query = "INSERT INTO patientillness (id, patient, practitioner, illness, startdate, occur, allegies, appointmentdate, moreinfo)";
                $query .= "VALUES (' ',?,?,?,?,?,?,?,?)";
                $q = mysqli_stmt_init($dbcon);
                mysqli_stmt_prepare($q, $query);
                // use prepared statement to ensure that only text is inserted
                // bind fields to SQL Statement
                mysqli_stmt_bind_param($q, 'ssssssss', $patient, $practitioner, $illness, $startdate, $occur, $allegies, $appointmentdate, $moreinfo);
                //Execute the query
                mysqli_stmt_execute($q);
                if (mysqli_stmt_affected_rows($q) == 1) { // One record inserted 
                    header("Location:patient-viewrecords.php");
                } else { // If it did not run OK.
                    // Public message:
                    $errorstring .= "System Error<br />You could not be registered due ";
                    $errorstring .= "to a system error. We apologize for any inconvenience.";
                    echo '<div class="row">';
                    echo '<p style="color:green;margin: auto">' . $errorstring . ' Has been added</p>';
                    echo '</div>';
                    exit();
                }
            } catch (Exception $e) {
                print $e->getMessage();
            } catch (Error $e) {
                print $e->getMessage();
            }
        } else { //Report the errors
            $errorstring = "Error! The following errors occured: <br>";
            foreach ($errors as $msg) { //print the errors
                $errorstring .= "- $msg<br>\n";
            }
            $errorstring .= "Please try again.<br>";
            require("registration-failed.php");
        } //End of if (empty($errors))


    } catch (Exception $e) {
        print $e->getMessage();
    } catch (Error $e) {
        print $e->getMessage();
    }
}
