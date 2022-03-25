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

    //require('../../mysqli_connect.php'); //connect to the database
    // Has the form been submitted?
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
    //Check for a name
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);  //Removing potential SQL Injection
    if ((!empty($name)) && (preg_match('/[a-z\s]/i', $name)) && (strlen($name) <= 30)) {
        //Sanitize the trimmed  name
        $nametrim = $name;
    } else {
        $errors[] = 'Name missing or not alphabetic and space characters. Max 30';
    }
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);  //Removing potential SQL Injection
    if (empty($description)) {
        $errors[] = 'You forgot to enter description';
    }
        if (empty($errors)) { // If everything's OK.   
            //check if the email doesnt exist
            //require('../../mysqli_connect.php'); //Connect to the db
            $q = mysqli_stmt_init($dbcon);
            $query = 'SELECT id FROM financedepartment WHERE name=? AND id !=?';
            mysqli_stmt_prepare($q, $query);
            // bind $id to SQL Statement
            mysqli_stmt_bind_param($q, 'si', $name, $id);
            // execute query
            mysqli_stmt_execute($q);
            $result = mysqli_stmt_get_result($q);
            if (mysqli_num_rows($result) == 0) { // name does not exist in another record
                $query = 'UPDATE financedepartment
                    SET name=?, description=?
                    WHERE id=? 
                    LIMIT 1';
                $q = mysqli_stmt_init($dbcon);
                mysqli_stmt_prepare($q, $query);
                // bind values to SQL Statement
                mysqli_stmt_bind_param($q, 'sss', $nametrim, $description, $id);
                // execute query
                // execute query
                mysqli_stmt_execute($q);
                if (mysqli_stmt_affected_rows($q) == 1) { // Update OK
                    // Echo a message if the edit was satisfactory:
                    $message =
                    '<div class="alert alert-success" style="text-align:center">
                        Edit successfull
                    </div>';
                } else {
                    echo '<p">The user could not be edited due to a system error.';
                    echo ' We apologize for any inconvenience.</p><br>'; // Public message.
                    echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>'; // Debugging message.
                    // Message above is only for debug and should not display sql in live mode
                }
            } //end of if (mysqli_num_rows($result) == 0) { // e-mail does not exist in another record
            else { // Already registered.
                $message =
                '<div class="alert alert-danger" style="text-align:center">
                    Name already taken
                </div>';
            }
        } else { // Display the errors.
            echo '<div class="row" style="text-align:center">';
            echo '<p  style="color:red">The following error(s) occurred:<br />';
            foreach ($errors as $msg) { // Echo each error.
                echo " - $msg<br />\n";
            }
            echo '</p><p  style="color:red">Please try again.</p>';
            echo '</div>';
        } // End of if (empty($errors))section.
    }
    // End of the conditionals
    // Select the illness information to display in textboxes:                                    #3
    $q = mysqli_stmt_init($dbcon);
    $query = "SELECT name, description
            FROM financedepartment
            WHERE id=?";
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
<form action="edit-dept.php" method="POST">
    <div class="container">
        <div class="col-md-4 m-auto">
            <h5>FILL IN THE FOLLOWING</h5>
            <div class="row">
                <div class="form-group">
                    <?php if(isset($message)){
                        echo $message;
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="departmentname">Department Name</label>
                    <input class="form-control" type="text" name="name" required placeholder="Enter Department Name" value="<?php echo htmlspecialchars($row[0], ENT_QUOTES); ?>">
                </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="moreinfo">Enter Description</label>
                <textarea class="form-control" placeholder="Enter Department Description here" name="description" required value="<?php echo htmlspecialchars($row[1], ENT_QUOTES); ?>"></textarea>
            </div>
            <div class="form-group">
                <input class="btn btn-color w-100 my-2" type="submit" value="submit" name="submit_form">
            </div>
        </div>
    </div>

</form>
        <!--Edit here-->
<?php
    } else { // The user could not be validated
        echo '<p class="text-center">This page has been accessed in error.</p>';
    }
    mysqli_stmt_free_result($q);
    mysqli_close($dbcon);
} catch (Error $e) {
    print "The system is currently busy. Please try again later";
    print "An Error occured. Message: " . $e->getMessage();
}
?>