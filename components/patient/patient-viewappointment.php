<?php include("header.php") ?>
<div class="container">
    <div style="min-width: 750px !important; overflow:auto">
        <?php
        try {
            // This script retrieves all the records from the  table.
            //require("../mysqli_connect.php"); // Connect to the database.
            // Make the query:
            // Nothing passed from user safe query									#1
            $query = "SELECT id, practitioner,illness, prescription,results, moreinfo,
                    DATE_FORMAT(startdate, '%M %d, %Y')  AS sdate,
                    DATE_FORMAT(appointmentdate, '%M %d, %Y')  AS adate,
                    DATE_FORMAT(reviewdate, '%M %d, %Y')  AS rdate
                    FROM patientillness
                    WHERE patient =" . $_SESSION['id'] . " AND responded IS NULL 
                    ORDER BY adate DESC";

            $result = mysqli_query($dbcon, $query); // Run the query.
            if ($result) { // If it ran OK, display the records.
                // Table header. 									#2
                echo '<table class="table" style="font-size: 12px;">';
                echo
                '<thead>
            <tr>
                        <th scope="col">Practitioner</th>
                        <th scope="col">illness</th>
                        <!--<th scope="col">prescription</th>-->
                        <th scope="col">Start Date</th>
                        <th scope="col">Appointment Date</th>
                        <!--<th scope="col">reveiw date</th>-->
                        <!--<th scope="col">result</th>-->
                        <th scope="col">More</th>
                        <th scope="col">Contact</th>
                        <th scope="col">edit</th>
                        <th scope="col">Delete</th>
            </thead></tr>';
                // Fetch and print all the records:							#3
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $sql = 'SELECT CONCAT(firstname," ",lastname) AS name FROM practitionerdetails WHERE id= "' . $row['practitioner'] . '" LIMIT 1'; //fetching a record from d
                    $r = mysqli_query($dbcon, $sql);
                    $ro = mysqli_fetch_assoc($r);
                    // Remove special characters that might already be in table to 
                    // reduce the chance of XSS exploits
                    echo
                    '<tbody>
                <tr>
                        <td>' . $ro['name'] . '</td>
                        <td>' . $row['illness'] . '</td>
                        <td>' . $row['sdate'] . '</td>
                        <td>' . $row['adate'] . '</td>
                        <td>' . $row['moreinfo'] . '</td>
                        <td><a class="btn btn-primary btn-sm" href="contact.php?">Contact</a></td>
                        <td><a class="btn btn-primary btn-sm" href="edit.php?id=' . $row['id'] . '">Edit</a></td>
                        <td><a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id'] . '">Delete</a></td>
                        </tr>';
                }
                echo '</tbody></table>'; // Close the table so that it is ready for displaying.
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