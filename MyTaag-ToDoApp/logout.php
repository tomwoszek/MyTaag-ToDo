<?php
// Sicherstellung der Startung der Sitzung
session_start();

// NutzerSystem-LogOut
if(isset($_SESSION['user_id']))
{
    unset($_SESSION['user_id']);
}

header("Location: login.php");
die;


