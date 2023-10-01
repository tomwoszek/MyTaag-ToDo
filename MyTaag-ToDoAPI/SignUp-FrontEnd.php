<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <form id="signupForm" method="post">
            <div class="input-group">
                <input type="text" id="user_name2" name="user_name2" placeholder="BenutzerName" required>
            </div>
            <div class="input-group">
                <input type="text" id="user_name" name="user_name" placeholder="Gewünschte MyTaag-ID" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Passwort" required>
            </div>
            <input id="button" type="button" value="Registrieren" onclick=signUp()>
            <b><a href="login.php">Bereits ein Konto? Jetzt anmelden</a></b>
            <a href="LogIn-FrontEnd.php">Jetzt anmelden</a>
        </form>
    </div>

    <script>
        function signUp() {
            const user_name2 = document.getElementById('user_name2').value;
            const user_name = document.getElementById('user_name').value;
            const password = document.getElementById('password').value;

            fetch('SignUp-BackEnd.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `user_name=${encodeURIComponent(user_name)}&user_name2=${encodeURIComponent(user_name2)}&password=${encodeURIComponent(password)}`,
            })
            
            .then(data => {
                
                    window.location.href = 'LogIn-FrontEnd.php';
                
            })
            .catch(error => console.error('Fehler beim Hinzufügen des Nutzers:', error));
        }
    </script>
  </script>
</body>
</html>   
