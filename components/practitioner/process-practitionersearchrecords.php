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
            $query = 'SELECT id, gender, email FROM patientdetails 
                    WHERE firstname ="' . $firstnametrim . '" AND lastname ="' . $lastnametrim . '"';

            $result = mysqli_query($dbcon, $query); // Run the query;

            if (mysqli_num_rows($result) != 0) { //everything is okay
                $r = mysqli_query($dbcon, $query);
                $ro = mysqli_fetch_assoc($r);
                $query = "SELECT  illness, prescription,results, occur, moreinfo, id,
                DATE_FORMAT(startdate, '%M %d, %Y')  AS sdate,
                DATE_FORMAT(appointmentdate, '%M %d, %Y')  AS adate,
                DATE_FORMAT(reviewdate, '%M %d, %Y')  AS rdate
                FROM patientillness ";
                $query .=
                    'WHERE practitioner ="' . $_SESSION['id'] . '" AND patient ="' . $ro['id'] . '"
                ORDER BY adate DESC';
                $result = mysqli_query($dbcon, $query); // Run the query;
                if (mysqli_num_rows($result) != 0) { //everything is okay
                    echo
                    '
                    <div class="able-responsive">
                    <table class="table">';
                    echo
                    '<thead>
                    <tr?>
                    <th>Gender</th>
                    <th>illness</th>
                    <th>Start date</th>
                    <th>occur</th>
                    <th>Results</th>
                    <th>prescription</th>
                    <th>Date of review</th>
                    <th>otherr</th>
                    <th>email</th>
                    <th>Contact</th>
                    <th>Delete</th>
                    <th>edit</th>
                    </tr>
                    </thead>
                    <tbody>';
                    // Fetch and print all the records
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo
                        '<tr>
                        <td>' . $ro['gender'] . '</td>
                        <td>' . $row['illness'] . '</td>
                        <td>' . $row['sdate'] . '</td>
                        <td>' . $row['occur'] . '</td>
                        <td>' . $row['results'] . '</td>
                        <td>' . $row['prescription'] . '</td>
                        <td>' . $row['rdate'] . '</td>
                        <td>' . $row['moreinfo'] . '</td>
                        <td>' . $ro['email'] . '</td>
                        <td><a class="btn btn-primary btn-sm" href="">Here</a></td>
                        <td><a  class="btn btn-primary btn-sm" href="edit.php?id=' . $row['id'] . '">edit</a></td>
                        <td><a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id'] . '">Delete</a></td>
                        </tr>';
                    }
                    echo '
                    </tbody>
                    </table>'; // Close the table so that it is ready for displaying.
                    echo '</div>';
                    mysqli_free_result($result); // Free up the resources.

                } else { //The firstname and lastname is not in the database
                    $errorstring = 'The name is not in the database';
                    echo '<div class="col-50" style="display: block; margin:auto">';
                    echo '<div class="row text-center align-content-center" style="display: block;">';
                    echo '<p style="color:red">' . $errorstring . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else { //The firstname and lastname is not in the database
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