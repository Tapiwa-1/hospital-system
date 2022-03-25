<?php include("header.php"); ?>
<div class="container">
    <div class="row">
        <div class="container mt-md-4">
            <div class="col-md-4 shadow-sm pt-1 mb-5 m-auto p-md-2">
                <form action="patient-bookpractioner.php" method="POST" proccess-bookpractitioner.php>
                    <div class="form-group">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            require('proccess-bookpractitioner.php');
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <h4>FILL IN THE FOLLOWING</h4>
                    </div>
                    <div class="form-group">
                        <label for="firstname">illness</label>
                        <input class="form-control" type="text" name="illness" required placeholder="Enter illness" value="<?php if (isset($_POST['illness'])) echo $_POST['illness']; ?>">

                    </div>
                    <div class="form-group">
                        <label for="illnessstart">When did it started</label>
                        <input type="date" class="form-control" name="startdate" required placeholder="When did you started filling that way" value="<?php if (isset($_POST['startdate'])) echo $_POST['startdate']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="numberoccur">Number of occurance</label>
                        <input type="number" class="form-control" name="occur" required placeholder="Enter number of times it occured" value="<?php if (isset($_POST['occur'])) echo $_POST['occur']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="allegies">Any allegies</label>
                        <input type="text" class="form-control" name="allegies" required placeholder="Enter allegies" value="<?php if (isset($_POST['allegies'])) echo $_POST['allegies']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="AppointmentDate">Appointment Date</label>
                        <input type="date" class="form-control" name="appointmentdate" required placeholder="enter date" value="<?php if (isset($_POST['appointmentdate'])) echo $_POST['appointmentdate']; ?>">

                    </div>
                    <div class="form-group">
                        <p class=" text-warning">Constaltation fee for this practitioner is $39.99 only
                        </p>

                    </div>
                    <div class="form-group">
                        <label for="moreinfo">Any More information</label>
                        <textarea class="form-control" placeholder="Enter More details here" name="moreinfo" value="<?php if (isset($_POST['moreinfo'])) echo $_POST['moreinfo']; ?>"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="submit" name="submit" class="btn btn-color my-2 w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php"); ?>