<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_task"])) {
    $task_name = $_POST["task_name"];
    $task_description = $_POST["task_description"];

    $sql = "INSERT INTO tasks (task_name, task_description) VALUES ('$task_name', '$task_description')";
    $conn->query($sql);
}

// Delete Task
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_task"])) {
    $task_id = $_GET["delete_task"];

    $sql = "DELETE FROM tasks WHERE id=$task_id";
    $conn->query($sql);
}

// Fetch Tasks
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);

$tasks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Todo List</title>
</head>
<body>
    <div class="container">
        <h1>Todo List</h1>

        <!-- Form to add task -->
        <form action="index.php" method="post">
            <label for="task_name">Task Name:</label>
            <input type="text" name="task_name" required>
            <label for="task_description">Description:</label>
            <textarea name="task_description"></textarea>
            <button type="submit" name="add_task">Add Task</button>
        </form>

        <!-- Display tasks -->
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <?php echo $task["task_name"]; ?> - <?php echo $task["task_description"]; ?>
                    <a href="index.php?delete_task=<?php echo $task["id"]; ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>