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
            //require('../mysqli_connect.php'); //Connect to the db
            //search if the record exist first else error no such record
            //session['id'] for patient
            $query = 'SELECT id FROM practitionerdetails 
                    WHERE firstname ="' . $firstnametrim . '" AND lastname ="' . $lastnametrim . '"';

            $result = mysqli_query($dbcon, $query); // Run the query;
            if (mysqli_num_rows($result) != 0) { //everything is okay
                $r = mysqli_query($dbcon, $query);
                $ro = mysqli_fetch_assoc($r);
                // 
                $query = "SELECT  illness, prescription,results, id,
                DATE_FORMAT(startdate, '%M %d, %Y')  AS sdate,
                DATE_FORMAT(appointmentdate, '%M %d, %Y')  AS adate,
                DATE_FORMAT(reviewdate, '%M %d, %Y')  AS rdate
                FROM patientillness ";
                $query .=
                    'WHERE patient ="' . $_SESSION['id'] . '" AND practitioner ="' . $ro['id'] . '"
                ORDER BY adate DESC';
                $result = mysqli_query($dbcon, $query); // Run the query;
                if (mysqli_num_rows($result) != 0) { //everything is okay
                    echo '<div class="table-responsive" style="font-size: 12px;">';
                    echo '<table class="table">';
                    echo
                    '<thead>
                    <tr>
                        <th>illness</th>
                        <th>prescription</th>
                        <th>Start Date</th>
                        <th>Appointment Date</th>
                        <th>review date</th>
                        <th>result</th>
                        <th>Contact</th>
                        <th>Delete</th>

                    </tr>
                    </thead>
                    <tbody>';
                    // Fetch and print all the records
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo
                        '<tr>
                        <td>' . $row['illness'] . '</td>
                        <td>' . $row['prescription'] . '</td>
                        <td>' . $row['sdate'] . '</td>
                        <td>' . $row['adate'] . '</td>
                        <td>' . $row['rdate'] . '</td>
                        <td>' . $row['results'] . '</td>
                        <td><a class="btn btn-primary btn-sm" href="">contact</a></td>
                        <td><a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id'] . '">Delete</a></td>
                        </tr>';
                    }
                    echo '</tbody></table></div>'; // Close the table so that it is ready for displaying.
                    mysqli_free_result($result); // Free up the resources.

                } else {
                    $errorstring = 'The name is not in the database';

                    echo '<div class="alert alert-danger m-2">';
                    echo  $errorstring;
                    echo '</div>';
                }
            } else { //The firstname and lastname is not in the database
                $errorstring = 'The name is not in the database';

                echo '<div class="alert alert-danger m-2">';
                echo  $errorstring;
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