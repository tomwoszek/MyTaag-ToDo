
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo's</title>
    <style type="text/css">
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            color: #0070c9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #0070c9;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0057a6;
        }

        .todo-list {
            list-style-type: none;
            padding: 0;
        }

        .todo-item {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            transition: box-shadow 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .todo-item:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .todo-item .delete-btn,
        .todo-item .edit-btn {
            background-color: #e44d4d;
            color: #fff;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .todo-item .edit-btn {
            background-color: #0070c9;
        }

        .todo-item .delete-btn:hover,
        .todo-item .edit-btn:hover {
            background-color: #c63838;
        }

        .edit-form {
            display: none;
            padding: 15px 0;
            border-top: 1px solid #ddd;
        }

        .edit-form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .edit-form input[type="text"],
        .edit-form textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .edit-form .btn-primary {
            margin-top: 10px;
            margin-bottom: 25px;
        }

        .logout-link {
            text-align: right;
            margin-top: 20px;
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
        <h1 class="header">ToDo's</h1>
        
        <form id="todoForm" class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" required>
            <label for="beschreibung">Beschreibung:</label>
            <textarea id="beschreibung" required></textarea>
            <button type="submit" class="btn-primary">ToDo hinzufügen</button>
        </form>
        <ul id="todoList" class="todo-list"></ul>
        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const todoForm = document.getElementById('todoForm');
            const todoList = document.getElementById('todoList');

            // Funktion zum Abrufen der ToDo-Liste
            function getTodos() {
                fetch('Todos-BackEnd.php') 
                    .then(response => response.json())
                    .then(data => {
                        
                        renderTodos(data);
                        
                    })
                    .catch(error => console.error('Fehler beim Abrufen der ToDo-Liste:', error));
            }

            // Funktion zum Rendern der ToDo-Liste
            function renderTodos(todos) {
                todoList.innerHTML = '';

                if (todos.length === 0) {
                    todoList.innerHTML = '<li>Keine To-Dos gefunden.</li>';
                } else {
                    todos.forEach(todo => {
                        const listItem = document.createElement('li');
                        listItem.innerHTML = `
                            <div>
                                Nutzer: ${todo.nutzer_id} <br>
                                Name: ${todo.name} <br>
                                Beschreibung: ${todo.beschreibung} <br>
                            </div>
                            <div>
                                <button class="edit-btn" data-todo-id="${todo.id}">Bearbeiten</button>
                                <button class="delete-btn" data-todo-id="${todo.id}">Löschen</button>
                            </div>
                            <div class="edit-form" id="edit-form-${todo.id}">
                                <label for="name">Neuer Name:</label>
                                <input type="text" id="edit-name" value="${todo.name}">
                                <label for="beschreibung">Neue Beschreibung:</label>
                                <textarea id="edit-beschreibung">${todo.beschreibung}</textarea>
                                <button class="btn-primary">Speichern</button>
                            </div>
                        `;
                        todoList.appendChild(listItem);

                    
                        const editButton = listItem.querySelector('.edit-btn');
                        const deleteButton = listItem.querySelector('.delete-btn');
                        const editForm = listItem.querySelector('.edit-form');

                        editButton.addEventListener('click', function() {
                            editTodo(todo.id);
                        });

                        deleteButton.addEventListener('click', function() {
                            deleteTodo(todo.id);
                        });

                        editForm.querySelector('.btn-primary').addEventListener('click', function() {
                            saveEdit(todo.id);
                        });
                    });
                }
            }

            // Funktion zum Hinzufügen eines neuen To-Dos
            function addTodo() {
                const name = document.getElementById('name').value;
                const beschreibung = document.getElementById('beschreibung').value;
               
                

                fetch('Todos-BackEnd.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `name=${encodeURIComponent(name)}&beschreibung=${encodeURIComponent(beschreibung)}`,
                })
                    .then(response => response.json())
                    .then(data => {
                        
                        console.log(data);
                        window.location.href = 'ToDos-FrontEnd.php';
              
                        getTodos();
                    })
                    .catch(error => console.error('Fehler beim Hinzufügen des To-Dos:', error));
            }

            // Funktion zum Löschen eines To-Dos
            function deleteTodo(todoId) {
                if (confirm('Sind Sie sicher, dass Sie dieses ToDo löschen möchten?')) {
                    fetch(`Todos-BackEnd.php?delete=${todoId}`, {
                        method: 'GET',
                    })
                        .then(response => response.json())
                        .then(data => {                           
                            console.log(data);

                            getTodos();
                        })
                        .catch(error => console.error('Fehler beim Löschen des To-Dos:', error));
                }
            }

            // Event-Listener für das Absenden des Formulars
            todoForm.addEventListener('submit', function(event) {
                event.preventDefault();
                addTodo();
            });

            // Initialisierung der ToDo-Liste beim Laden der Seite
            getTodos();
        });

        // Funktion zum Bearbeiten eines To-Dos
        function editTodo(todoId) {
            const todoItem = document.querySelector(`[data-todo-id="${todoId}"]`);

            if (!todoItem) {
                console.error('ToDo-Element nicht gefunden.');
                return;
            }

            const editForm = document.getElementById('edit-form-' + todoId);

            if (!editForm) {
                console.error('Bearbeitungsformular nicht gefunden.');
                return;
            }

        
            todoItem.style.display = 'none';

        
            editForm.style.display = 'block';
        }


        function saveEdit(todoId) {
        
            const newName = document.getElementById(`edit-name`).value;
            const newBeschreibung = document.getElementById(`edit-beschreibung`).value;

            fetch('Todos-BackEnd.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `edit_name=${encodeURIComponent(newName)}&edit_beschreibung=${encodeURIComponent(newBeschreibung)}&edit_todo_id=${todoId}`,
                        })
                            .then(response => response.json())
                            .then(data => {
                                
                            
                                console.log(data);

                            
                        
                            })
                            .catch(error => console.error('Fehler beim Hinzufügen des To-Dos:', error));
            
                           
                            const editForm = document.getElementById('edit-form-' + todoId);

                            if (!editForm) {
                                console.error('Bearbeitungsformular nicht gefunden.');
                                return;
                            }

                            

                        fetch('Todos-BackEnd.php') 
                                    .then(response => response.json())
                                    .then(data => {
                                        todoList.innerHTML = ''; 
                                        if (data.length === 0) {
                                            todoList.innerHTML = '<li>Keine To-Dos gefunden.</li>';
                                        } else {
                                            data.forEach(todo => {
                                                const listItem = document.createElement('li');
                                                listItem.innerHTML = `
                                                    <div>
                                                        Nutzer: ${todo.nutzer_id} <br>
                                                        Name: ${todo.name} <br>
                                                        Beschreibung: ${todo.beschreibung} <br>
                                                    </div>
                                                    <div>
                                                        <button class="edit-btn" data-todo-id="${todo.id}">Bearbeiten</button>
                                                        <button class="delete-btn" data-todo-id="${todo.id}">Löschen</button>
                                                    </div>
                                                    <div class="edit-form" id="edit-form-${todo.id}">
                                                        <label for="name">Neuer Name:</label>
                                                        <input type="text" id="edit-name" value="${todo.name}">
                                                        <label for="beschreibung">Neue Beschreibung:</label>
                                                        <textarea id="edit-beschreibung">${todo.beschreibung}</textarea>
                                                        <button class="btn-primary">Speichern</button>
                                                    </div>
                                                `;
                                                todoList.appendChild(listItem);

                                                const editButton = listItem.querySelector('.edit-btn');
                                                const deleteButton = listItem.querySelector('.delete-btn');
                                                const editForm = listItem.querySelector('.edit-form');

                                                editButton.addEventListener('click', function() {
                                                    editTodo(todo.id);
                                                });

                                                deleteButton.addEventListener('click', function() {
                                                    deleteTodo(todo.id);
                                                });

                                             
                                                editForm.querySelector('.btn-primary').addEventListener('click', function() {
                                                    saveEdit(todo.id);
                                                });
                                            });
                                        }
                                                                
                                    })
                                    .catch(error => console.error('Fehler beim Abrufen der ToDo-Liste:', error));
                            }

    </script>
</body>
</html>