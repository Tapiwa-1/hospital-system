<?php
try {
    // After clicking the Edit link in the records view This code is executed 
    // The code looks for a valid user ID, either through GET or POST:
    if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) { // From view-records.php this checks the ID of the record
        $id = htmlspecialchars($_GET['id'], ENT_QUOTES);
    } elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) { // Form submission.
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES);
    } else { // No valid ID, kill the script.
        echo '<p class="text-center">This page has been accessed in error.</p>';
        exit();
    }

    //require('../mysqli_connect.php'); //connect to the database
    // Has the form been submitted?
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        // Look for the illness{
        //$patient = $patientname;
        //$practitioner = $_SESSION['doctor'];
        $prescription = filter_var($_POST['prescription'], FILTER_SANITIZE_STRING);
        if (empty($prescription)) {
            $errors[] = 'You forgot to enter prescription';
        }
        $reviewdate = filter_var($_POST['reviewdate'], FILTER_SANITIZE_STRING);
        if (empty($reviewdate)) {
            $errors[] = 'You forgot to enter reviewdate';
        }
        $result = filter_var($_POST['results'], FILTER_SANITIZE_STRING);
        if (empty($result)) {
            $errors[] = 'You forgot to enter results';
        }

        if (empty($errors)) { // If everything's OK.                                     
            $query = 'UPDATE patientillness 
                    SET prescription=?,results=?, reviewdate=?
                    WHERE id=? 
                    LIMIT 1';
            $q = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($q, $query);
            // bind values to SQL Statement
            mysqli_stmt_bind_param($q, 'sssi', $prescription, $results, $reviewdate,  $id);
            // execute query
            // execute query
            mysqli_stmt_execute($q);
            if (mysqli_stmt_affected_rows($q) == 1) { // Update OK
                // Echo a message if the edit was satisfactory:
                header("Location:practitioner-viewrecords.php");
            } else {
                echo '<p">The user could not be edited due to a system error.';
                echo ' We apologize for any inconvenience.</p><br>'; // Public message.
                echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>'; // Debugging message.
                // Message above is only for debug and should not display sql in live mode
            }
        } else { // Display the errors.
            echo '<p class="text-center">The following error(s) occurred:<br />';
            foreach ($errors as $msg) { // Echo each error.
                echo " - $msg<br />\n";
            }
            echo '</p><p>Please try again.</p>';
        } // End of if (empty($errors))section.
    }
    // End of the conditionals
    // Select the illness information to display in textboxes:                                    #3
    $q = mysqli_stmt_init($dbcon);
    $query = "SELECT illness ,startdate, occur, allegies, 
                DATE_FORMAT(appointmentdate, '%M %d, %Y') As adate,
                DATE_FORMAT(reviewdate, '%M %d, %Y') AS rdate, moreinfo, results, prescription
                FROM patientillness WHERE id=?";
    mysqli_stmt_prepare($q, $query);
    // bind $id to SQL Statement
    mysqli_stmt_bind_param($q, 'i', $id);
    // execute query
    mysqli_stmt_execute($q);
    $result = mysqli_stmt_get_result($q);
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    if (mysqli_num_rows($result) == 1) { // Valid user ID, display the form.
        // Get the information:
        // Create the form:

?>
        <!--Edit here-->
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="d-flex">
                    <h6>illness: </h6>
                    <p><?php echo htmlspecialchars($row[0], ENT_QUOTES); ?></p>
                </div>
                <div class="d-flex">
                    <h6>Start Date: </h6>
                    <p><?php echo htmlspecialchars($row[1], ENT_QUOTES); ?></p>
                </div>
                <div class="d-flex">
                    <h6>Number of occur: </h6>
                    <p><?php echo htmlspecialchars($row[2], ENT_QUOTES); ?></p>
                </div>
                <div class="d-flex">
                    <h6>
                        <p><?php echo htmlspecialchars($row[3], ENT_QUOTES); ?></p>
                </div>
                <div class="flex">
                    <h6>Appointment Date:</h6>
                    <p><?php echo htmlspecialchars($row[4], ENT_QUOTES); ?></p>
                </div>
            </div>

            <div class="col-md-4">
                <form action="respond.php" method="POST" name="respondform" process-respond.php>
                    <div class="form-group">
                        <label for="prescription">prescription</label>
                        <input class="form-control" type="text" name="prescription" required placeholder="Enter prescription" value="<?php echo htmlspecialchars($row[8], ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="results">Results</label>
                        <input type="text" class="form-control" name="results" required placeholder="Results" value="<?php echo htmlspecialchars($row[7], ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="reviewdate">Review date</label>
                        <input type="date" class="form-control" name="reviewdate" required placeholder="enter date" value="<?php echo htmlspecialchars($row[5], ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $id ?>" />
                        <!--The hidden input value (id) ensures that no field for the user ID is displayed in the form unless an ID has been passed either from the admin_view_users.php page (via GET) or from the edit_user.php (via POST)-->
                    </div>

            </div>
            <div class="col-md-8">
                <input type="submit" class="btn btn-color w-100 my-2" value="submit" name="submit">
                </form>
            </div>
            <!--Edit here-->
    <?php
    } else { // The user could not be validated
        echo '<p class="text-center">This page has been accessed in error.</p>';
    }
    mysqli_stmt_free_result($q);
    mysqli_close($dbcon);
} catch (Exception $e) {
    print "The system is busy. Please try later";
    print "An Exception occurred.Message: " . $e->getMessage();
} catch (Error $e) {
    print "The system is currently busy. Please try again later";
    print "An Error occured. Message: " . $e->getMessage();
}
    ?>