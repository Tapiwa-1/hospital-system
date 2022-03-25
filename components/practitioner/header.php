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
    <title>Demo</title>
    <link rel="stylesheet" href="../../css/app.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <script src="../../js/bootstrap.js"></script>
    <?php require("notification.php") ?>
</head>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <div class="navdash nav-logo p-3">
                <?php require("welcome-header.php"); ?>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 ms-md-auto">
                    <li class="nav-item border-end">
                        <a class="nav-link active " aria-current="page" href="practitioner-contactadmin.php">Contact Admin</a>
                    </li>
                    <li class="nav-item border-end d-flex align-content-center align-items-center">
                        <div class="notification"></div>
                        <a class="nav-link active " aria-current="page" href="practitioner-viewappointments.php">View Appointments</a>
                    </li>
                    <li class="nav-item border-end ">

                        <a class="nav-link active " aria-current="page" href="practitioner-viewrecords.php">View Records</a>
                    </li>
                    <li class="nav-item border-end">
                        <a class="nav-link active " aria-current="page" href="practitioner-searchrecords.php">Search Records</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active " aria-current="page" href="practitioner-logout.php">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>