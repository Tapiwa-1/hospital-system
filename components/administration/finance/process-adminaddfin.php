<?php

//This script is a query that INSERTs a record in the patient records
//Check that the form has been submitted
$errors = array(); //Initialize an error array

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

//experience
$experience = filter_var($_POST['experience'], FILTER_SANITIZE_NUMBER_INT); //Removing potential SQL Injection
if (empty($experience)) {
    $errors[] = 'You did not enter experience';
}

//department
$department = filter_var($_POST['department'], FILTER_SANITIZE_STRING); //Removing unnessecary char
if (empty($department)) {
    $errors[] = 'You did not enter department';
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
if (empty($errors)) { //everything is ok
    try {
        //require('../../mysqli_connect.php'); //Connect to the db
        // If no problems encountered, register user in the database
        //Determine whether the email address has already been registered                         
        $query = "SELECT id FROM financedetails WHERE email = ? ";
        $q = mysqli_stmt_init($dbcon);
        mysqli_stmt_prepare($q, $query);
        mysqli_stmt_bind_param($q, 's', $emailtrim);
        mysqli_stmt_execute($q);
        $result = mysqli_stmt_get_result($q);

        if (mysqli_num_rows($result) == 0) { //The email address has not been registered
            //already therefore register the user in the users table
            //-------------Valid Entries - Save to database -----
            //Start of the SUCCESSFUL SECTION. i.e all the required fields were filled out

            //Register the patients database
            //Hash the password current 60 charachit_clinic.practitionerdetailter but it can increase
            $hashedpassword = password_hash($password1trim, PASSWORD_DEFAULT);

            //Make a query
            $query = "INSERT INTO financedetails (id, firstname, lastname, gender, email, address1, address2,
             phone, experience, department, user_level, hashedpassword)";
            $query .= "VALUES (' ',?,?,?,?,?,?,?,?,?,2,?)";
            $q = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($q, $query);
            // use prepared statement to ensure that only text is inserted
            // bind fields to SQL Statement
            mysqli_stmt_bind_param($q, 'ssssssiiis', $firstnametrim, $lastnametrim, $gender, $emailtrim, $address1trim, $address2trim, $phonetrim, $experience, $department, $hashedpassword);
            //Execute the query
            mysqli_stmt_execute($q);
            if (mysqli_stmt_affected_rows($q) == 1) { // One record inserted 
                echo '<div class="alert alert-success">Registration successful</div>';
            } else { // If it did not run OK.
                // Public message:
                $errorstring .= "System Error<br />You could not be registered due ";
                $errorstring .= "to a system error. We apologize for any inconvenience.";
                exit();
            }
        } else {
            $errorstring = "The email has already been taken";
            echo '<div class="alert alert-danger">' . $errorstring . '</div>';
        }
    } catch (Exception $e) {
        print $e->getMessage();
    } catch (Error $e) {
        print $e->getMessage();
    }
} else { //Report the errors
    $errorstring = "";
    foreach ($errors as $msg) { //print the errors
        $errorstring .= "- $msg<br>\n";
    }
    echo '<div class="alert alert-danger">' . $errorstring . '</div>';
}//End of if (empty($errors))
