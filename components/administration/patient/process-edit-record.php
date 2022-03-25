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
        // Look for the illness{
        //$patient = $patientname;
        //$practitioner = $_SESSION['doctor'];
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

        //Check for gender
        $gender = filter_var($_POST['gender'], FILTER_SANITIZE_STRING); //Removing unnessecary char
        if (empty($_POST["gender"])) {
            $errors[] = "Gender is required";
        }

        // Check that an email address has been entered				
        $emailtrim = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); //Removing potential SQL Injection
        if ((empty($emailtrim)) || (!filter_var($emailtrim, FILTER_VALIDATE_EMAIL))) {
            $errors[] = 'You forgot to enter your email address';
            $errors[] = ' or the e-mail format is incorrect.';
        }
        //Is the 1st address present? If it is, sanitize it
        $address1 = filter_var($_POST['address1'], FILTER_SANITIZE_STRING); //Removing potential SQL Injection
        if ((!empty($address1)) && (preg_match('/[a-z0-9\.\s\,\-]/i', $address1)) && (strlen($address1) <= 30)
        ) {
            //Sanitize the trimmed 1st address
            $address1trim = $address1;
        } else {
            $errors[] = 'Missing address. Only numeric, alphabetic, period, comma, dash and space. Max 30.';
        }
        //If the 2nd address is present? If it is, sanitize it          #10
        $address2 = filter_var($_POST['address2'], FILTER_SANITIZE_STRING); //Removing potential SQL Injection
        if ((!empty($address2)) && (preg_match('/[a-z0-9\.\s\,\-]/i', $address2)) &&
            (strlen($address2) <= 30)
        ) {
            //Sanitize the trimmed 2nd address
            $address2trim = $address2;
        } else {
            $address2trim = NULL;
        }

        //Is the phone number present? If it is, sanitize it 
        $phone = filter_var($_POST['phonenumber'], FILTER_SANITIZE_STRING); //Removing potential SQL Injection
        if ((!empty($phone)) && (strlen($phone) <= 30)) {
            //Sanitize the trimmed phone number	
            $phonetrim = (filter_var($phone, FILTER_SANITIZE_NUMBER_INT));
            $phonetrim = preg_replace('/[^0-9]/', '', $phonetrim);
        } else {
            $phonetrim = NULL;
        }
        // Check for a password and match against the confirmed password:
        $password1trim = filter_var($_POST['password1'], FILTER_SANITIZE_STRING); //Removing potential SQL Injection
        $string_length = strlen($password1trim);
        if (empty($password1trim)) {   //                                             #7
            $errors[] = 'Please enter a valid password';
        } else {
            if (!preg_match(
                '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,12}$/',
                $password1trim
            )) {  //                        #8
                $errors[] = 'Invalid password, 8 to 12 chars, one upper, one lower, one number, one special.';
            } else {
                $password2trim = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);
                if ($password1trim === $password2trim) { //                                 #9
                    $password = $password1trim;
                } else {
                    $errors[] = 'Your two password do not match.';
                    $errors[] = 'Please try again';
                }
            }
        }
        if (empty($errors)) { // If everything's OK.   
            //check if the email doesnt exist
            $q = mysqli_stmt_init($dbcon);
            $query = 'SELECT id FROM patientdetails WHERE email=? AND id !=?';
            mysqli_stmt_prepare($q, $query);
            // bind $id to SQL Statement
            mysqli_stmt_bind_param($q, 'si', $emailtrim, $id);
            // execute query
            mysqli_stmt_execute($q);
            $result = mysqli_stmt_get_result($q);
            if (mysqli_num_rows($result) == 0) { // e-mail does not exist in another record
                $hashedpassword = password_hash($password1trim, PASSWORD_DEFAULT);
                $query = 'UPDATE patientdetails 
                    SET firstname=?, lastname=?, gender=?, email=?, address1=?, address2=?, phone=?, hashedpassword=?, user_level=4
                    WHERE id=? 
                    LIMIT 1';
                $q = mysqli_stmt_init($dbcon);
                mysqli_stmt_prepare($q, $query);
                // bind values to SQL Statement
                mysqli_stmt_bind_param($q, 'ssssssssi', $firstnametrim, $lastnametrim, $gender, $emailtrim, $address1trim, $address2trim, $phonetrim, $hashedpassword, $id);
                // execute query
                // execute query
                mysqli_stmt_execute($q);
                if (mysqli_stmt_affected_rows($q) == 1) { // Update OK
                    // Echo a message if the edit was satisfactory:
                    echo
                    '<div class="row" style="text-align:center">
                        <p style="color:green">Edit Successfully</p>
                    </div>';
                } else {
                    echo '<p">The user could not be edited due to a system error.';
                    echo ' We apologize for any inconvenience.</p><br>'; // Public message.
                    echo '<p>' . mysqli_error($dbcon) . '<br />Query: ' . $q . '</p>'; // Debugging message.
                    // Message above is only for debug and should not display sql in live mode
                }
            } //end of if (mysqli_num_rows($result) == 0) { // e-mail does not exist in another record
            else { // Already registered.
                echo
                '<div class="row" style="text-align:center">
                    <p style="color:red">Email already taken</p>
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
    $query = "SELECT id, firstname, lastname, gender, email, address1, address2, phone
            FROM patientdetails
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
        <!----Edit here--->
        <div class="container">
            <div class="row">
                <div class="container mb-md-5">

                    <div class="col-md-4 shadow-sm pt-1 m-auto p-md-2">
                        <form action="edit.php" method="POST">
                            <div class="form-group text-center">
                                <h3>REGISTRATION</h3>
                            </div>
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input class="form-control" type="text" name="firstname" required placeholder="Enter first Name" value="<?php echo htmlspecialchars($row[1], ENT_QUOTES); ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input class="form-control" type="text" name="lastname" required placeholder="Enter last Name" value="<?php echo htmlspecialchars($row[2], ENT_QUOTES); ?>"">
                            </div>
                            <div class=" form-group">
                                <label for="Gender">Gender</label>
                                <div class="form-control">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male">
                                        <label class="form-check-label" for="inlineRadio1">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                                        <label class="form-check-label" for="inlineRadio2">Female</label>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="Email"> Email</label>
                                <input class="form-control" type="email" name="email" required placeholder="example@gmail.com" value="<?php echo htmlspecialchars($row[4], ENT_QUOTES); ?>">

                            </div>
                            <div class="form-group">
                                <label for="address1">Address 1</label>
                                <input class="form-control" type="text" name="address1" required placeholder="Enter address 1" value="<?php echo htmlspecialchars($row[5], ENT_QUOTES); ?>">
                            </div>
                            <div class="form-group">
                                <label for="address1">Address 2</label>
                                <input class="form-control" type="text" name="address2" placeholder="Enter address 2" value="<?php echo htmlspecialchars($row[6], ENT_QUOTES); ?>" </div>

                            </div>
                            <div class="form-group">
                                <label for="phonenumber">Phone Number</label>
                                <input class="form-control" type="number" name="phonenumber" placeholder="Enter phone number" required value="<?php echo htmlspecialchars($row[7], ENT_QUOTES); ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" id="password1" placeholder="Enter password" name="password1" minlength="8" maxlength="12" required value="<?php if (isset($_POST['password1'])) echo $_POST['password1']; ?>">
                                <span id='message'>Between 8 and 12 characters.</span>
                            </div>
                            <div class="form-group">
                                <label for="confirmpassword"> Confirm Password</label>
                                <input class="form-control" type="password" id="password2" placeholder="Confirm password" name="password2" required value="<?php if (isset($_POST['password_2'])) echo $_POST['password_2'];  ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="hidden" name="id" value="<?php echo $id ?>" />
                                <!--The hidden input value (id) ensures that no field for the user ID is displayed in the form unless an ID has been passed either from the admin_view_users.php page (via GET) or from the edit_user.php (via POST)-->
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Register" name="submit_form" class="btn btn-color my-2 w-100">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!----Edit here--->
        <script>
            function checked() {
                if (document.getElementById('password1').value ==
                    document.getElementById('password2').value) {
                    document.getElementById('message').style.color = 'green';
                    document.getElementById('message').innerHTML = 'Passwords match';
                    return true;
                } else {
                    document.getElementById('message').style.color = 'red';
                    document.getElementById('message').innerHTML = 'Passwords do not match';
                    return false;
                }
            }
        </script>
<?php
    } else { // The user could not be validated
        echo '<p class="text-center">This page has been accessed in error.</p>';
    }
    mysqli_stmt_free_result($q);
    mysqli_close($dbcon);
} catch (Exception $e) {
    print "The system is currently busy. Please try again later";
    print "An Error occured. Message: " . $e->getMessage();
}
?>