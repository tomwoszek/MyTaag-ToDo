<?php
header('Content-Type: application/json');

// Sicherstellung der Startung der Sitzung
session_start();
session_save_path('/path/to/session/data');

include("connection.php");
include("functions.php");


$user_data = check_login($con);

// ToDo-Edit
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_todo_id'])) {
    $todo_id = $_POST['edit_todo_id'];
    $new_name = $_POST['edit_name'];
    $new_beschreibung = $_POST['edit_beschreibung'];

    $sql = "UPDATE todos SET name = '$new_name', beschreibung = '$new_beschreibung' WHERE id = $todo_id AND nutzer_id = " . $user_data['user_id'];

    mysqli_query($con, $sql);
    echo json_encode(["status" => "success"]);
    die;
}

// ToDo-Upload
if ($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['edit_todo_id'])) {
    $nutzer_id = $user_data['user_id'];
    $name = $_POST['name'];
    $beschreibung = $_POST['beschreibung'];

    // In die Datenbank speichern
    $sql = "INSERT INTO todos (nutzer_id, name, beschreibung) VALUES ('$nutzer_id', '$name', '$beschreibung')";

    mysqli_query($con, $sql);
    echo json_encode(["status" => "success"]);
    die;
}

// ToDo-Delete
if (isset($_GET['delete'])) {
    $todo_id = $_GET['delete'];
    $delete_query = "DELETE FROM todos WHERE id = $todo_id AND nutzer_id = " . $user_data['user_id'];
    mysqli_query($con, $delete_query);
    echo json_encode(["status" => "success"]);
    die;
}

// Abfrage aller Todos für den Nutzer
$user_id = $user_data["user_id"];
$sql = "SELECT * FROM todos WHERE nutzer_id = $user_id";
$result = mysqli_query($con, $sql);
$response = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = [
            "id" => $row["id"],
            "nutzer_id" => $row["nutzer_id"],
            "name" => $row["name"],
            "beschreibung" => $row["beschreibung"],
        ];
    }
} else {
    $response = ["message" => "Keine To-Dos gefunden."];
}

echo json_encode($response);
