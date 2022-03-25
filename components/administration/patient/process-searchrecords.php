<?php
// This section processes submissions from the login form
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //This script is a query that INSERTs a record in the patient records
    //Check that the form has been submitted
    $errors = array(); //Initialize an error array

    //Check for a firstname
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);  //Removing potential SQL Injection
    if ((!empty($firstname)) && (preg_match('/[a-z\s]/i', $firstname)) && (strlen($firstname) <= 30)) {
        //Sanitize the trimmed first name
        $firstnametrim = $firstname;
    } else {
        $errors[] = 'First name missing or not alphabetic and space characters. Max 30';
    }

    //Check for a lastname
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);  //Removing potential SQL Injection
    if ((!empty($lastname)) && (preg_match('/[a-z\s]/i', $lastname)) && (strlen($lastname) <= 30)) {
        //Sanitize the trimmed Last name
        $lastnametrim = $lastname;
    } else {
        $errors[] = 'Last name missing or not alphabetic and space characters. Max 30';
    }

    if (empty($errors)) { //everything is okay
        try {
            //require('../../mysqli_connect.php'); //Connect to the db
            //search if the record exist first else error no such record
            //session['id'] for patient
            $query = "SELECT firstname, lastname, gender, email, address1, address2,phone, id,
                    DATE_FORMAT(registrationdate, '%M %d, %Y')  AS regdat
                    FROM patientdetails ";
            $query .= 'WHERE firstname ="' . $firstnametrim . '" AND lastname ="' . $lastnametrim . '" ';
            $result = mysqli_query($dbcon, $query); // Run the query;
            if (mysqli_num_rows($result) != 0) { //everything is okay
                // Fetch and print all the records
                echo '<div class="table-responsive">
                <table class="table" style="font-size=14px">';
                echo
                '<thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Phone number</th>
                    <th>Registration Date</th>
                    <th>More</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>';
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo
                    '<tr>
                    <td>' . $row['firstname'] . '</td>
                    <td>' . $row['lastname'] . '</td>
                    <td>' . $row['gender'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['address1'] . '</td>
                    <td>' . $row['address2'] . '</td>
                    <td>0' . $row['phone'] . '</td>
                    <td>' . $row['regdat'] . '</td>
                    <td><a class="btn btn-sm btn-primary" href="edit.php?id=' . $row['id'] . '">edit</a></td>
                        <td><a class="btn btn-sm btn-danger" href="delete.php?id=' . $row['id'] . '">Delete</a></td>
                    </tr>';
                }
                echo '
                </tbody>
                </table>
                </div>'; // Close the table so that it is ready for displaying.
                mysqli_free_result($result); // Free up the resources.

            } else {
                $errorstring = 'The name is not in the database';
                echo '<div class="col-50" style="display: block; margin:auto">';
                echo '<div class="row text-center align-content-center" style="display: block;">';
                echo '<p style="color:red">' . $errorstring . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } catch (Exception $e) {
            print $e->getMessage();
        } catch (Error $e) {
            print $e->getMessage();
        }
    } else {
        $errorstring = "Error! The following errors occured: <br>";
        foreach ($errors as $msg) { //print the errors
            $errorstring .= "- $msg<br>\n";
        }
        $errorstring .= "Please try again.<br>";
        $errorstring .= "Please try again.<br>";
        echo '<div class="col-50" style="display: block; margin:auto">';
        echo '<div class="row text-center align-content-center" style="display: block;">';
        echo '<p style="color:red">' . $errorstring . '</p>';
        echo '</div>';
        echo '</div>';
    }
} // end if ($_SERVER['REQUEST_METHOD'] == 'POST') 