<?php include("header.php") ?>
<div class="container">
    <?php
    try {
        // This script retrieves all the records from the department table.

        // Make the query:
        // Nothing passed from user safe query									#1
        $query = "SELECT patient, illness, id,
                        DATE_FORMAT(startdate, '%M %d, %Y') AS sdate, 
                        DATE_FORMAT(appointmentdate, '%M %d, %Y') As adate 
                        FROM patientillness 
                        WHERE practitioner =? AND responded IS NULL
                        ORDER BY adate DESC";
        $q = mysqli_stmt_init($dbcon);
        mysqli_stmt_prepare($q, $query);
        // bind $id to SQL Statement
        mysqli_stmt_bind_param($q, "i", $_SESSION['id']);
        // execute query
        mysqli_stmt_execute($q);
        $result = mysqli_stmt_get_result($q);
        if (mysqli_num_rows($result) != 0) {
            if ($result) { // If it ran OK, display the records.
                // Table header. 									#2
                echo '<table class="table" style="font-size:14px">';
                echo
                '<thead>
                <tr>
                        <th>Pateint Name</th>
                        <th>Illness</th>
                        <th>Start date</th>
                        <th>Appointment date</th>
                        <th>Respond</th>
                </tr>
                </thead>
                <tbody>';
                // Fetch and print all the records:							#3
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $sql = 'SELECT CONCAT(firstname," ",lastname) AS name FROM patientdetails WHERE id= "' . $row['patient'] . '" LIMIT 1'; //fetching a record from department
                    $r = mysqli_query($dbcon, $sql);
                    $ro = mysqli_fetch_assoc($r);
                    echo
                    '<tr>
                        <td>' . $ro['name'] . '</td>
                        <td>' . $row['illness'] . '</td>
                        <td>' . $row['sdate'] . '</td>
                        <td>' . $row['adate'] . '</td>
                        <td><a class="btn btn-primary btn-sm" href="respond.php?id=' . $row['id'] . '">Respond</a></td>
                        </tr>';
                }
                echo
                '</tbody>
                </table>'; // Close the table so that it is ready for displaying.
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
        } else {
            echo '<div class="row" style="text-align:center;">';
            echo '<p style="color:green;margin-top:50px;">No pending appointments</p>';
            echo '</div>';
        }
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