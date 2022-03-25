<?php
require("session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../app/app.css">


    <title>Your dashboard</title>
</head>

<body>
    <div class="container dashboard">
        <div class="row">
            <h2>Welcome <?php require("welcome-header.php"); ?></h2>
        </div>
        <div class="row buttonSection manybuttons">
            <ul>

                <li><a href="../admin/administrator-viewrecordsadministrator.php">Administration</a></li>
                <li><a href="../finance/administrator-viewrecordsfinance.php">Finance</a></li>
                <li><a href="../practitioner/administrator-viewrecordspractioner.php">Practitioner</a></li>
                <li><a class="active" href="../patient/administrator-viewrecordspatient.php">Patient</a></li>
                <li><a href="../administrator-logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="row buttonSection acsent">
            <ul>
                <li><a href="administrator-contactpatient.php">contact Patient</a></li>
                <li><a href="administrator-viewrecordspatient.php">Patient Records</a></li>
                <li><a href="administrator-patientillness.php">illness Records</a></li>
                <li><a href="administrator-Searchpatient.php">search Patient</a></li>
            </ul>
        </div>
        <table class="table-striped">
            <tr>
                <th>Patient First Name</th>
                <th>Patent Last Name</th>
                <th>Patient First Name</th>
                <th>Patent Last Name</th>
                <th>Amount paid</th>
                <th>illness</th>
                <th>Date</th>
                <th>More</th>

            </tr>
            <tr>
                <td></td>
                <!--First Name-->
                <td></td>
                <!--Last Name-->
                <td></td>
                <!--Gender-->
                <td></td>
                <!--Email-->
                <td></td>
                <!--Address 1-->
                <td></td>
                <!--Address 1-->
                <td></td>
                <!--Address 1-->

            </tr>
        </table>
    </div>
</body>

</html>