<?php
session_start();
if (!isset($_SESSION['user_level']) && $_SESSION['user_level'] != 4) {
    header("Location: practitioner.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Apointment</title>
    <link rel="stylesheet" href="../app/app.css">
    <?php require("notification.php") ?>
</head>

<body>
    <div class="container dashboard">
        <div class="row">
            <h2>Welcome <?php require("welcome-header.php"); ?></h2>

        </div>
        <div class="row buttonSection">
            <ul>
                <li><a href="practitioner-contactadmin.php">contact Admin</a></li>
                <li><a href="practitioner-viewrecords.php">View Records</a></li>
                <li><a href="practitioner-searchrecords.php">Search Records</a></li>
                <div class="notification-container">
                    <div class="notification"></div>
                    <li><a href="practitioner-viewappointments.php">Appointments</a></li>
                </div>
                <li><a href="practitioner-logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="row ">

            <div class="col-100">
                <form action="">
                    <div class="row header">
                        <h3>FILL IN THE FOLLOWING</h3>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="firstname">First Name</label>
                        </div>
                        <div class="col-75">
                            <input type="text" name="firstname" required placeholder="patient first name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="firstname">Last Name</label>
                        </div>
                        <div class="col-75">
                            <input type="text" name="lastname" required placeholder="patient last name">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="results">Reveiw date</label>
                        </div>
                        <div class="col-75">
                            <input type="date" name="reviewdate" required placeholder="net review date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="moreinfo">Prescription</label>
                        </div>
                        <div class="col-75">
                            <textarea placeholder="Enter Prescription here"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="moreinfo">Additional information</label>
                        </div>
                        <div class="col-75">
                            <textarea placeholder="Enter More details here"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" value="submit">
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>

</html>