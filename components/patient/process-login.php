<?php
// This section processes submissions from the login form
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //connect to database
    try {
        require("../mysqli_connect.php");
        // Check that an email address has been entered				
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if ((empty($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL))
        ) {
            $errors[] = 'You forgot to enter your email address';
            $errors[] = ' or the e-mail format is incorrect.';
        }
        // Check for a password and match against the confirmed password:
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $string_length = strlen($password);
        if (empty($password)) {
            $errors[] = 'Please enter a valid password';
        } else {
            if (!preg_match(
                '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,12}$/',
                $password
            )) {  //                        #8
                $errors[] = 'Invalid password, 8 to 12 chars, one upper, one lower, one number, one special.';
            }
        }
        if (empty($errors)) { // If everything's OK.         #1
            // Retrieve the user_id, psword, first_name and user_level for that
            // email/password combination
            $query = "SELECT id, hashedpassword, firstname, user_level FROM patientdetails ";
            $query .= "WHERE email=?";
            $q = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($q, $query);
            // bind $id to SQL Statement
            mysqli_stmt_bind_param($q, "s", $email);
            // execute query
            mysqli_stmt_execute($q);
            $result = mysqli_stmt_get_result($q);
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            if (mysqli_num_rows($result) == 1) {
                //if one database row (record) matches the input:-
                // Start the session, fetch the record and insert the 
                // values in an array 
                if (password_verify($password, $row[1])) {          //#2
                    session_start();
                    // Ensure that the user level is an integer. 
                    $_SESSION['user_level'] = (int) $row[3];
                    if ($_SESSION['user_level'] === 4) {
                        $_SESSION['email'] = $email;
                        $url = "patient-viewrecords.php";
                    } else {
                        $url = "patient.php";
                    }
                    header('Location: ' . $url);
                    // Make the browser load patient view records
                } else { // No password match was made.
                    $errors[] = 'E-mail/Password entered does not match our records. ';
                }
            } else { // No e-mail match was made.
                $errors[] = 'E-mail/Password entered does not match our records. ';
            }
        }
        if (!empty($errors)) {
            $errorstring = "";
            foreach ($errors as $msg) { // Print each error.
                $errorstring .= " $msg<br>\n";
            }
            echo '<div class="alert alert-danger">' . $errorstring . '</div>';
        } // End of if (!empty($errors)) IF.
        mysqli_stmt_free_result($q);
        mysqli_stmt_close($q);
    } catch (Exception $e) // We finally handle any problems here   
    {
        // print "An Exception occurred. Message: " . $e->getMessage();
        print "The system is busy please try later";
    } catch (Error $e) {
        //print "An Error occurred. Message: " . $e->getMessage();
        print "The system is busy please try again later.";
    }
} // no else to allow user to enter values
