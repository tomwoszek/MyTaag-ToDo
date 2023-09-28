<?php
// Sicherstellung der Startung der Sitzung
session_start();

// Externe PHP-Dateien in das aktuelle PHP-Skript einzufügen (Import aus Flutter)
include("connection.php");
include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//Daten aus UI abfragen 
		$user_email = $_POST['user_email'];
		$password = $_POST['password'];
         
        //Prüfung der Form 
		if(!empty($user_email) && !empty($password) && !is_numeric($user_email))
		{

			//NutzerSystem-Datenabfrage
			$query = "select * from users where user_email = '$user_email' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{
                    
					$user_data = mysqli_fetch_assoc($result);

					//Prüfung der Passwort 
					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: todos2.php");
						die;
					}
				}
			}
			
			echo "Falsches Password oder falsche MyTaag-ID!";
		}else
		{
			echo "Falsches Password oder falsche MyTaag-ID!";
		}
	}

?>



<!DOCTYPE html>
<html>
<head>
    <title>Einloggen</title>
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
            margin-top: 30px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="box">
        <h2>Einloggen</h2>
        <form method="post">
            <div class="input-group">
                <input type="text" name="user_email" placeholder="Ihre MyTaag-ID" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Passwort" required>
            </div>
            <input id="button" type="submit" value="Anmelden">
            <a href="signup.php">Noch kein Konto? Jetzt registrieren</a>
        </form>
    </div>
</body>
</html>


