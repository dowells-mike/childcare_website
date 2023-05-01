<?php
session_start();
if (session_destroy()) {
    // redirect to the login page
    header("Location: index.php");
    exit;
}
?>