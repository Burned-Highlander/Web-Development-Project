<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);

// Establish a database connection
$host = 'localhost';
$db = 'task_manager';
$user = 'root';
$password = '';

$mysqli = new mysqli($host, $user, $password, $db);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve the task details from the request
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$dueDate = $_POST['dueDate'];
$reminderTime = $_POST['reminderTime'];
$status = $_POST['status'];
$priority = $_POST['priority'];

// Prepare and execute the SQL query to update the task
$stmt = $mysqli->prepare("UPDATE tasks SET title=?, description=?, dueDate=?, reminderTime = ?, status=?, priority = ? WHERE id=?");
$stmt->bind_param("ssssssi", $title, $description, $dueDate, $reminderTime, $status, $priority, $id);
$result = $stmt->execute();

if ($result === TRUE) {
    echo "Task updated successfully";
} else {
    echo "Error updating task: " . $mysqli->error;
}

// Close the database connection
$stmt->close();
$mysqli->close();
?>
