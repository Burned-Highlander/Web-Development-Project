<?php
// Establish a database connection
$host = 'localhost';
$db = 'task_manager';
$user = 'root';
$password = '';

$mysqli = new mysqli($host, $user, $password, $db);

// Retrieve the task with the specified ID
$id = $_POST['id'];
$query = "SELECT * FROM tasks WHERE id = $id";
$result = $mysqli->query($query);

$task = null;
if ($result) {
    $task = $result->fetch_assoc();
}

// Send the task as a JSON response
header('Content-Type: application/json');
echo json_encode($task);
?>
