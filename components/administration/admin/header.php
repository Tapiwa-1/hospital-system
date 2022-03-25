<?php
require("session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo</title>
    <link rel="stylesheet" href="../../../css/app.css">
    <link rel="stylesheet" href="../../../css/bootstrap.css">
    <script src="../../../js/bootstrap.js"></script>
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
                        <a class="nav-link active " aria-current="page" href="../admin/administrator-viewrecordsadministrator.php">Administration</a>
                    </li>
                    <li class="nav-item border-end d-flex align-content-center align-items-center">
                        <a class="nav-link active " aria-current="page" href="../finance/administrator-viewrecordsfinance.php">Finance</a>
                    </li>
                    <li class="nav-item border-end ">

                        <a class="nav-link active " aria-current="page" href="../practitioner/administrator-viewrecordspractioner.php">Practitioner</a>
                    </li>
                    <li class="nav-item border-end">
                        <a class="nav-link active " aria-current="page" href="../patient/administrator-viewrecordspatient.php">Patient</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active " aria-current="page" href="../administrator-logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="container-fluid">
            <nav class="nav flex-column flex-md-row justify-content-sm-between">
                <a class="nav-link" href="administrator-Addadministrator.php ">Add Administrator</a>
                <a class="nav-link" href="administrator-viewrecordsadministrator.php ">Admin Records</a>
                <a class="nav-link" href="administrator-searchadmin.php ">Search Admin</a></li>
            </nav>