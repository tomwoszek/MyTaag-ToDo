<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

?>


<!DOCTYPE html>
<html>
<head>
    <title>My Website</title> 
<head>
<body>
    <a href="logout.php">logout</a>
    <h1>This is the index page</hi>

    <br>
    Hello, Username.
<body>
<html>

