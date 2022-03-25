<?php
try {
    //This script is a query that INSERTs a record in the practionerdepartments records
    //Check that the form has been submitted
    $errors = array(); //Initialize an error array

    //Check for a name
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);  //Removing potential SQL Injection
    if ((!empty($name)) && (preg_match('/[a-z\s]/i', $name)) && (strlen($name) <= 30)) {
        //Sanitize the trimmed  name
        $nametrim = $name;
    } else {
        $errors[] = 'Name missing or not alphabetic and space characters. Max 30';
    }

    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);  //Removing potential SQL Injection
    if (empty($description)) {
        $errors[] = 'You forgot to enter description';
    }
    if (empty($errors)) { //This means that everything is okay
        try {
            //make a connection
            // require("../../mysqli_connect.php"); //Connect to the db
            // If no problems encountered, register user in the database
            //Determine whether the name has already been registered                         
            $query = "SELECT id FROM financedepartment WHERE name = ? ";
            $q = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($q, $query);
            mysqli_stmt_bind_param($q, 's', $nametrim);
            mysqli_stmt_execute($q);
            $result = mysqli_stmt_get_result($q);
            if (mysqli_num_rows($result) == 0) { //The  name has not been registered
                //already therefore register the name in the department table
                //-------------Valid Entries - Save to database -----
                //Start of the SUCCESSFUL SECTION. i.e all the required fields were filled out
                //Register the name database
                //make a query
                $query = "INSERT INTO financedepartment (id, name, description)";
                $query .= "VALUES (' ',?,?)";
                $q = mysqli_stmt_init($dbcon);
                mysqli_stmt_prepare($q, $query);
                // use prepared statement to ensure that only text is inserted
                // bind fields to SQL Statement
                mysqli_stmt_bind_param($q, 'ss', $nametrim, $description);
                //Execute the query
                mysqli_stmt_execute($q);
                if (mysqli_stmt_affected_rows($q) == 1) { // One record inserted 
                    echo '<div class="alert alert-success">';
                    echo $nametrim . ' Has been added';
                    echo '</div>';
                } else { // If it did not run OK.
                    // Public message:
                    $errorstring .= "System Error<br />You could not be registered due ";
                    $errorstring .= "to a system error. We apologize for any inconvenience.";
                    exit();
                }
            } else {
                $errorstring = "The name has already been taken";
                echo '<div class="alert alert-danger">';
                echo  $errorstring;
                echo '</div>';
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
        echo '<div class="alert alert-danger">';
        echo  $errorstring;
        echo '</div>';
    } //End of if (empty($errors))
} catch (Exception $e) {
    print $e->getMessage();
} catch (Error $e) {
    print $e->getMessage();
}
