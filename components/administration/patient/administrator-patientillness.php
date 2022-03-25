<?php include("header.php") ?>
<div class="row">
    <?php
    try {
        // This script retrieves all the records from the  table.
        //require("../../mysqli_connect.php"); // Connect to the database.
        // Make the query:
        // Nothing passed from user safe query									#1
        $query = "SELECT id, practitioner,illness, prescription,results, moreinfo, patient,
                    DATE_FORMAT(startdate, '%M %d, %Y')  AS sdate,
                    DATE_FORMAT(appointmentdate, '%M %d, %Y')  AS adate,
                    DATE_FORMAT(reviewdate, '%M %d, %Y')  AS rdate
                    FROM patientillness 
                    ORDER BY adate DESC";

        $result = mysqli_query($dbcon, $query); // Run the query.
        if ($result) { // If it ran OK, display the records.
            // Table header. 									#2
            echo
            '<div class="table-responsive">
            <table class="table" style="font-size:14px">';
            echo
            '<thead>
            <tr>
                        <th>Patient</th>
                        <th>Practitioner</th>
                        <th>illness</th>
                        <th>prescription</th>
                        <th>Start Date</th>
                        <th>Appointment Date</th>
                        <th>reveiw date</th>
                        <th>result</th>
                        <th>More</th>
                        <th>Contact</th>
                        <th>Delete</th>
            </tr>
            </thead>
            <tbody>';
            // Fetch and print all the records:							#3
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $sql = 'SELECT CONCAT(firstname," ",lastname) AS name FROM practitionerdetails WHERE id= "' . $row['practitioner'] . '" LIMIT 1'; //fetching a record
                $sql2 = 'SELECT CONCAT(firstname," ",lastname) AS name FROM patientdetails WHERE id= "' . $row['patient'] . '" LIMIT 1'; //fetching a record
                $r = mysqli_query($dbcon, $sql);
                $r2 = mysqli_query($dbcon, $sql2);
                $ro = mysqli_fetch_assoc($r);
                $ro2 = mysqli_fetch_assoc($r2);
                // Remove special characters that might already be in table to 
                // reduce the chance of XSS exploits
                echo
                '<tr>
                        <td>' . $ro2['name'] . '</td>
                        <td>' . $ro['name'] . '</td>
                        <td>' . $row['illness'] . '</td>
                        <td>' . $row['prescription'] . '</td>
                        <td>' . $row['sdate'] . '</td>
                        <td>' . $row['adate'] . '</td>
                        <td>' . $row['rdate'] . '</td>
                        <td>' . $row['results'] . '</td>
                        <td>' . $row['moreinfo'] . '</td>
                        <td><a class="btn btn-primary btn-sm" href="contact.php?">Contact</a></td>
                        <td><a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id'] . '">Delete</a></td>
                        </tr>';
            }
            echo
            '</tbody>
            </table>
            </div>'; // Close the table so that it is ready for displaying.
            mysqli_free_result($result); // Free up the resources.
        } else { // If it did not run OK.
            // Error message:
            echo '<p class="error">The current users could not be retrieved. We apologize';
            echo ' for any inconvenience.</p>';
            // Debug message:
            // echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
            exit;
        } // End of if ($result) 
        mysqli_close($dbcon); // Close the database connection.
    } catch (Exception $e) // We finally handle any problems here                
    {
        print "An Exception occurred. Message: " . $e->getMessage();
        print "The system is busy please try later";
    } catch (Error $e) {
        print "An Error occurred. Message: " . $e->getMessage();
        print "The system is busy please try again later.";
    }
    ?>
</div>
</div>
<?php include("footer.php") ?>