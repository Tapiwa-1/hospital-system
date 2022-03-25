<?php include("header.php") ?>
<div class="container-fluid">
    <div class="table-responsive">
        <?php
        try {
            // This script retrieves all the records from the department table.
            //require("../mysqli_connect.php"); // Connect to the database.
            // Make the query:
            // Nothing passed from user safe query									#1
            $query = "SELECT patient, illness, occur, moreinfo, prescription, results, id,
                        DATE_FORMAT(startdate, '%M %d, %Y') AS sdate, 
                        DATE_FORMAT(reviewdate, '%M %d, %Y') AS rdate, 
                        DATE_FORMAT(appointmentdate, '%M %d, %Y') As adate 
                        FROM patientillness
                        WHERE practitioner = ? AND responded IS NOT NULL
                        ORDER BY adate DESC";
            $q = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($q, $query);
            // bind $id to SQL Statement
            mysqli_stmt_bind_param($q, "i", $_SESSION['id']);
            // execute query
            mysqli_stmt_execute($q);
            $result = mysqli_stmt_get_result($q);
            if ($result) { // If it ran OK, display the records.
                // Table header. 									#2
                echo '<table class="table">';
                echo
                '<thead>
                <tr>
                    <th>Pateint Name</th>
                    <th>Gender</th>
                    <th>illness</th>
                    <th>Start date</th>
                    <th>occur</th>
                    <th>Results</th>
                    <th>prescription</th>
                    <th>Date of review</th>
                    <th>other</th>
                    <th>email</th>
                    <th>edit</th>
                    <th>Delete</th>
                    </tr>
                </thead>
                <tbody>';
                // Fetch and print all the records:							#3
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $sql = 'SELECT CONCAT(firstname," ",lastname) AS name, email, gender FROM patientdetails WHERE id= "' . $row['patient'] . '" LIMIT 1'; //fetching a record from department
                    $r = mysqli_query($dbcon, $sql);
                    $ro = mysqli_fetch_assoc($r);
                    echo
                    '<tr>
                        <td>' . $ro['name'] . '</td>
                        <td>' . $ro['gender'] . '</td>
                        <td>' . $row['illness'] . '</td>
                        <td>' . $row['sdate'] . '</td>
                        <td>' . $row['occur'] . '</td>
                        <td>' . $row['results'] . '</td>
                        <td class="moreinfo">' . $row['prescription'] . '</td>
                        <td>' . $row['rdate'] . '</td>
                        <td>' . $row['moreinfo'] . '</td>
                        <td>' . $ro['email'] . '</td>
                        <td><a class="btn btn-primary btn-sm"href="edit.php?id=' . $row['id'] . '">edit</a></td>
                        <td><a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id'] . '">Delete</a></td>
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
</div>
<?php include("footer.php") ?>