<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h2>Einloggen</h2>
        <form id="signupForm" method="post">   
            <div class="input-group">
                <input type="text" id="user_name" name="user_name" placeholder="MyTaag-ID" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Passwort" required>
            </div>
            <input id="button" type="button" value="Einloggen" onclick=signUp()>
            
            <a href="SignUp-FrontEnd.php">Noch kein Konto? Jetzt anmelden</a>
        </form>
    </div>

    <script>
        function signUp() {
            const user_name = document.getElementById('user_name').value;
            const password = document.getElementById('password').value;

            fetch('LogIn-BackEnd.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `user_email=${encodeURIComponent(user_name)}&password=${encodeURIComponent(password)}`,
            })
            
            .then(data => {
                
                    window.location.href = 'ToDos-FrontEnd.php';
                    $_SESSION['user_id'] = $user_data['user_id'];
                
            })
            .catch(error => console.error('Fehler beim Hinzufügen des Nutzers:', error));
        }
    </script>
  </script>
</body>
</html>   