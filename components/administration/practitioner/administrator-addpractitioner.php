<?php include("header.php") ?>
<div class="container">
    <div class="row">
        <div class="container mb-md-5">
            <div class="col-md-4 shadow-sm pt-1 m-auto p-md-2">
                <form action="administrator-addpractitioner.php" method="POST" onsubmit="return checked();">
                    <div class="form-group text-center">
                        <h3>REGISTRATION</h3>
                    </div>
                    <div class="form-group">
                        <!--Validate input--->
                        <?php
                        if (isset($_POST['submit_form']) == 'POST') {
                            require('proccess-adminaddpract.php');
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
                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male" checked>
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
                        <label for="phonenumber">Experience</label>
                        <input class="form-control" type="number" name="experience" placeholder="Enter experince in years" required value="<?php if (isset($_POST['experience'])) echo $_POST['experience']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Select department</label>
                        <div class="form-control">
                            <?php
                            //require("../../mysqli_connect.php"); //connect to the db
                            //make querry
                            $query = "SELECT id ,name FROM practitionerdepartment";
                            $result = mysqli_query($dbcon, $query); // Run the query.
                            if ($result) { // If it ran OK, display the records.
                                // Table header.
                                echo '<select name="department">';
                                echo '<option value="">Department</option>';
                                // Fetch and print all the records:	
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    echo '<option value="' . $row['id'] . '" name="department">' . $row['name'] . '</option>';
                                }
                                echo '</select>';
                            }
                            mysqli_close($dbcon); //close connection
                            ?>
                        </div>
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
<?php include("footer.php") ?>