<?php
error_reporting(E_ALL);
ini_set("display_errors",1);


// Establish a database connection
$host = 'localhost';
$db = 'task_manager';
$user = 'root';
$password = '';

$mysqli = new mysqli($host, $user, $password, $db);

// Get the task details from the AJAX request
$title = $_POST['title'];
$description = $_POST['description'];
$dueDate = $_POST['dueDate'];
$reminderTime = $_POST['reminderTime'];
$status = $_POST['status'];
$priority = $_POST['priority'];


// Insert the new task into the database
$query = "INSERT INTO tasks (title, description, dueDate, reminderTime, status, priority) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssssss", $title, $description, $dueDate, $reminderTime, $status, $priority);
$result = $stmt->execute();

// Check if the task was inserted successfully
if ($result) {
    echo "Task added successfully!";
} else {
    echo "Error adding task: " . $stmt->error;
}

// Close the statement and database connection
$stmt->close();
$mysqli->close();
?>
