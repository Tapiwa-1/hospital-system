<?php
try {
    // Check for a valid user ID, through GET or POST:
    if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) { // From view table
        $id = htmlspecialchars($_GET['id'], ENT_QUOTES);
    } else
        if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) { // Form submission.      #1
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES);
    } else { // No valid ID, kill the script.
        //	return to login page
        header("Location: patient-contact.php");
        exit();
    }
    //require('../mysqli_connect.php');
    // Check if the form has been submitted:                                               #2
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sure = htmlspecialchars($_POST['send'], ENT_QUOTES);
        $message = htmlspecialchars($_POST['message'], ENT_QUOTES);
        if ($send == 'Send') { // Insert a record
            // Make the query:
            // Use prepare statement to remove security problems
            $q = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($q, "INSERT INTO messages (id, patient, practitioner, message) VALUES ('',?,?,? );");
            // bind $id to SQL Statement
            mysqli_stmt_bind_param($q, "sss", $_SESSION['id'], $id, $message);
            // execute query
            mysqli_stmt_execute($q);
            if (mysqli_stmt_affected_rows($q) == 1) { // It ran OK
                // Print a message:
                header("Location: message.php");
            } else { // If the query did not run OK display public message
                echo '<p class="text-center">The record could not be deleted.';
                echo '<br>Either it does not exist or due to a system error.</p>';
                echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>';
                // Debugging message. When live comment out because this displays sql
            }
        } else { // User did not confirm deletion.
            header("Location: patient-viewrecords.php");
        }
    } else { // Show the form.                                                               #3
?>
        <div class="">
            <div class="col-md-8 mx-auto">
                <div class="profile py-3 btn-color">
                    <?php
                    $query = "SELECT CONCAT(firstname, ', ', lastname) AS name ";
                    $query .= "FROM practitionerdetails WHERE id = ?";
                    $q = mysqli_stmt_init($dbcon);
                    mysqli_stmt_prepare($q, $query);

                    // bind $id to SQL Statement
                    mysqli_stmt_bind_param($q, "s", $id);
                    // execute query`patientdetails`
                    mysqli_stmt_execute($q);
                    $result = mysqli_stmt_get_result($q);
                    if ($result) { // If it ran OK, display the records.
                        // Fetch and print all the records
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            echo '<h5 class="text-center">' . $row['name'] . '</h5>';
                        }
                        mysqli_free_result($result); // Free up the resources
                    } else { // If it did not run OK.
                        // Error message:
                        echo '<p class="error">The current users could not be retrieved. We apologize';
                        echo ' for any inconvenience.</p>';
                        // Debug message:
                        // echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
                        exit;
                    } // End of if ($result)
                    //mysqli_close($dbcon); // Close the database connection.
                    ?>
                </div>

                <div class=" justify-content-between">
                    <div class="receiver col-10 col-md-6 me-auto bg-primary p-1 rounded mt-1">
                        <div class="message-body">
                            hello
                        </div>
                    </div>
                    <div class="sender col-10 col-md-6 ms-auto bg-success p-1 border rounded mt-1">
                        How are you
                    </div>
                    <div class="receiver col-10 col-md-6 me-auto bg-primary p-1 rounded mt-1">
                        <div class="message-body">
                            hello
                        </div>
                    </div>
                    <div class="sender col-10 col-md-6 ms-auto bg-success p-1 border rounded mt-1">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officiis id iusto reprehenderit dolor laborum, quisquam quas vel quo? Beatae illum ut incidunt, suscipit mollitia explicabo ipsam facere magni totam odit.
                    </div>
                    <div class="sender  col-10 col-md-6 ms-auto bg-success p-1 border rounded mt-1">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officiis id iusto reprehenderit dolor laborum, quisquam quas vel quo? Beatae illum ut incidunt, suscipit mollitia explicabo ipsam facere magni totam odit.
                    </div>
                    <div class="receiver col-10 col-md-6 me-auto bg-primary p-1 rounded mt-1">
                        <div class="message-body">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut sint doloribus est, voluptas neque necessitatibus facere ad adipisci totam, dignissimos nemo nostrum rerum? Ipsum, dicta quo error itaque laudantium officiis.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 my-2 mx-auto">
            <div class="row d-flex">
                <div class="col-10">
                    <form action="message.php" method="POST">
                        <div class="form-group">
                            <input type="text" placeholder="Send message...." class="form-control" value="<?php if (isset($_POST['message'])) echo $_POST['message']; ?>" required>
                        </div>
                </div>
                <div class="col-2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <input type="submit" value="Send" class="btn btn-primary w-100">
                    </div>
                    </form>
                </div>

            </div>
        </div>

<?php
    } // End of the main submission conditional.
    mysqli_stmt_close($q);
    mysqli_close($dbcon);
} catch (Exception $e) {
    print "The system is busy. Please try again.";
    print "An Exception occurred.Message: " . $e->getMessage();
} catch (Error $e) {
    print "The system is currently busy. Please try again soon.";
    print "An Error occured. Message: " . $e->getMessage();
}
?>