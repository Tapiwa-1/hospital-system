<?php
require("../mysqli_connect.php"); // Connect to the database.
$query = 'SELECT responded from patientillness WHERE practitioner ="' . $_SESSION['id'] . '" AND responded IS NULL';
$result = mysqli_query($dbcon, $query); // Run the query;
if (mysqli_num_rows($result) != 0) {
    echo
    "
        <style>
        .notification-container {
            display: flex;
            align-items: center;
        }

        .notification {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: red;
        }
    </style>
        ";
}
