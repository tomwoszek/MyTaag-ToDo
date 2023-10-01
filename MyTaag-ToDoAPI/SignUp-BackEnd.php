<?php
// Sicherstellung der Startung der Sitzung
session_start();

include("connection.php");
include("functions.php");

//UserSystem-SignUp
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_name2'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

        $user_id = random_num(20);
        $query = "INSERT INTO users (user_id, user_name, user_email, password) VALUES ('$user_id', '$user_email', '$user_name', '$password')";

        mysqli_query($con, $query);


        die;
    } else {
        echo "Bitte geben Sie gültige Informationen ein!";
    }
}
?>