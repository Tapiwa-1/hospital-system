<?php
session_start(); //access the current session.                  
// if no session variable exists then redirect the user
$url = "../../index.php";
if (!isset($_SESSION['user_level'])) {
    header("Location: patient.php");
    exit();
    //cancel the session and redirect the user:
} else { //cancel the session
    $_SESSION = array(); // Destroy the variables
    $params = session_get_cookie_params();
    // Destroy the cookie
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_destroy();
    } // Destroy the session itself
    header("location:" . $url); //go to home
}
