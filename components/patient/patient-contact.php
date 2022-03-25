<?php include("header.php") ?>
<div class="container mb-5">
    <div class="h5 text-center my-3">Contact Practitioners here</div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <?php
            try {
                // This script retrieves all the records from the department table.
                //require("../../mysqli_connect.php"); // Connect to the database.
                // Make the query:
                // Nothing passed from user safe query									#1
                $query = "SELECT id, firstname, lastname, gender, email, address1, address2, experience, department, phone 
            FROM practitionerdetails
            ORDER BY id ASC";
                $result = mysqli_query($dbcon, $query); // Run the query. 
                if (mysqli_num_rows($result) != 0) { //everything is okay
                    if ($result) { // If it ran OK, display the records.


                        // Fetch and print all the records:							#3
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $sql = 'SELECT name FROM practitionerdepartment WHERE id= "' . $row['department'] . '" LIMIT 1'; //fetching a record from department
                            $r = mysqli_query($dbcon, $sql);
                            $ro = mysqli_fetch_assoc($r);
                            echo
                            '<div class="container border-bottom" style="height: 50px;">
                                <div class="row align-items-center">'; #2
                            echo
                            '
                            <div class="col-5">
                                Name: ' . $row['firstname'] . ' ' . $row['lastname'] . '
                            </div>
                            <div class="col-5">
                                Department:  ' . $ro['name'] . '
                            </div>
                            <div class="col-2">
                                <a class="btn btn-primary btn-sm " href="message.php?id=' . $row['id'] . '">Contact</a>
                            </div>';
                            echo
                            '</div>
                                </div>';
                        }
                        mysqli_free_result($result); // Free up the resources.
                    } else { // If it did not run OK.
                        // Error message:
                        echo '<p class="error">The current users could not be retrieved. We apologize';
                        echo ' for any inconvenience.</p>';
                        // Debug message:
                        // echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
                        exit;
                    } // End of if ($result)
                } else {
                    $errorstring = 'No records found';
                    echo '<div class="col-50" style="display: block; margin:auto">';
                    echo '<div class="row text-center align-content-center" style="display: block;">';
                    echo '<p style="color:red">' . $errorstring . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
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