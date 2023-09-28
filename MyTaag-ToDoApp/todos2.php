<?php
// Sicherstellung der Startung der Sitzung
session_start(); 

// Externe PHP-Dateien in das aktuelle PHP-Skript einzufügen (Import aus Flutter)
include("connection.php");
include("functions.php");

// Prüfen ob der Nutzer eingeloggt ist und das Empfangen der Nutzerdaten, wenn der Nutzer nicht eingeloggt ist wird er weitergeleitet zur login.php Seite.
$user_data = check_login($con);

// ToDo-Edit
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_todo_id'])) {
    // Etwas wurde übermittelt
    $todo_id = $_POST['edit_todo_id'];
    $new_name = $_POST['edit_name'];
    $new_beschreibung = $_POST['edit_beschreibung'];

    // In die Datenbank speichern
    $sql = "UPDATE todos SET name = '$new_name', beschreibung = '$new_beschreibung' WHERE id = $todo_id AND nutzer_id = " . $user_data['user_id'];

    mysqli_query($con, $sql);
    header("Location: todos2.php");
    die;
}

// ToDo-Upload
if ($_SERVER['REQUEST_METHOD'] == "POST" && !isset( $_POST['edit_todo_id'])) 
    {
    // Etwas wurde übermittelt
    $nutzer_id = $user_data['user_id'];
    $name = $_POST['name'];
    $beschreibung = $_POST['beschreibung'];

    // In die Datenbank speichern
    $sql = "INSERT INTO todos (nutzer_id, name, beschreibung) VALUES ('$nutzer_id', '$name', '$beschreibung')";

    mysqli_query($con, $sql);
    header("Location: todos2.php");
    die;
}

// ToDo-Delete
if (isset($_GET['delete'])) {
    $todo_id = $_GET['delete'];
    $delete_query = "DELETE FROM todos WHERE id = $todo_id AND nutzer_id = " . $user_data['user_id'];
    mysqli_query($con, $delete_query);
    header("Location: todos2.php");
    die;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ToDo's von <?php echo $user_data['user_name']; ?></title>
    <style>
        /* Allgemeine Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container für das Formular und die ToDo-Liste */
        .container {
            max-width: 800px;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
        }

        /* Überschrift und Abstand */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Formularfelder */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 95%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Button-Styles */
        .btn-primary {
            background-color: #0070c9;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0057a6;
        }

        /* ToDo-Liste */
        .todo-list {
            list-style-type: none;
            padding: 0;
        }

        .todo-item {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .todo-item .delete-btn {
            background-color: #f44336;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 3px;
        }

        .todo-item .edit-btn {
            background-color: #0070c9;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 3px;
            margin-right: 10px;
        }

        /* Bearbeitungsformular */
        .edit-form {
            display: none;
            margin-top: 10px;
        }

        .edit-form label {
            font-weight: bold;
            display: block;
        }

        .edit-form input[type="text"],
        .edit-form textarea {
            width: 95%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-form .btn-primary {
            margin-top: 10px;
            margin-bottom: 25px;
        }

        /* Logout-Link */
        .logout-link {
            text-align: right;
        }

        .logout-link a {
            color: #0070c9;
            text-decoration: none;
        }

        .logout-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="header">ToDo's von <?php echo $user_data['user_name']; ?></h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="beschreibung">Beschreibung:</label>
                <textarea name="beschreibung" required></textarea>
            </div>
            <button class="btn-primary" type="submit">ToDo hinzufügen</button>
        </form>
        <ul class="todo-list">
            <?php
            $user_id = $user_data["user_id"];
            $sql = "SELECT * FROM todos WHERE nutzer_id = $user_id";
            $result = mysqli_query($con, $sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li class="todo-item">';
                    echo '<div>';
                    echo 'Nutzer: ' . $row["nutzer_id"] . '<br>';
                    echo 'Name: ' . $row["name"] . '<br>';
                    echo 'Beschreibung: ' . $row["beschreibung"] . '<br>';
                    echo '</div>';
                    echo '<div>';
                    echo '<button class="edit-btn" onclick="editTodo(' . $row["id"] . ')">Bearbeiten</button>';
                    echo '<button class="delete-btn" onclick="deleteTodo(' . $row["id"] . ')">Löschen</button>';
                    echo '</div>';
                    echo '</li>';
                    echo '<div class="edit-form" id="edit-form-' . $row["id"] . '">';
                    echo '<form method="POST">';
                    echo '<input type="hidden" name="edit_todo_id" value="' . $row["id"] . '">';
                    echo '<div class="form-group">';
                    echo '<label for="edit-name-' . $row["id"] . '">Neuer Name:</label>';
                    echo '<input type="text" name="edit_name" id="edit-name-' . $row["id"] . '" value="' . $row["name"] . '" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="edit-beschreibung-' . $row["id"] . '">Neue Beschreibung:</label>';
                    echo '<textarea name="edit-beschreibung" id="edit-beschreibung-' . $row["id"] . '" required>' . $row["beschreibung"] . '</textarea>';
                    echo '</div>';
                    echo '<button class="btn-primary" type="button" onclick="saveEdit(' . $row["id"] . ')">Speichern</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<li>Keine To-Dos gefunden.</li>';
            }
            ?>
        </ul>
        <div class="logout-link">
            <a href="logout.php">Ausloggen</a>
        </div>
    </div>
    <script>

        // Abfragen ob der Nutzer das ToDo auch wirklich löschen möchte, wenn ja dann löschen.
        function deleteTodo(todoId) {
            if (confirm('Sind Sie sicher, dass Sie dieses ToDo löschen möchten?')) {
                window.location.href = 'todos2.php?delete=' + todoId;
            }
        }

        // Öffnen der Bearbeitungs UI
        function editTodo(todoId) {
            var editForm = document.getElementById('edit-form-' + todoId);
            editForm.style.display = 'block';
        }

        // Speichern des Bearbeiten ToDo's
        function saveEdit(todoId) {
            var newName = document.getElementById('edit-name-' + todoId).value;
            var newBeschreibung = document.getElementById('edit-beschreibung-' + todoId).value;

            // Senden der Daten vie eines XMLHttpRequest-Objektes(AJAX) damit die gesammt Seite nicht neugeladen werden muss
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                    // Nach erfolgreichem Bearbeiten aktualisieren Sie die Anzeige
                    var todoDiv = document.querySelector('#edit-form-' + todoId).previousElementSibling;
                    todoDiv.querySelector('div:first-child').innerHTML = 'Name: ' + newName + '<br>Beschreibung: ' + newBeschreibung + '<br>';
                    
                    // Verstecken der Bearbeitungs Ud
                    var editForm = document.getElementById('edit-form-' + todoId);
                    editForm.style.display = 'none';
                }};
            xhttp.open("POST", "todos2.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("edit_todo_id=" + todoId + "&edit_name=" + newName + "&edit_beschreibung=" + newBeschreibung);
        }
    </script>
</body>
</html>
