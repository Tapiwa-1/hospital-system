<?php
//This script is a query that INSERTs a record in the patient records
//Check that the form has been submitted
$error = array(); //Initialize an error array

//Check for a salary
$salary = filter_var($_POST['salary'], FILTER_SANITIZE_NUMBER_FLOAT); //Removing potential SQL injections
if (empty($salary)) {
    $error = 'You forgot to enter salary';
}
//Check for a experience
$experience = filter_var($_POST['experience'], FILTER_SANITIZE_NUMBER_INT); //Removing potential SQL injections
if (empty($experience)) {
    $error = 'You forgot to enter experience';
}
if (empty($error)) { // Everything is ok 
    //make connection
    require("../mysqli_connect.php"); //connect to db
    //make a querry
    //Determine whether the experience has already been registered                         
    $query = "SELECT id FROM practitionersalary WHERE experience = ? ";
    $q = mysqli_stmt_init($dbcon);
    mysqli_stmt_prepare($q, $query);
    mysqli_stmt_bind_param($q, 's', $experience);
    mysqli_stmt_execute($q);
    $result = mysqli_stmt_get_result($q);
    if (mysqli_num_rows($result) == 0) { //The experiencw has not been registered
        //already therefore register  table
        //-------------Valid Entries - Save to database -----
        //Start of the SUCCESSFUL SECTION. i.e all the required fields were filled out

        //Register the patients database
        $query = "INSERT INTO practitionersalary (id, salary, experience)
                VALUES (' ',?,?)";
        $q = mysqli_stmt_init($dbcon);
        mysqli_stmt_prepare($q, $query);
        // use prepared statement to ensure that only text is inserted
        // bind fields to SQL Statement
        mysqli_stmt_bind_param($q, 'di', $salary, $experience);
        //Execute the query
        mysqli_stmt_execute($q);
        if (mysqli_stmt_affected_rows($q) == 1) { // One record inserted 
            header("Location: finance-viewrecords.php");
        } else { // If it did not run OK.
            // Public message:
            $errorstring .= "System Error<br />You could not be registered due ";
            $errorstring .= "to a system error. We apologize for any inconvenience.";
            exit();
        }
    } else {
        header("Location: financeview-records.php");
        //$errorstring = "The experience has already been enter";
        //echo $errorstring;
    }
} else { //print all errors
    $errorstring = "Error! The following errors occured: <br>";
    foreach ($errors as $msg) { //print the errors
        $errorstring .= "- $msg<br>\n";
    }
    $errorstring .= "Please try again.<br>";
    require("registration-failed.php");
}//End of if (empty($errors))
