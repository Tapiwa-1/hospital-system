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
        $illness = filter_var($_POST['illness'], FILTER_SANITIZE_STRING);
        if (empty($illness)) {
            $errors[] = 'You forgot to enter illness';
        }
        $startdate = filter_var($_POST['startdate'], FILTER_SANITIZE_STRING);
        if (empty($startdate)) {
            $errors[] = 'You forgot to enter startdate';
        }
        $occur = filter_var($_POST['occur'], FILTER_SANITIZE_NUMBER_INT);
        if (empty($occur)) {
            $errors[] = 'You forgot to enter occurance';
        }
        $allegies = filter_var($_POST['allegies'], FILTER_SANITIZE_STRING);
        if (empty($allegies)) {
            $errors[] = 'You forgot to enter allegies';
        }
        $appointmentdate = filter_var($_POST['appointmentdate'], FILTER_SANITIZE_STRING);
        if (empty($appointmentdate)) {
            $errors[] = 'You forgot to enter appointmentdate';
        }
        $moreinfo = filter_var($_POST['moreinfo'], FILTER_SANITIZE_STRING);
        if (empty($errors)) { // If everything's OK.                                     
            $query = 'UPDATE patientillness 
                    SET illness=?,startdate=?, occur=?, allegies=?, appointmentdate=?, moreinfo=?
                    WHERE id=? 
                    LIMIT 1';
            $q = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($q, $query);
            // bind values to SQL Statement
            mysqli_stmt_bind_param($q, 'ssssssi', $illness, $startdate, $occur, $allegies, $appointmentdate, $moreinfo, $id);
            // execute query
            // execute query
            mysqli_stmt_execute($q);
            if (mysqli_stmt_affected_rows($q) == 1) { // Update OK
                // Echo a message if the edit was satisfactory:
                header("Location:patient-viewrecords.php");
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
    $query = "SELECT illness ,startdate, occur, allegies, DATE_FORMAT(appointmentdate, '%M %d, %Y') As adate, moreinfo FROM patientillness WHERE id=?";
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
        <div class="container mt-md-4">
            <div class="col-md-4 shadow-sm pt-1 mb-5 m-auto p-md-2">
                <form action="edit.php" method="POST" name="editform" process-edit-record.php>
                    <div class="form-group">
                        <h3>FILL IN THE FOLLOWING</h3>
                    </div>
                    <div class="form-group">
                        <label for="firstname">illness</label>
                        <input class="form-control" type="text" name="illness" required placeholder="Enter illness" value="<?php echo htmlspecialchars($row[0], ENT_QUOTES); ?>">
                    </div>

                    <div class="form-group">
                        <label for="illnessstart">When did it started</label>
                        <input class="form-control" type="date" name="startdate" required placeholder="When did you started filling that way" value="<?php echo htmlspecialchars($row[1], ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="numberoccur">Number of occurance</label>
                        <input class="form-control" type="number" name="occur" required placeholder="Enter number of times it occured" value="<?php echo htmlspecialchars($row[2], ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="allegies">Any allegies</label>
                        <input class="form-control" type="text" name="allegies" required placeholder="Enter allegies" value="<?php echo htmlspecialchars($row[3], ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="AppointmentDate">Appointment Date</label>
                        <input class="form-control" type="date" name="appointmentdate" required placeholder="enter date" value="<?php echo htmlspecialchars($row[4], ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <p class=" text-warning">Constaltation fee for this practitioner is $39.99 only
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="moreinfo">Any More information</label>
                        <textarea class="form-control" placeholder="Enter More details here" name="moreinfo" value="<?php echo htmlspecialchars($row[5], ENT_QUOTES); ?>""></textarea>
                    </div>
                    <div class=" form-group">
                        <input type="hidden" name="id" value="<?php echo $id ?>" /> <!--The hidden input value (id) ensures that no field for the user ID is displayed in the form unless an ID has been passed either from the admin_view_users.php page (via GET) or from the edit_user.php (via POST)-->
                    </div>
                    <div class="form-group">
                        <input class="btn btn-color  w-100 my-1" type="submit" value="submit" name="submit">
                    </div>
                </form>
            </div>
        </div>
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