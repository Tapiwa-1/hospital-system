<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/app.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../js/bootstrap.js">
    <title>Patient</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="container mt-md-4">

                <div class="col-md-4 shadow-sm pt-1 m-auto p-md-2">
                    <form action="patient-registration.php" method="POST" onsubmit="return checked();">
                        <div class="form-group text-center">
                            <h3>REGISTRATION</h3>
                        </div>
                        <div class="form-group">
                            <!--Validate input--->
                            <?php
                            if (isset($_POST['submit_form']) == 'POST') {
                                include('process-patientregistration.php');
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" name="firstname" required placeholder="Enter first Name" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="lastname" required placeholder="Enter last Name" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>">
                        </div>
                        <div class="form-group">
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
                            <input type="email" class="form-control" name="email" required placeholder="example@gmail.com" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">

                        </div>
                        <div class="form-group">
                            <label for="address1">Address 1</label>
                            <input type="text" class="form-control" name="address1" required placeholder="Enter address 1" value="<?php if (isset($_POST['address1'])) echo $_POST['address1']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="address1">Address 2</label>
                            <input type="text" class="form-control" name="address2" placeholder="Enter address 2" value="<?php if (isset($_POST['address2'])) echo $_POST['address2']; ?>">

                        </div>
                        <div class="form-group">
                            <label for="phonenumber">Phone Number</label>
                            <input type="number" class="form-control" name="phonenumber" placeholder="Enter phone number" required value="<?php if (isset($_POST['phonenumber'])) echo $_POST['phonenumber']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password1" placeholder="Enter password" name="password1" minlength="8" maxlength="12" required value="<?php if (isset($_POST['password1'])) echo $_POST['password1']; ?>">
                            <span id='message'>Between 8 and 12 characters.</span>
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword"> Confirm Password</label>
                            <input type="password" class="form-control" id="password2" placeholder="Confirm password" name="password2" required value="<?php if (isset($_POST['password_2'])) echo $_POST['password_2'];  ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Register" name="submit_form" class="btn btn-color my-2 w-100">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
</body>

</html>