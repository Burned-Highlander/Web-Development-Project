<?php
// Establish a database connection
$host = 'localhost';
$db = 'task_manager';
$user = 'root';
$password = '';

$mysqli = new mysqli($host, $user, $password, $db);

// Get the task ID from the AJAX request
$id = $_POST['id'];

// Delete the task from the database based on the ID
$query = "DELETE FROM tasks WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id);
$result = $stmt->execute();

// Check if the task was deleted successfully
if ($result) {
    echo "Task deleted successfully!";
} else {
    echo "Error deleting task: " . $stmt->error;
}

// Close the statement and database connection
$stmt->close();
$mysqli->close();
?>
