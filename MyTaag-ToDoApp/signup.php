<?php
// Sicherstellung der Startung der Sitzung
session_start();

// Externe PHP-Dateien in das aktuelle PHP-Skript einzufügen (Import aus Flutter)
include("connection.php");
include("functions.php");

//UserSystem-SignUp
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_name2'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // In die Datenbank speichern
        $user_id = random_num(20);
        $query = "INSERT INTO users (user_id, user_name, user_email, password) VALUES ('$user_id', '$user_email', '$user_name', '$password')";

        mysqli_query($con, $query);

        header("Location: login.php");
        die;
    } else {
        echo "Bitte geben Sie gültige Informationen ein!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrieren</title>
    <style type="text/css">
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            width: 300px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        #box:hover {
            transform: scale(1.05);
        }

        #box h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 90%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
        }

        #button {
            padding: 10px;
            width: 100%;
            background-color: #0070c9;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        #button:hover {
            background-color: #0057a6;
        }

        a {
            text-decoration: none;
            color: #0070c9;
            font-size: 16px;
            margin-bottom: 10px;
        }

        b {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="box">
        <h2>Registrieren</h2>
        <form method="post">
            <div class="input-group">
                <input type="text" name="user_name2" placeholder="BenutzerName" required>
            </div>
            <div class="input-group">
                <input type="text" name="user_name" placeholder="Gewünschte MyTaag-ID" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Passwort" required>
            </div>
            <input id="button" type="submit" value="Registrieren">
            <b href="login.php">Bereits ein Konto? Jetzt anmelden</b>
            <a href="login.php"> Jetzt anmelden</a>
        </form>
    </div>
</body>
</html>