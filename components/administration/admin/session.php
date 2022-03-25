<?php
session_start();
if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] != 1) {
    $url = "../administrator.php";
    header("Location:" . $url);
    exit();
}
