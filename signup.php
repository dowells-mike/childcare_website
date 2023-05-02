<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up Page</title>
</head>
<body>
<?php
    session_start(); 
    include('header.php'); 
    ?>
    <h1>if a parent please click the button below</h1>
    <button><a href="parent_signup.php">Parent sign up</a></button>

    <h1>If an Admin user please click the button below</h1>
    <button><a href="admin_validation.php">Admin sign up</a></button>
</body>
</html>