<?php
require("session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../app/app.css">


    <title>Your dashboard</title>
</head>

<body>
    <div class="container dashboard">
        <div class="row">
            <h2>Welcome <?php require("welcome-header.php"); ?></h2>
        </div>
        <div class="row buttonSection manybuttons">
            <ul>
                <li><a href="../admin/administrator-viewrecordsadministrator.php ">Administration</a></li>
                <li><a class="active" href="../finance/administrator-viewrecordsfinance.php ">Finance</a></li>
                <li><a href="../practitioner/administrator-viewrecordspractioner.php ">Practitioner</a></li>
                <li><a href="../patient/administrator-viewrecordspatient.php ">Patient</a></li>
                <li><a href="../administrator-logout.php ">Logout</a></li>
            </ul>
        </div>
        <div class="row buttonSection acsent">
            <ul>
                <li><a href="administrator-contactfinance.php ">contact finance</a></li>
                <li><a href="administrator-addfinance.php ">Add finance</a></li>
                <li><a href="administrator-viewrecordsfinance.php ">Finance Records</a></li>
                <li><a href="administrator-adddepartmentfinance.php ">add departments</a></li>
                <li><a href="administrator-departmentfinance.php ">finance departments</a></li>
                <li><a href="administrator-Searchfinance.php ">search finance</a></li>
            </ul>
        </div>
    </div>
</body>

</html>