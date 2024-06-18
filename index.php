<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranario's Scenic To-do App</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            margin: auto;
            margin-top: 50px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
        }
        .form-control {
            border-radius: 5px;
            border-color: #ddd;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        .list-group-item {
            background-color: #fff;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .list-group-item:hover {
            background-color: #f0f4f8;
        }
        .list-group-item form {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .list-group-item input[type="text"], 
        .list-group-item input[type="datetime-local"] {
            flex-grow: 1;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 8px;
        }
        .btn-sm {
            margin-left: 5px;
            transition: background-color 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .text-center.mt-3 .btn-secondary {
            background-color: #6c757d;
            border: none;
            transition: background-color 0.3s;
        }
        .text-center.mt-3 .btn-secondary:hover {
            background-color: #5a6268;
        }
        .text-right {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Todo List</h1>
        <div class="text-right">
            <p><?php echo date('l, F j, Y \| g:i A'); ?></p>
        </div>
        <form id="todo-form" action="index.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="todo" placeholder="Add a new todo" required>
            </div>
            <div class="form-group">
                <input type="datetime-local" class="form-control" name="datetime" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add">Add Task</button>
        </form>
        <ul class="list-group mt-3" id="todo-list">
            <?php
            session_start();
            if (!isset($_SESSION['todos'])) {
                $_SESSION['todos'] = [];
            }

            // Create and Read
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
                $todo = htmlspecialchars($_POST['todo']);
                $datetime = $_POST['datetime'];
                $task = array('task' => $todo, 'datetime' => $datetime);
                array_push($_SESSION['todos'], $task);
            }

            // Delete
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
                $index = $_POST['index'];
                array_splice($_SESSION['todos'], $index, 1);
            }

            // Update
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
                $index = $_POST['index'];
                $todo = htmlspecialchars($_POST['todo']);
                $datetime = $_POST['datetime'];
                $_SESSION['todos'][$index] = array('task' => $todo, 'datetime' => $datetime);
            }

            foreach ($_SESSION['todos'] as $index => $task) {
                echo "<li class='list-group-item'>
                        <form action='index.php' method='post' class='d-flex'>
                            <div>
                                <input type='text' name='todo' value='{$task['task']}' class='form-control' required>
                                <input type='hidden' name='index' value='$index'>
                            </div>
                            <div>
                                <input type='datetime-local' name='datetime' value='{$task['datetime']}' class='form-control' required>
                            </div>
                            <div class='ml-2'>
                                <button type='submit' name='update' class='btn btn-success btn-sm'>Update</button>
                                <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                            </div>
                        </form>
                      </li>";
            }
            ?>
        </ul>
        
        <!-- Button to go to landing page -->
        <div class="text-center mt-3">
            <a href="index.html" class="btn btn-secondary">Go to Landing Page</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
